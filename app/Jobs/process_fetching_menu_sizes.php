<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$menu_id = Utilities::sanitize($_POST['menu_id']);

$helper->query("SELECT `size` FROM `sizes` WHERE `menu_id` = ?", [$menu_id]);

echo Utilities::response('success', json_encode($helper->fetchAll()));