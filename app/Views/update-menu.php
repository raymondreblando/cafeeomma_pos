<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Update Menu";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

  $menu_data = $menuController->showOne(Utilities::sanitize($id));

?>

  <main class="min-h-screen grid md:grid-cols-[11rem_auto] bg-light-gray">

    <?php require('./app/Views/partials/_sidebar.php') ?>

    <section>

      <?php require('./app/Views/partials/_topnav.php') ?>

      <div class="min-h-[calc(100vh-4.5rem)] flex items-center justify-center pt-20 md:pt-5 pb-5 px-8">
        <div class="w-[min(30rem,100%)] bg-white rounded-2xl p-6">
          <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
            <a href="<?php echo SYSTEM_URL ?>menus/" class="text-xs font-medium text-black bg-light-gray py-2 px-4 rounded-full">
              <i class="ri-arrow-left-s-line"></i>
              Back
            </a>
            <div class="md:text-right">
              <p class="text-xs font-semibold text-black leading-none">Update Menu</p>
              <p class="text-[10px] font-semibold text-black/60">Seamlessly update the menu items</p>
            </div>
          </div>
          <form autocomplete="off" id="update-menu-form">
            <input type="hidden" name="mid" value="<?php echo $menu_data->menu_id ?>">
            <div class="grid md:grid-cols-2 gap-4">
              <div class="upload-container aspect-square w-full h-[154px] relative bg-light-gray cursor-pointer rounded-2xl p-3">
                <input type="file" name="menu_img" class="upload-input" hidden>
                <img src="<?php echo SYSTEM_URL ?>uploads/menus/<?php echo $menu_data->menu_id.".png" ?>" alt="<?php echo $menu_data->menu_name ?>" class="upload-overview w-full h-full object-contain pointer-events-none">
                <div class="icon absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 pointer-events-none" hidden>
                  <img src="<?php echo SYSTEM_URL ?>public/icons/gallery-export-linear.svg" alt="image" class="w-6 h-6 mx-auto mb-2 pointer-events-none">
                  <p class="text-[9px] font-semibold pointer-events-none text-center text-black/60">Upload menu image</p>
                </div>
              </div>
              <div>
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-4">
                  <input type="text" name="menu_name" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter menu name" value="<?php echo $menu_data->menu_name ?>">
                </div>
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-4">
                  <input type="text" name="menu_price" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter menu price" value="<?php echo $menu_data->menu_price ?>">
                </div>
                <select name="category" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3">
                  <option value="">Select Category</option>

                  <?php foreach($categoryController->show() as $category): ?>

                    <option value="<?= $category->category_id ?>" <?php echo $menu_data->category_id == $category->category_id ? "selected" : "" ?>><?= $category->category_name ?></option>

                  <?php endforeach ?>

                </select>
              </div>

              <?php 
                $helper->query("SELECT * FROM `sizes` WHERE `menu_id` = ?", [$menu_data->menu_id]);
                if($helper->rowCount() > 0){
              ?>

                <div class="size-wrapper md:col-span-2 gap-4">

                <?php foreach($helper->fetchAll() as $size): ?>

                  <div class="flex items-center gap-3 mb-3">
                    <input type="hidden" name="sid[]" value="<?= $size->size_id ?>">
                    <div class="w-full flex items-center h-10 bg-light-gray rounded-full px-6">
                      <input type="text" name="size[]" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter size" value="<?= $size->size ?>">
                    </div>
                    <div class="w-full flex items-center h-10 bg-light-gray rounded-full px-6">
                      <input type="text" name="size_price[]" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter size price" value="<?= $size->size_price ?>">
                    </div>
                  </div>

                <?php endforeach ?>

                </div>

              <?php } ?>

            </div>
            <button type="submit" id="update-menu-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full mt-2 disabled:cursor-wait">Update Menu</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>