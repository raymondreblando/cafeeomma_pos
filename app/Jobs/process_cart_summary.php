<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$data = array();

foreach($_POST as $key => $value){
  $data[$key] = Utilities::sanitize($value);
}

$total_amount = 0;
$total_vat = 0;
$highestOrderPrice = 0;

$helper->query("SELECT * FROM `cart`");

foreach($helper->fetchAll() as $cart_item){
  $total_vat += $cart_item->vat * $cart_item->quantity;
  $highestOrderPrice =($cart_item->amount + $cart_item->vat) > $highestOrderPrice ? ($cart_item->amount + $cart_item->vat) : $highestOrderPrice;
  $total_amount += $cart_item->amount * $cart_item->quantity;
}

$total_amount += $total_vat;
$discount = number_format($highestOrderPrice * $data['discount'], 2);
$total_amount -= $discount;
$change = number_format($data['cash'] - $total_amount, 2);

$helper->query("SELECT * FROM `cart_summary`");

if($helper->rowCount() < 1){
  $helper->query("INSERT INTO `cart_summary` (`amount`, `vat`, `discount`, `cash`, `order_change`) VALUES (?, ?, ?, ?, ?)", [$total_amount, $total_vat, $discount, $data['cash'], $change]);
} else {
  $helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$total_amount, $total_vat, $discount, $data['cash'], $change]);
}

echo Utilities::response('success', 'fetch');