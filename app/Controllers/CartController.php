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
    if(isset($data['size_id']) && empty($data['size_id'])) return Utilities::response('error', 'Select a size');
    if(empty($data['menu_id'])) return Utilities::response('error', 'An error occurred');

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_id` = ?", [$data['menu_id']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $menu_data = $this->helper->fetch();

    if(isset($data['size_id']))
      $this->helper->query("SELECT * FROM `cart` WHERE `menu_id` = ? AND `size_id` = ?", [$data['menu_id'], $data['size_id']]);
    else
      $this->helper->query("SELECT * FROM `cart` WHERE `menu_id` = ?", [$data['menu_id']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Already added');

    if(isset($data['size_id']) && !empty($data['size_id'])){
      $this->helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$data['size_id']]);
      $size_data = $this->helper->fetch();
    }

    $amount = isset($size_data) ? $size_data->size_price : $menu_data->menu_price;

    if(isset($data['size_id'])){
      $this->helper->query("INSERT INTO `cart` (`cart_id`, `menu_id`, `quantity`, `amount`, `size_id`, `date_created`) VALUES (?, ?, ?, ?, ?, current_timestamp())", [Utilities::uuid(), $data['menu_id'], 1, $amount, $data['size_id']]);
    } else{
      $this->helper->query("INSERT INTO `cart` (`cart_id`, `menu_id`, `quantity`, `amount`, `date_created`) VALUES (?, ?, ?, ?, current_timestamp())", [Utilities::uuid(), $data['menu_id'], 1, $amount]);
    }

    if($this->helper->rowCount() < 1) return Utilities::response('error', 'Item not added');

    $total_amount = 0;

    $this->helper->query("SELECT * FROM `cart`");

    foreach($this->helper->fetchAll() as $cart_item){
      $total_amount += $cart_item->amount * $cart_item->quantity;
    }

    $vat = number_format($total_amount * (5/100), 2);
    $total_amount += $vat;

    $this->helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$total_amount, $vat, 0, 0, 0]);

    return Utilities::response('success', 'Menu added');
  }

  public function update(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'An error occurred');
    }

    $this->helper->query("SELECT * FROM `cart` WHERE `cart_id` = ?", [$data['cart_id']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $cart_data = $this->helper->fetch();

    if($data['type'] == 'minus' && $cart_data->quantity > 1){
      $this->helper->query("UPDATE `cart` SET `quantity` = ? WHERE `cart_id` = ?", [$cart_data->quantity - 1, $data['cart_id']]);

      $total_amount = 0;
      $this->helper->query("SELECT * FROM `cart`");

      foreach($this->helper->fetchAll() as $cart_item){
        $total_amount += $cart_item->amount * $cart_item->quantity;
      }

      $vat = number_format($total_amount * (5/100), 2);
      $total_amount += $vat;

      $this->helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$total_amount, $vat, 0, 0, 0]);

      return Utilities::response('success', 'success');
    }

    if($data['type'] == 'minus' && $cart_data->quantity <= 1){
      $this->helper->query("DELETE FROM `cart` WHERE `cart_id` = ?", [$data['cart_id']]);

      $total_amount = 0;
      $this->helper->query("SELECT * FROM `cart`");

      foreach($this->helper->fetchAll() as $cart_item){
        $total_amount += $cart_item->amount * $cart_item->quantity;
      }

      $vat = number_format($total_amount * (5/100), 2);
      $total_amount += $vat;

      $this->helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$total_amount, $vat, 0, 0, 0]);

      return Utilities::response('success', 'success');
    }

    $this->helper->query("SELECT SUM(quantity) AS item_count FROM `cart` WHERE `menu_id` = ?", [$cart_data->menu_id]);
    $item_count = $this->helper->fetch();

    $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ?", [$cart_data->menu_id]);
    $inventory_data = $this->helper->fetch();

    if(($item_count->item_count + 1) > $inventory_data->inventory_stocks) return Utilities::response('error', 'Stock left is '.($inventory_data->inventory_stocks - ($item_count->item_count)));

    $this->helper->query("UPDATE `cart` SET `quantity` = ? WHERE `cart_id` = ?", [$cart_data->quantity + 1, $data['cart_id']]);

    $total_amount = 0;
    $this->helper->query("SELECT * FROM `cart`");

    foreach($this->helper->fetchAll() as $cart_item){
      $total_amount += $cart_item->amount * $cart_item->quantity;
    }

    $vat = number_format($total_amount * (5/100), 2);
    $total_amount += $vat;

    $this->helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$total_amount, $vat, 0, 0, 0]);

    return Utilities::response('success', 'success');
  }
}