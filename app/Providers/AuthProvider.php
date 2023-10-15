<?php

namespace App\Providers;

use App\Utils\Utilities;
use App\Utils\DbHelper;

class AuthProvider
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function signIn(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'Fill up all fields');
    }

    $this->helper->query("SELECT * FROM `accounts` WHERE `username` = ?", [$data['username']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'Incorrect account credentials');

    $account_data = $this->helper->fetch();

    if(!password_verify($data['password'], $account_data->password)) return Utilities::response('error', 'Incorrect account password');

    if($account_data->account_status == "deactivated") return Utilities::response('error', 'Account deactivated');

    $this->helper->query("INSERT INTO `system_logs` (`user_id`, `type`, `date_created`) VALUES (?, ?, current_timestamp())", [$account_data->user_id, 'Logged In']);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $_SESSION['uid'] = $account_data->user_id;
    $_SESSION['role'] = $account_data->role_id;

    if($account_data->role_id == 'b2fd54eb-4e49-11ee-8673-088fc30176f9') return Utilities::response('success', 'dashboard');

    return Utilities::response('success', 'menus');
  }

  public function signOut(): void
  {
    $this->helper->query("INSERT INTO `system_logs` (`user_id`, `type`, `date_created`) VALUES (?, ?, current_timestamp())", [$_SESSION['uid'], 'Logged Out']);

    session_destroy();
    echo '<script>window.location.href = "'.SYSTEM_URL.'"</script>';
  }

  public function changePassword(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    if($data['new_password'] != $data['confirm_password']) return Utilities::response('error', 'Password not matched');

    $this->helper->query("SELECT * FROM `accounts` WHERE `user_id` = ?", [$_SESSION['uid']]);
    $account_data = $this->helper->fetch();

    if(!password_verify($data['current_password'], $account_data->password)) return Utilities::response('error', 'Incorrect account password');

    $this->helper->query("UPDATE `accounts` SET `password` = ? WHERE `user_id` = ?", [Utilities::hashPassword($data['new_password']), $_SESSION['uid']]);

    return Utilities::response('success', 'Password changed');
  }
}