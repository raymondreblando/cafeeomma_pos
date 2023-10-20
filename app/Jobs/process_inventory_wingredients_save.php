<?php

require_once __DIR__.'/../../config/init.php';

$response = $inventoryController->insertWithIngredients($_POST);

echo $response;