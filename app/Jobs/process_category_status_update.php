<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$response = $categoryController->changeStatus(Utilities::sanitize($_POST['category_id']));

echo $response;