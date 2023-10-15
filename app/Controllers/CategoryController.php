<?php 

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;

class CategoryController
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `categories` ORDER BY `id` DESC");
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): string
  {
    $this->helper->query("SELECT * FROM `categories` WHERE `category_id` = ?", [$id]);
    $category_data = $this->helper->fetch();

    return Utilities::response('success', $category_data->category_name);
  }

  public function insert(string $name): string
  {
    if(empty($name)) return Utilities::response("error", "Enter category name");

    $this->helper->query("SELECT * FROM `categories` WHERE `category_name` = ?", [$name]);
    if($this->helper->rowCount() > 0) return Utilities::response("error", "Category exist");

    $this->helper->query("INSERT INTO `categories` (`category_id`, `category_name`, `date_created`) VALUES (?, ?, current_timestamp())", [Utilities::uuid(), $name]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'Category not saved');

    return Utilities::response('success', 'Category saved');
  }

  public function update(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'Enter category name');
    }

    $this->helper->query("SELECT * FROM `categories` WHERE `category_id` = ?", [$data['category_id']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $this->helper->query("SELECT * FROM `categories` WHERE `category_name` = ?", [$data['category_name']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Category exist');

    $this->helper->query("UPDATE `categories` SET `category_name` = ? WHERE `category_id` = ?", [$data['category_name'], $data['category_id']]);

    return Utilities::response('success', 'Category updated');
  }
}