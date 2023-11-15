<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$response = $accountController->delete( Utilities::sanitize($_POST['account_id']));

echo $response;