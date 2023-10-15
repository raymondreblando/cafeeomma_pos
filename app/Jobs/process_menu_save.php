<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$data = array();

$sizes = isset($_POST['size']) ? $_POST['size'] : [];
$size_prices = isset($_POST['size_price']) ? $_POST['size_price'] : [];

if(isset($_POST['size'])) unset($_POST['size']);
if(isset($_POST['size_price'])) unset($_POST['size_price']);

foreach($_POST as $key => $value){
  $data[$key] = Utilities::sanitize($value);
}

$data['size'] = $sizes;
$data['size_price'] = $size_prices;

$response = $menuController->insert($data);

echo $response;