<?php 

namespace App\Controllers;

use stdClass;
use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;

class IngredientController implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `ingredients` ORDER BY `id` DESC");
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $this->helper->query("SELECT * FROM `ingredients` WHERE `ing_id` = ?", [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    $this->helper->query("SELECT * FROM `ingredients` WHERE `ing_name` = ?", [$data['ing_name']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Ingredient already exist');

    $ingredient_stocks = Utilities::convertUnit($data['ing_stocks'], $data['ing_unit']);
    $reorder_level = Utilities::convertUnit($data['ing_reorder_level'], $data['reorder_unit']);

    $this->helper->query("INSERT INTO `ingredients` (`ing_id`, `ing_name`, `ing_stocks`, `ing_unit`, `reorder_level`, `reorder_unit`) VALUES (?, ?, ?, ?, ?, ?)", [Utilities::uuid(), $data['ing_name'], $ingredient_stocks, $data['ing_unit'], $reorder_level, $data['reorder_unit']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'Ingredient not saved');
    
    return Utilities::response('success', 'Ingredient saved');
  }

  public function update(array $data): string
  {
    foreach($data as $field){
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    $this->helper->query("SELECT * FROM `ingredients` WHERE `ing_id` = ?", [$data['iid']]);
    if($this->helper->rowCount() < 1) return Utilities::response('error', 'An error occurred');

    $oldIngredientData = $this->helper->fetch();

    $this->helper->query("SELECT * FROM `ingredient_cost` WHERE `ing_id` = ? GROUP BY `menu_id`", [$data['iid']]);
    $cost_count = $this->helper->rowCount();
    if ($cost_count > 0) {
      $cost_datas = $this->helper->fetchAll();
    }

    $this->helper->query("SELECT * FROM `ingredients` WHERE `ing_name` = ? AND NOT `ing_id` = ?", [$data['ing_name'], $data['iid']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Ingredient already exist');

    $ingredient_stocks = Utilities::convertUnit($data['ing_stocks'], $data['ing_unit']);
    $reorder_level = Utilities::convertUnit($data['ing_reorder_level'], $data['reorder_unit']);

    $this->helper->startTransaction();

    $this->helper->query("UPDATE `ingredients` SET `ing_name` = ?, `ing_stocks` = ?, `ing_unit` = ?, `reorder_level` = ?, `reorder_unit` = ? WHERE `ing_id` = ?", [$data['ing_name'], $ingredient_stocks, $data['ing_unit'], $reorder_level, $data['reorder_unit'], $data['iid']]);

    if ($cost_count > 0 && $ingredient_stocks > $oldIngredientData->ing_stocks) {
      foreach ($cost_datas as $cost) {
        $this->helper->query('UPDATE `menus` SET `is_soldout` = ? WHERE `menu_id` = ?', [0, $cost->menu_id]);
  
        if ($this->helper->rowCount() < 1) {
          $this->helper->rollback();
          return Utilities::response('error', 'An error occurred');
        }
      }
    }
    
    $this->helper->commit();
    return Utilities::response('success', 'Ingredient saved');
  }
}