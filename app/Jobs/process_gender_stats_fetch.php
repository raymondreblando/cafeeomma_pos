<?php

require_once __DIR__.'/../../config/init.php';

$data = array();
$data['category'] = array();
$data['total'] = array();


$helper->query("SELECT * FROM `categories`");
$categories = $helper->fetchAll();

foreach ($categories as $category) {
  $data['category'][] = $category->category_name;

  $helper->query('SELECT * FROM menus WHERE `category_id` = ?', [$category->category_id]);
  $count = $helper->rowCount();

  $data['total'][] = $count;
}

echo json_encode($data);