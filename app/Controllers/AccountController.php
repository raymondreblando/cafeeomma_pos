<?php 

namespace App\Controllers;

use stdClass;
use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use App\Utils\FileUpload;

class AccountController extends FileUpload implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    parent::__construct('../../uploads/users/');
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `accounts` WHERE NOT `role_id` = ? AND NOT `account_status` = ? ORDER BY `account_status` ASC", ['b2fd54eb-4e49-11ee-8673-088fc30176f9', 'deleted']);
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $this->helper->query("SELECT * FROM `accounts` WHERE `user_id` = ?", [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    if(strlen($data['contact_number']) < 11) return Utilities::response('error', 'Input 11 digit contact number');

    $this->helper->query("SELECT * FROM `accounts` WHERE `username` = ?", [$data['username']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Username is taken');

    $this->helper->query("SELECT * FROM `accounts` WHERE `contact_number` = ?", [$data['contact_number']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Contact number exist');

    $this->setFile($_FILES['profile']);

    $account_id = Utilities::uuid();
    $profile = $this->isUploading() ? 1 : 0;
    $this->helper->startTransaction();

    $this->helper->query("INSERT INTO `accounts` (`user_id`, `fullname`, `username`, `gender`, `contact_number`, `address`, `password`, `role_id`, `account_status`, `profile`, `date_created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp())", [$account_id, $data['employee_name'], $data['username'], $data['gender'], $data['contact_number'], $data['address'], Utilities::hashPassword($data['username']), 'b2fd6f62-4e49-11ee-8673-088fc30176f9', 'active', $profile]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'Account not created');

    $file = $account_id.".jpg";
    if($this->isUploading() && !$this->isUploadSuccess($file)){
      $this->helper->rollback();
      return Utilities::response('error', 'Account not created');
    }

    $this->helper->commit();
    return Utilities::response('success', 'Account created');
  }

  public function update(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    if(strlen($data['contact_number']) < 11) return Utilities::response('error', 'Input 11 digit contact number');

    $this->helper->query("SELECT * FROM `accounts` WHERE `user_id` = ?", [$data['aid']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $this->helper->query("SELECT * FROM `accounts` WHERE `username` = ? AND NOT `user_id` = ?", [$data['username'], $data['aid']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Username is taken');

    $this->helper->query("SELECT * FROM `accounts` WHERE `contact_number` = ? AND NOT `user_id` = ?", [$data['contact_number'], $data['aid']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Contact number exist');

    $this->setFile($_FILES['profile']);

    $this->helper->startTransaction();

    if(!$this->isUploading()){
      $this->helper->query("UPDATE `accounts` SET `fullname` = ?, `username` = ?, `gender` = ?, `contact_number` = ?, `address` = ? WHERE `user_id` = ?", [$data['employee_name'], $data['username'], $data['gender'], $data['contact_number'], $data['address'], $data['aid']]);

      $this->helper->commit();
      return Utilities::response('success', 'Account updated');
    }

    $this->helper->query("UPDATE `accounts` SET `fullname` = ?, `username` = ?, `gender` = ?, `contact_number` = ?, `address` = ?, `profile` = ? WHERE `user_id` = ?", [$data['employee_name'], $data['username'], $data['gender'], $data['contact_number'], $data['address'], 1, $data['aid']]);

    $file = $data['aid'].".jpg";
    if($this->isUploading() && !$this->isUploadSuccess($file)){
      $this->helper->rollback();
      return Utilities::response('error', 'Account not updated');
    }

    $this->helper->commit();
    return Utilities::response('success', 'Account updated');
  }

  public function delete(string $id): string
  {
    if(empty($id)) {
      return Utilities::response('error', 'An error occurred');
    } 

    $this->helper->query('SELECT * FROM `accounts` WHERE `user_id` = ?', [$id]);
    
    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred');
    }

    $this->helper->query('UPDATE `accounts` SET `account_status` = ? WHERE `user_id` = ?', ['deleted', $id]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred');
    }

    return Utilities::response('success', 'Account was deleted');
  }
}