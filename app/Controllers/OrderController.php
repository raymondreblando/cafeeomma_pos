<?php 

namespace App\Controllers;

use stdClass;
use App\Utils\DbHelper;
use App\Utils\Utilities;

class OrderController
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `orders` ORDER BY `id` DESC");
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $this->helper->query("SELECT * FROM `orders` WHERE `order_id` = ?", [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'Enter cash amount');
    }

    $this->helper->query("SELECT * FROM `cart_summary`");
    $summary_data = $this->helper->fetch();

    if($summary_data->cash < $summary_data->amount) return Utilities::response('error', 'Cash entered was insufficient');

    $total_amount = 0;
    $total_vat = 0;
    $order_quantity = 0;

    $this->helper->query("SELECT * FROM `cart` c LEFT JOIN `menus` m ON c.menu_id=m.menu_id");
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'No item was added');

    $this->helper->startTransaction();
    $order_id = Utilities::uuid();

    foreach($this->helper->fetchAll() as $cart_item){
      $total_vat += $cart_item->vat * $cart_item->quantity;
      $price = 0;
      $order_quantity += $cart_item->quantity;

      if(!empty($cart_item->size_id)){
        $this->helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$cart_item->size_id]);
        $size_data = $this->helper->fetch();
        $selected_size = $size_data->size;
        $price = $size_data->size_price;
        $total_amount += $size_data->size_price * $cart_item->quantity;

        $this->helper->query("SELECT * FROM `ingredient_cost` ic LEFT JOIN `ingredients` i ON ic.ing_id=i.ing_id WHERE ic.menu_id = ? AND ic.size_id = ?", [$cart_item->menu_id, $cart_item->size_id]);
        $sizeIngredients = $this->helper->fetchAll();

        foreach ($sizeIngredients as $sizeIngredient) {
          if ($sizeIngredient->ing_amount > $sizeIngredient->ing_stocks) {
            return Utilities::response('error', 'Some beverage order has insufficient ingredients');
          }
        }
      } else{
        $price = $cart_item->menu_price;
        $total_amount +=  $cart_item->menu_price * $cart_item->quantity;
      }

      $this->helper->query("INSERT INTO `orderred_items` (`order_id`, `menu_id`, `amount`, `quantity`, `size_id`, `date_added`) VALUES (?, ?, ?, ?, ?, current_timestamp())", [$order_id, $cart_item->menu_id, $price, $cart_item->quantity, $cart_item->size_id]);

      if($this->helper->rowCount() < 1){
        $this->helper->rollback();
        return Utilities::response('error', 'An error occurred');
      }

      if(!empty($cart_item->size_id)) {
        foreach ($sizeIngredients as $sizeIngredient) {
          $totalIngredientAmount = $sizeIngredient->ing_amount * $cart_item->quantity;
          $this->helper->query("UPDATE `ingredients` SET `ing_stocks` = ? WHERE `ing_id` = ?", [$sizeIngredient->ing_stocks - $totalIngredientAmount, $sizeIngredient->ing_id]);

          if($this->helper->rowCount() < 1){
            $this->helper->rollback();
            return Utilities::response('error', 'An error occurred');
          }

          $this->helper->query("SELECT * FROM `ingredients` WHERE `ing_id` = ?", [$sizeIngredient->ing_id]);
          $ingredientData = $this->helper->fetch();

          $this->helper->query("UPDATE `ingredients` SET `ing_unit` = ? WHERE `ing_id` = ?", [Utilities::convertUnitValue($ingredientData->ing_stocks, $ingredientData->ing_unit), $ingredientData->ing_id]);

          if($ingredientData->ing_stocks <= $ingredientData->reorder_level){
            $this->helper->query("INSERT INTO `notifications` (`referrence_id`, `notif_type`, `status`, `date_created`) VALUES (?, ?, ?, current_timestamp())", [$ingredientData->ing_id, 'Ingredients', 'Unread']);
          }
        }
      } else {
        $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ?", [$cart_item->menu_id]);
        $inventory_data = $this->helper->fetch();
  
        $this->helper->query("UPDATE `inventory` SET `inventory_stocks` = ? WHERE `menu_id` = ?", [$inventory_data->inventory_stocks - $cart_item->quantity, $cart_item->menu_id]);
        if($this->helper->rowCount() < 1){
          $this->helper->rollback();
          return Utilities::response('error', 'An error occurred');
        }
  
        $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ?", [$cart_item->menu_id]);
        $inventory_data = $this->helper->fetch();
  
        if($inventory_data->inventory_stocks <= $inventory_data->reorder_level){
          $this->helper->query("INSERT INTO `notifications` (`referrence_id`, `notif_type`, `status`, `date_created`) VALUES (?, ?, ?, current_timestamp())", [$cart_item->menu_id, 'Menu', 'Unread']);
        }
      }

      $this->helper->query("DELETE FROM `cart` WHERE `cart_id` = ?", [$cart_item->cart_id]);
      if($this->helper->rowCount() < 1){
        $this->helper->rollback();
        return Utilities::response('error', 'An error occurred');
      }
    }

    $total_amount += $total_vat;
    $discount = isset($data['discount']) ? number_format($total_amount * $data['discount'], 2) : 0; 
    $total_amount -= $discount;
    $change = number_format($data['cash'] - $total_amount, 2);

    $this->helper->query("INSERT INTO `orders` (`order_id`, `order_no`, `order_quantity`, `amount`, `discount`, `vat`, `cash`, `order_change`, `order_status`, `date_added`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp())", [$order_id, Utilities::generateOrderNo(), $order_quantity, $total_amount, $discount, $total_vat, $data['cash'], $change, 'Completed']);

    if($this->helper->rowCount() < 1){
      $this->helper->rollback();
      return Utilities::response('error', 'An error occurred');
    }

    $this->helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [0, 0, 0, 0, 0]);
    if($this->helper->rowCount() < 1){
      $this->helper->rollback();
      return Utilities::response('error', 'An error occurred');
    }

    $this->helper->commit();
    return Utilities::response("success", "Order saved");
  }
}