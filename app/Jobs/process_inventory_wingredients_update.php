<?php

require_once __DIR__.'/../../config/init.php';

$response = $inventoryController->updateWithIngredients($_POST);

echo $response;