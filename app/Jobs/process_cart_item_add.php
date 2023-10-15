<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$data = array();

foreach($_POST as $key => $value){
  $data[$key] = Utilities::sanitize($value);
}

$response = $cartController->insert($data);

echo $response;