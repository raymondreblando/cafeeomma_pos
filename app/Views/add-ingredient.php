<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Add Inventory";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

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
              <p class="text-xs font-semibold text-black leading-none">Add New Inventory</p>
              <p class="text-[10px] font-semibold text-black/60">Stay organized and well-stocked</p>
            </div>
          </div>
          <form autocomplete="off" id="save-ingredient-form">
            <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
              <input type="text" name="ing_name" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter ingredient name">
            </div>
            <div class="grid md:grid-cols-2 gap-3">
              <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="ing_stocks" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter stocks">
              </div>
              <select name="ing_unit" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full">
                <option value="">Select Stock Unit</option>
                <option value="milliliter">milliliter</option>
                <option value="liter">liter</option>
                <option value="milligram">milligram</option>
                <option value="gram">gram</option>
                <option value="kilogram">kilogram</option>
              </select>
              <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="ing_reorder_level" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter reorder level">
              </div>
              <select name="reorder_unit" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full">
                <option value="">Select Reorder Unit</option>
                <option value="milliliter">milliliter</option>
                <option value="liter">liter</option>
                <option value="milligram">milligram</option>
                <option value="gram">gram</option>
                <option value="kilogram">kilogram</option>
              </select>
            </div>
            <button type="submit" id="save-ingredient-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Save</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>