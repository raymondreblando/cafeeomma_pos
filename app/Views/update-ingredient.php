<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Update Inventory";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');
  require('./app/Views/partials/_notification.php');

  $ingredient_data = $ingredientController->showOne(Utilities::sanitize($id));

?>

  <main class="min-h-screen grid md:grid-cols-[11rem_auto] bg-light-gray">

    <?php require('./app/Views/partials/_sidebar.php') ?>

    <section>

      <?php require('./app/Views/partials/_topnav.php') ?>

      <div class="min-h-[calc(100vh-4.5rem)] flex items-center justify-center pt-20 md:pt-5 pb-5 px-8">
        <div class="w-[min(30rem,100%)] bg-white rounded-2xl p-6">
          <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
            <a href="<?php echo SYSTEM_URL ?>ingredient-inventory" class="text-xs font-medium text-black bg-light-gray py-2 px-4 rounded-full">
              <i class="ri-arrow-left-s-line"></i>
              Back
            </a>
            <div class="md:text-right">
              <p class="text-xs font-semibold text-black leading-none">Update Inventory</p>
              <p class="text-[10px] font-semibold text-black/60">Maintain accurate inventory records</p>
            </div>
          </div>
          <form autocomplete="off" id="update-ingredient-form">
            <input type="hidden" name="iid" value="<?php echo $ingredient_data->ing_id ?>">
            <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
              <input type="text" name="ing_name" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter ingredient name" value="<?php echo $ingredient_data->ing_name ?>">
            </div>
            <div class="grid md:grid-cols-2 gap-3">
              <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="ing_stocks" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter stocks" value="<?php echo Utilities::convertUnit($ingredient_data->ing_stocks, $ingredient_data->ing_unit, 'reverse') ?>">
              </div>
              <select name="ing_unit" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full">
                <option value="">Select Unit</option>
                <option value="milliliter" <?php echo $ingredient_data->ing_unit == 'milliliter' ? 'selected' : '' ?>>milliliter</option>
                <option value="liter" <?php echo $ingredient_data->ing_unit == 'liter' ? 'selected' : '' ?>>liter</option>
                <option value="milligram" <?php echo $ingredient_data->ing_unit == 'milligram' ? 'selected' : '' ?>>milligram</option>
                <option value="gram" <?php echo $ingredient_data->ing_unit == 'gram' ? 'selected' : '' ?>>gram</option>
                <option value="kilogram" <?php echo $ingredient_data->ing_unit == 'kilogram' ? 'selected' : '' ?>>kilogram</option>
              </select>
              <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="ing_reorder_level" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter reorder level" value="<?php echo Utilities::convertUnit($ingredient_data->reorder_level, $ingredient_data->reorder_unit, 'reverse') ?>">
              </div>
              <select name="reorder_unit" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full">
                <option value="">Select Reorder Unit</option>
                <option value="milliliter" <?php echo $ingredient_data->reorder_unit == 'milliliter' ? 'selected' : '' ?>>milliliter</option>
                <option value="liter" <?php echo $ingredient_data->reorder_unit == 'liter' ? 'selected' : '' ?>>liter</option>
                <option value="milligram" <?php echo $ingredient_data->reorder_unit == 'milligram' ? 'selected' : '' ?>>milligram</option>
                <option value="gram" <?php echo $ingredient_data->reorder_unit == 'gram' ? 'selected' : '' ?>>gram</option>
                <option value="kilogram" <?php echo $ingredient_data->reorder_unit == 'kilogram' ? 'selected' : '' ?>>kilogram</option>
              </select>
            </div>
            <button type="submit" id="update-ingredient-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Update</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>