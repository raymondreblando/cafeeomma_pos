<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$response = $menuController->delete(Utilities::sanitize($_POST['menu_id']));

echo $response;