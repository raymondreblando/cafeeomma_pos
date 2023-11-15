<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$order_id = Utilities::sanitize($_POST['order_id']);

$helper->query("SELECT * FROM `orderred_items` o LEFT JOIN `menus` m ON o.menu_id=m.menu_id LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE o.order_id = ?", [$order_id]);
$order_items = $helper->fetchAll();

foreach ($order_items as $key => $item) {
  if (!empty($item->size_id)) {
    $helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$item->size_id]);
    $size_data = $helper->fetch();
    $order_items[$key]->size_name = $size_data->size; 
  } else {
    $order_items[$key]->size_name = "No size available"; 
  }
}

echo json_encode($order_items);