<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$response = $categoryController->insert(Utilities::sanitize($_POST['category_name']));

echo $response;