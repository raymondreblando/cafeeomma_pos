<?php 

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;

class CartController
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `cart` c LEFT JOIN `menus` m ON c.menu_id=m.menu_id LEFT JOIN `categories` ct ON m.category_id=ct.category_id");
    return $this->helper->fetchAll();
  }

  public function insert(array $data): string
  {
    if (isset($data['size_id']) && empty($data['size_id'])) {
      return Utilities::response('error', 'Select a size');
    } 
    if (empty($data['menu_id'])) {
      return Utilities::response('error', 'An error occurred');
    }

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_id` = ?", [$data['menu_id']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred');
    }

    $menu_data = $this->helper->fetch();

    if (isset($data['size_id'])) {
      $this->helper->query("SELECT * FROM `cart` WHERE `menu_id` = ? AND `size_id` = ?", [$data['menu_id'], $data['size_id']]);
    } else {
      $this->helper->query("SELECT * FROM `cart` WHERE `menu_id` = ?", [$data['menu_id']]);
    }
      
    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Already added');
    } 

    if (isset($data['size_id']) && !empty($data['size_id'])) {
      $this->helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$data['size_id']]);
      $size_data = $this->helper->fetch();
    }

    $amount = isset($size_data) ? $size_data->size_price : $menu_data->menu_price;

    if (isset($data['size_id'])) {
      $this->helper->query("INSERT INTO `cart` (`cart_id`, `menu_id`, `quantity`, `amount`, `size_id`, `date_created`) VALUES (?, ?, ?, ?, ?, current_timestamp())", [Utilities::uuid(), $data['menu_id'], 1, $amount, $data['size_id']]);
    } else {
      $this->helper->query("INSERT INTO `cart` (`cart_id`, `menu_id`, `quantity`, `amount`, `date_created`) VALUES (?, ?, ?, ?, current_timestamp())", [Utilities::uuid(), $data['menu_id'], 1, $amount]);
    }

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Item not added');
    } 

    $total_amount = 0;

    $this->helper->query("SELECT * FROM `cart`");

    foreach ($this->helper->fetchAll() as $cart_item) {
      $total_amount += $cart_item->amount * $cart_item->quantity;
    }

    $total_vat = Utilities::calculateVat($total_amount);
    $total_amount += $total_vat;
    $subtotal = $total_amount - $total_vat;

    $this->helper->query("UPDATE `cart_summary` SET `subtotal` = ?, `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$subtotal, $total_amount, $total_vat, 0, 0, 0]);

    return Utilities::response('success', 'Menu added');
  }

  public function update(array $data): string
  {
    if (empty($data['cart_id'])) {
      return Utilities::response('error', 'An error occurred');
    }

    $this->helper->query("SELECT * FROM `cart` WHERE `cart_id` = ?", [$data['cart_id']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $cart_data = $this->helper->fetch();

    $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ?", [$cart_data->menu_id]);
    $inventory_data = $this->helper->fetch();

    if ($inventory_data->inventory_value > 0 && $data['quantity'] > $inventory_data->inventory_stocks) {
      return Utilities::response('error', 'Stock left is '.($inventory_data->inventory_stocks));
    }

    if (!empty($cart_data->size_id)) {
      $this->helper->query("SELECT * FROM `ingredient_cost` WHERE `menu_id` = ? AND `size_id` = ?", [$cart_data->menu_id, $cart_data->size_id]);
      $sizeIngredients = $this->helper->fetchAll();

      foreach ($sizeIngredients as $sizeIngredient) {
        $totalUnit = $sizeIngredient->ing_amount * $data['quantity'];

        $this->helper->query("SELECT * FROM `ingredients` WHERE `ing_id` = ?", [$sizeIngredient->ing_id]);
        $ingredientData = $this->helper->fetch();

        if ($totalUnit > $ingredientData->ing_stocks) {
          return Utilities::response('error', 'Insufficient ingredients');
        }
      }
    }

    if ($data['quantity'] == 0) {
      $this->helper->query("DELETE FROM `cart` WHERE `cart_id` = ?", [$data['cart_id']]);
    } else {
      $this->helper->query("UPDATE `cart` SET `quantity` = ? WHERE `cart_id` = ?", [$data['quantity'], $data['cart_id']]);
    }

    $total_amount = 0;
    $this->helper->query("SELECT * FROM `cart`");

    foreach($this->helper->fetchAll() as $cart_item){
      $total_amount += $cart_item->amount * $cart_item->quantity;
    }

    $total_vat = Utilities::calculateVat($total_amount);
    $total_amount += $total_vat;
    $sub_total = $total_amount - $total_vat;

    $this->helper->query("UPDATE `cart_summary` SET `subtotal` = ?, `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$sub_total, $total_amount, $total_vat, 0, 0, 0]);

    return Utilities::response('success', 'success');
  }
}