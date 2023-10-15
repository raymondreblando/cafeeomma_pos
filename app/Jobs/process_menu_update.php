<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$data = array();

$size_ids = isset($_POST['sid']) ? $_POST['sid'] : [];
$sizes = isset($_POST['size']) ? $_POST['size'] : [];
$size_prices = isset($_POST['size_price']) ? $_POST['size_price'] : [];

if(isset($_POST['sid'])) unset($_POST['sid']);
if(isset($_POST['size'])) unset($_POST['size']);
if(isset($_POST['size_price'])) unset($_POST['size_price']);

foreach($_POST as $key => $value){
  $data[$key] = Utilities::sanitize($value);
}

$data['sid'] = $size_ids;
$data['size'] = $sizes;
$data['size_price'] = $size_prices;

$response = $menuController->update($data);

echo $response;