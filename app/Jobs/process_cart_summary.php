<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$data = array();

foreach($_POST as $key => $value){
  $data[$key] = Utilities::sanitize($value);
}

$subtotal = 0;
$highestOrderPrice = 0;

$helper->query("SELECT * FROM `cart`");

foreach($helper->fetchAll() as $cart_item){
  $highestOrderPrice = $cart_item->amount > $highestOrderPrice ? $cart_item->amount : $highestOrderPrice;
  $subtotal += $cart_item->amount * $cart_item->quantity;
}

$total_vat = Utilities::calculateVat($subtotal);
$total_amount = $subtotal + $total_vat;
$discount = number_format($highestOrderPrice * $data['discount'], 2);
$total_amount -= $discount;
$change = number_format($data['cash'] - $total_amount, 2);

$helper->query("SELECT * FROM `cart_summary`");

if($helper->rowCount() < 1){
  $helper->query("INSERT INTO `cart_summary` (`subtotal` = ?, `amount`, `vat`, `discount`, `cash`, `order_change`) VALUES (?, ?, ?, ?, ?, ?)", [$subtotal, $total_amount, $total_vat, $discount, $data['cash'], $change]);
} else {
  $helper->query("UPDATE `cart_summary` SET `subtotal` = ?, `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$subtotal, $total_amount, $total_vat, $discount, $data['cash'], $change]);
}

echo Utilities::response('success', 'fetch');