<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$helper->query("UPDATE `notifications` SET `status` = ? WHERE `status` = ?", ['Read', 'Unread']);

echo Utilities::response('success', 'success');