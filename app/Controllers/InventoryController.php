<?php 

namespace App\Controllers;

use stdClass;
use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;

class InventoryController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `inventory` i LEFT JOIN `menus` m ON i.menu_id=m.menu_id LEFT JOIN `categories` c ON m.category_id=c.category_id ORDER BY i.id DESC");
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $this->helper->query("SELECT * FROM `inventory` i LEFT JOIN `menus` m ON i.menu_id=m.menu_id WHERE i.inventory_id = ?", [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ?", [$data['menu']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Inventory item exist');

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_id` = ?", [$data['menu']]);
    $menu_data = $this->helper->fetch();

    $inventory_value = $menu_data->menu_price * $data['stocks'];

    $this->helper->query("INSERT INTO `inventory` (`inventory_id`, `menu_id`, `inventory_stocks`, `inventory_value`, `reorder_level`, `date_created`) VALUES (?, ?, ?, ?, ?, current_timestamp())", [Utilities::uuid(), $data['menu'], $data['stocks'], $inventory_value, $data['reorder_level']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'Inventory not saved');
    
    return Utilities::response('success', 'Inventory saved');
  }

  public function update(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    $this->helper->query("SELECT * FROM `inventory` WHERE `inventory_id` = ?", [$data['iid']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ? AND NOT `inventory_id` = ?", [$data['menu'], $data['iid']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Inventory item exist');

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_id` = ?", [$data['menu']]);
    $menu_data = $this->helper->fetch();

    $inventory_value = $menu_data->menu_price * $data['stocks'];

    $this->helper->query("UPDATE `inventory` SET `menu_id` = ?, `inventory_stocks` = ?, `inventory_value` = ?, `reorder_level` = ? WHERE `inventory_id` = ?", [$data['menu'], $data['stocks'], $inventory_value, $data['reorder_level'], $data['iid']]);
    
    return Utilities::response('success', 'Inventory saved');
  }
}