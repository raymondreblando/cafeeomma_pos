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

    $oldInventoryData = $this->helper->fetch();

    $this->helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ? AND NOT `inventory_id` = ?", [$data['menu'], $data['iid']]);
    if($this->helper->rowCount() > 0) return Utilities::response('error', 'Inventory item exist');

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_id` = ?", [$data['menu']]);
    $menu_data = $this->helper->fetch();

    $inventory_value = $menu_data->menu_price * $data['stocks'];

    $this->helper->startTransaction();

    $this->helper->query("UPDATE `inventory` SET `menu_id` = ?, `inventory_stocks` = ?, `inventory_value` = ?, `reorder_level` = ? WHERE `inventory_id` = ?", [$data['menu'], $data['stocks'], $inventory_value, $data['reorder_level'], $data['iid']]);

    if ($data['stocks'] > $oldInventoryData->inventory_stocks) {
      $this->helper->query('UPDATE `menus` SET `is_soldout` = ? WHERE `menu_id` = ?', [0, $data['menu']]);

      if ($this->helper->rowCount() < 1) {
        $this->helper->rollback();
        return Utilities::response('error', 'An error occurred');
      }
    }
    
    $this->helper->commit();
    return Utilities::response('success', 'Inventory saved');
  }

  public function insertWithIngredients(array $data): string
  {
    $inventory_id = Utilities::uuid();
    $menu_id = Utilities::sanitize($data["menu"]);
    $ingredients = $data['ingredients'];
    $ingredientCount = count($ingredients);

    foreach ($ingredients as $ingredient) {
      if (empty($ingredient)) {
        return Utilities::response('error', 'Select an ingredient');
      }
    }

    if (empty($menu_id)) {
      return Utilities::response('error', 'Select a menu');
    }

    $this->helper->startTransaction();

    $this->helper->query("INSERT INTO `inventory` (`inventory_id`, `menu_id`, `date_created`) VALUES (?, ?, current_timestamp())", [$inventory_id, $menu_id]);
    
    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Item cannot be added');
    }

    $this->helper->query("SELECT * FROM `sizes` WHERE `menu_id` = ?", [$menu_id]);
    $sizes = $this->helper->fetchAll();

    if (count($sizes) < 1) {
      $this->helper->rollback();
      return Utilities::response('error', 'Ingredient is not applicable for the item');
    }

    foreach ($sizes as $size) {
      $sizeIngredientAmounts = $data[$size->size];
      for ($index = 0; $index < $ingredientCount; $index++){
        if (empty($sizeIngredientAmounts[$index])) {
          $this->helper->rollback();
          return Utilities::response('error', 'All size ingredient amount is required');
        }

        preg_match('/(\d+)\s*([a-zA-Z]+)/', $sizeIngredientAmounts[$index], $matches);
        $ingAmount = $matches[1];
        $formattedUnit = Utilities::getEquivalentUnitName($matches[2]);
        $ingFinalValue = Utilities::convertUnit($ingAmount, $formattedUnit);

        $this->helper->query('SELECT * FROM `ingredients` WHERE `ing_id` = ?', [$ingredients[$index]]);
        $ingredientData = $this->helper->fetch();

        if (Utilities::isInvalidUnit($formattedUnit, $ingredientData->ing_unit)) {
          $this->helper->rollback();
          return Utilities::response('error', 'Invalid ingredient unit');
        }

        $this->helper->query("INSERT INTO `ingredient_cost` (`menu_id`, `size_id`, `ing_id`, `ing_amount`, `ing_unit`) VALUES (?, ?, ?, ?, ?)", [$menu_id, $size->size_id, $ingredients[$index], $ingFinalValue, $formattedUnit]);

        if ($this->helper->rowCount() < 1) {
          $this->helper->rollback();
          return Utilities::response('error', 'Item cannot be added');
        }
      }
    }
    
    $this->helper->commit();
    return Utilities::response('success', 'Inventory saved');
  }

  public function updateWithIngredients(array $data): string
  {
    $inventory_id = Utilities::sanitize($data["iid"]);
    $menu_id = Utilities::sanitize($data["menu"]);

    if (empty($menu_id)) {
      return Utilities::response('error', 'Select a menu');
    }

    $this->helper->startTransaction();

    $this->helper->query("UPDATE `inventory` SET `menu_id` = ? WHERE `inventory_id` = ?", [$menu_id, $inventory_id]);

    $this->helper->query("SELECT * FROM `sizes` WHERE `menu_id` = ?", [$menu_id]);
    $sizes = $this->helper->fetchAll();

    if (count($sizes) < 1) {
      $this->helper->rollback();
      return Utilities::response('error', 'Ingredient is applicable for the item');
    }

    foreach ($sizes as $size) {
      $this->helper->query("SELECT * FROM `ingredient_cost` WHERE `menu_id` = ? AND `size_id` = ?", [$menu_id, $size->size_id]);
      $ingredientCosts = $this->helper->fetchAll();
      $sizeIngredientAmounts = $data[$size->size];

      foreach ($ingredientCosts as $index => $cost) {
        if (empty($sizeIngredientAmounts[$index])) {
          $this->helper->rollback();
          return Utilities::response('error', 'All size ingredient amount is required');
        }

        preg_match('/(\d+)\s*([a-zA-Z]+)/', $sizeIngredientAmounts[$index], $matches);
        $ingAmount = $matches[1];
        $formattedUnit = Utilities::getEquivalentUnitName($matches[2]);
        $ingFinalValue = Utilities::convertUnit($ingAmount, $formattedUnit);

        $this->helper->query('SELECT * FROM `ingredients` WHERE `ing_id` = ?', [$cost->ing_id]);
        $ingredientData = $this->helper->fetch();

        if (Utilities::isInvalidUnit($formattedUnit, $ingredientData->ing_unit)) {
          $this->helper->rollback();
          return Utilities::response('error', 'Invalid ingredient unit');
        }

        $this->helper->query("UPDATE `ingredient_cost` SET `ing_amount` = ?, `ing_unit` = ? WHERE `id` = ?", [$ingFinalValue, $formattedUnit, $cost->id]);
      }
    }
    
    $this->helper->commit();
    return Utilities::response('success', 'Inventory saved');
  }
}