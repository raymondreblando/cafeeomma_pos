<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Add Inventory";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');
  require('./app/Views/partials/_notification.php');

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
              <p class="text-xs font-semibold text-black leading-none">Add New Inventory</p>
              <p class="text-[10px] font-semibold text-black/60">Stay organized and well-stocked</p>
            </div>
          </div>
          <div class="flex gap-4 mb-4 pl-2">
            <button type="button" class="inv_tabs active">No Ingredients</button>
            <button type="button" class="inv_tabs">With Ingredients</button>
          </div>
          <form autocomplete="off" id="save-inventory-form">
            <select name="menu" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3">
              <option value="">Select Menu</option>

              <?php foreach($menuController->show() as $menu): ?>

                <option value="<?= $menu->menu_id ?>"><?= $menu->menu_name ?></option>

              <?php endforeach ?>

            </select>
            <div class="grid md:grid-cols-2 gap-3">
              <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="stocks" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter menu stocks">
              </div>
              <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="reorder_level" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter reorder level">
              </div>
            </div>
            <button type="submit" id="save-inventory-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Save</button>
          </form>
          <form autocomplete="off" id="save-inventorywing-form" class="hidden">
            <div class="flex items-center justify-between flex-wrap gap-4 my-2 px-2">
              <p class="text-[10px] text-black/60 font-semibold">Ingredients</p>
              <button type="button" class="add-ingredient text-[10px] font-semibold text-primary">Add Ingredient</button>
            </div>
            <div class="ingredient-wrapper grid grid-cols-2 gap-3 mb-4">
              <select name="ingredients[]" class="ingredient-select appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full">
                <option value="">Select Ingredient</option>
  
                <?php foreach($ingredientController->show() as $ingredient): ?>
  
                  <option value="<?= $ingredient->ing_id ?>"><?= $ingredient->ing_name ?></option>
  
                <?php endforeach ?>
  
              </select>
            </div>
            <select name="menu" id="menu-select" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3">
              <option value="">Select Menu</option>

              <?php foreach($menuController->show() as $menu): ?>

                <option value="<?= $menu->menu_id ?>"><?= $menu->menu_name ?></option>

              <?php endforeach ?>

            </select>
            <div class="menu-sizes-wrapper">
              
            </div>
            <button type="submit" id="save-inventorywing-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Save</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>