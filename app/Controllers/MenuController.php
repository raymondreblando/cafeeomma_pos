<?php 

namespace App\Controllers;

use stdClass;
use App\Interfaces\AppInterface;
use App\Utils\DbHelper;
use App\Utils\Utilities;
use App\Utils\FileUpload;

class MenuController extends FileUpload implements AppInterface
{
  private $helper;

  public function __construct(DbHelper $helper)
  {
    parent::__construct('../../uploads/menus/');
    $this->helper = $helper;
  }

  public function show(): array
  {
    $this->helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE c.category_status = ? AND m.menu_status = ? ORDER BY m.is_soldout", [1, 1]);
    return $this->helper->fetchAll();
  }

  public function showOne(string $id): stdClass
  {
    $this->helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE m.menu_id = ?", [$id]);
    return $this->helper->fetch();
  }

  public function insert(array $data): string
  {
    $sizes = $data['size'];
    $size_prices = $data['size_price'];
    unset($data['size']);
    unset($data['size_price']);

    foreach ($data as $field) {
      if(empty($field)) return Utilities::response('error', 'All fields are required');
    }

    if (isset($sizes)) {
      foreach ($sizes as $size) {
        if (empty($size)) {
          return Utilities::response('error', 'Enter the size');
        } 
      }
    }

    if (isset($size_prices)) {
      foreach ($size_prices as $size_price) {
        if (empty($size_price)) {
          return Utilities::response('error', 'Enter the size price');
        } 
      }
    }

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_name` = ? AND `menu_status` = ?", [$data['menu_name'], 1]);
    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Menu exist');
    } 

    $this->setFile($_FILES['menu_img']);

    if (!$this->isUploading()) {
      return Utilities::response('error', 'Upload menu image');
    } 

    $menu_id = Utilities::uuid();
    $this->helper->startTransaction();

    $this->helper->query("INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_price`, `category_id`, `date_created`) VALUES (?, ?, ?, ?, current_timestamp())", [$menu_id, $data['menu_name'], $data['menu_price'], $data['category']]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'Menu not saved');
    } 

    if (isset($sizes) && !empty($sizes[0])) {
      foreach ($sizes as $key => $value) {
        $size_id = Utilities::uuid();

        $this->helper->query("INSERT INTO `sizes` (`size_id`, `menu_id`, `size`, `size_price`, `date_created`) VALUES (?, ?, ?, ?, current_timestamp())", [$size_id, $menu_id, $sizes[$key], $size_prices[$key]]);

        if ($this->helper->rowCount() < 1) {
          $this->helper->rollback();
          return Utilities::response('error', 'Menu not saved');
        } 
      }
    }

    $file = $menu_id.".png";
    if (!$this->isUploadSuccess($file)) {
      $this->helper->rollback();
      return Utilities::response('error', 'Menu not saved');
    }

    $this->helper->commit();
    return Utilities::response('success', 'Menu saved');
  }

  public function update(array $data): string
  {
    $size_ids = $data['sid'];
    $sizes = $data['size'];
    $size_prices = $data['size_price'];
    unset($data['sid']);
    unset($data['size']);
    unset($data['size_price']);

    foreach ($data as $field) {
      if (empty($field)) {
        return Utilities::response('error', 'All fields are required');
      } 
    }

    if (isset($sizes)) {
      foreach ($sizes as $size) {
        if (empty($size)) {
          return Utilities::response('error', 'Enter the size');
        } 
      }
    }

    if (isset($size_prices)) {
      foreach ($size_prices as $size_price) {
        if (empty($size_price)) {
          return Utilities::response('error', 'Enter the size price');
        } 
      }
    }

    $this->helper->query("SELECT * FROM `menus` WHERE `menu_name` = ? AND `menu_status` = ? AND NOT `menu_id` = ?", [$data['menu_name'], 1, $data['mid']]);
    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Menu exist');
    } 

    $this->setFile($_FILES['menu_img']);
    $this->helper->startTransaction();

    $this->helper->query("UPDATE `menus` SET `menu_name` = ?, `menu_price` = ?, `category_id` = ? WHERE `menu_id` = ?", [$data['menu_name'], $data['menu_price'], $data['category'], $data['mid']]);

    if (isset($sizes) && !empty($sizes[0])) {
      foreach ($sizes as $key => $value) {
        $this->helper->query("UPDATE `sizes` SET `size` = ?, `size_price` = ? WHERE `menu_id` = ? AND `size_id` = ?", [$sizes[$key], $size_prices[$key], $data['mid'], $size_ids[$key]]);
      }
    }

    $file = $data['mid'].".png";
    if($this->isUploading() && !$this->isUploadSuccess($file)){
      $this->helper->rollback();
      return Utilities::response('error', 'Menu not saved');
    }

    $this->helper->commit();
    return Utilities::response('success', 'Menu updated');
  }

  public function showWithFilter(string $filter): array
  {
    if ($filter === 'alphabetical') {
      $this->helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE c.category_status = ? AND m.menu_status = ? ORDER BY m.menu_name ASC", [1, 1]);
    } elseif ($filter === 'price-asc') {
      $this->helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE c.category_status = ? AND m.menu_status = ? ORDER BY m.menu_price DESC", [1, 1]);
    } elseif ($filter === 'price-desc') {
      $this->helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE c.category_status = ? AND m.menu_status = ? ORDER BY m.menu_price ASC", [1, 1]);
    } else {
      $this->helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE c.category_status = ? AND m.menu_status = ? ORDER BY m.id DESC", [1, 1]);
    }

    return $this->helper->fetchAll();
  }

  public function delete(string $id): string
  {
    if (empty($id)) {
      return Utilities::response('error', 'An error occurred');
    }

    $this->helper->query('UPDATE `menus` SET `menu_status` = ? WHERE `menu_id` = ?', [0, $id]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occurred');
    }

    return Utilities::response('success', 'Menu was deleted');
  }
}