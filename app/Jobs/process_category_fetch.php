<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$response = $categoryController->showOne(Utilities::sanitize($_POST['category_id']));

echo $response;