<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$data = array();

foreach($_POST as $key => $value){
  $data[$key] = Utilities::sanitize($value);
}

$total_amount = 0;

$helper->query("SELECT * FROM `cart`");

foreach($helper->fetchAll() as $cart_item){
  $total_amount += $cart_item->amount * $cart_item->quantity;
}

$vat = number_format($total_amount * (5/100), 2);
$total_amount += $vat;
$discount = number_format($total_amount * $data['discount'], 2);
$total_amount -= $discount;
$change = number_format($data['cash'] - $total_amount, 2);

$helper->query("SELECT * FROM `cart_summary`");

if($helper->rowCount() < 1){
  $helper->query("INSERT INTO `cart_summary` (`amount`, `vat`, `discount`, `cash`, `order_change`) VALUES (?, ?, ?, ?, ?)", [$total_amount, $vat, $discount, $data['cash'], $change]);
} else {
  $helper->query("UPDATE `cart_summary` SET `amount` = ?, `vat` = ?, `discount` = ?, `cash` = ?, `order_change` = ?", [$total_amount, $vat, $discount, $data['cash'], $change]);
}

echo Utilities::response('success', 'fetch');