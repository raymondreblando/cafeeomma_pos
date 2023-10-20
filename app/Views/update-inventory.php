<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Update Inventory";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

  $inventory_data = $inventoryController->showOne(Utilities::sanitize($id));

?>

  <main class="min-h-screen grid md:grid-cols-[11rem_auto] bg-light-gray">

    <?php require('./app/Views/partials/_sidebar.php') ?>

    <section>

      <?php require('./app/Views/partials/_topnav.php') ?>

      <div class="min-h-[calc(100vh-4.5rem)] flex items-center justify-center pt-20 md:pt-5 pb-5 px-8">
        <div class="w-[min(30rem,100%)] bg-white rounded-2xl p-6">
          <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
            <a href="<?php echo SYSTEM_URL ?>menu-inventory" class="text-xs font-medium text-black bg-light-gray py-2 px-4 rounded-full">
              <i class="ri-arrow-left-s-line"></i>
              Back
            </a>
            <div class="md:text-right">
              <p class="text-xs font-semibold text-black leading-none">Update Inventory</p>
              <p class="text-[10px] font-semibold text-black/60">Maintain accurate inventory records</p>
            </div>
          </div>

          <?php 
            if ($inventory_data->inventory_stocks > 0) { 
          ?>

            <form autocomplete="off" id="update-inventory-form">
              <input type="hidden" name="iid" value="<?php echo $inventory_data->inventory_id ?>">
              <select name="menu" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3">
                <option value="">Select Menu</option>

                <?php foreach($menuController->show() as $menu): ?>

                <option value="<?= $menu->menu_id ?>" <?php echo $inventory_data->menu_id == $menu->menu_id ? "selected" : "" ?>><?= $menu->menu_name ?></option>

                <?php endforeach ?>

              </select>
              <div class="grid md:grid-cols-2 gap-3">
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                  <input type="text" name="stocks" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter menu stocks" value="<?php echo $inventory_data->inventory_stocks ?>">
                </div>
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                  <input type="text" name="reorder_level" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter reorder level" value="<?php echo $inventory_data->reorder_level ?>">
                </div>
              </div>
              <button type="submit" id="update-inventory-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Update</button>
            </form>

          <?php 
            } else { 
              $helper->query("SELECT * FROM `ingredient_cost` WHERE `menu_id` = ? GROUP BY `ing_id`", [$inventory_data->menu_id]);
              $menu_ingredients = $helper->fetchAll();

              $helper->query("SELECT * FROM `sizes` WHERE `menu_id` = ?", [$inventory_data->menu_id]);
              $menu_sizes = $helper->fetchAll();
          ?>

            <form autocomplete="off" id="update-inventorywing-form">
              <input type="hidden" name="iid" value="<?php echo $inventory_data->inventory_id ?>">
              <input type="hidden" name="menu" value="<?php echo $inventory_data->menu_id ?>">
              <div class="flex items-center justify-between flex-wrap gap-4 my-2 px-2">
                <p class="text-[10px] text-black/60 font-semibold">Ingredients</p>
              </div>
              <div class="ingredient-wrapper grid grid-cols-2 gap-3 mb-4">

                <?php foreach ($menu_ingredients as $menu_ingredient) : ?>

                  <select name="ingredients[]" class="ingredient-select appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full disabled:cursor-not-allowed" disabled>
                    <option value="">Select Ingredient</option>
      
                    <?php foreach($ingredientController->show() as $ingredient): ?>
      
                      <option value="<?= $ingredient->ing_id ?>" <?= $menu_ingredient->ing_id == $ingredient->ing_id ? "selected" : "" ?>><?= $ingredient->ing_name ?></option>
      
                    <?php endforeach ?>
      
                  </select>

                <?php endforeach ?>

              </div>
              <select name="menu" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3 disabled:cursor-not-allowed" disabled>
                <option value="">Select Menu</option>

                <?php foreach($menuController->show() as $menu): ?>

                  <option value="<?= $menu->menu_id ?>" <?= $inventory_data->menu_id == $menu->menu_id ? "selected" : "" ?>><?= $menu->menu_name ?></option>

                <?php endforeach ?>

              </select>
              <div class="menu-sizes-wrapper">

                <?php 
                  foreach ($menu_sizes as $menu_size) : 
                    $helper->query("SELECT * FROM `ingredient_cost` WHERE `size_id` = ?", [$menu_size->size_id]);
                ?>

                      <div>
                        <p class="text-[10px] text-black/60 font-semibold pl-2 mb-2"><?= $menu_size->size ?> Ingredient Amount</p>
                        <div class="grid grid-cols-2 gap-3 mb-3">

                          <?php foreach ($helper->fetchAll() as $index => $sizeIngredient) : ?>

                            <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                              <input type="text" name="<?= $menu_size->size ?>[]" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Ingredient <?= $index + 1 ?> amount (eg. 10 ml)" value="<?= Utilities::convertUnit($sizeIngredient->ing_amount, $sizeIngredient->ing_unit, "reverse").Utilities::getEquivalentAcronym($sizeIngredient->ing_unit) ?>">
                            </div>

                          <?php endforeach ?>
                        </div>
                      </div>

                <?php 
                  endforeach 
                ?>

              </div>
              <button type="submit" id="update-inventorywing-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Save</button>
            </form>

          <?php 
            }  
          ?>

        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>