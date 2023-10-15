<?php

require_once __DIR__.'/../../config/init.php';

use App\Utils\Utilities;

$helper->query("SELECT * FROM `accounts` WHERE `user_id` = ?", [Utilities::sanitize($_POST['account_id'])]);

if($helper->rowCount() > 0){
  $account_data = $helper->fetch();
  $status = $account_data->account_status == 'active' ? 'deactivated' : 'active';
  $message = $account_data->account_status == 'active' ? 'Account deactivated' : 'Account activated';

  $helper->query("UPDATE `accounts` SET `account_status` = ? WHERE `user_id` = ?", [$status, Utilities::sanitize($_POST['account_id'])]);
  echo Utilities::response('success', $message);
} else{
  echo Utilities::response('error', 'An error occurred');
}