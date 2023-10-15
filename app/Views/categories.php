<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Categories";

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
          <div class="mb-6">
            <p class="text-xs font-semibold text-black leading-none">Categories</p>
            <p class="text-[10px] font-semibold text-black/60">Craft a more intuitive menu experience by adding a new category</p>
          </div>
          <form autocomplete="off" id="update-category-form" class="hidden">
            <div class="flex flex-col md:flex-row gap-3 md:gap-2 mb-4">
              <div class="flex items-center w-full h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="category_name" id="category-input" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter category name">
              </div>
              <button type="submit" id="update-category-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Update</button>
            </div>
          </form>
          <form autocomplete="off" id="save-category-form">
            <div class="flex flex-col md:flex-row gap-3 md:gap-2 mb-4">
              <div class="flex items-center w-full h-10 bg-light-gray rounded-full px-6 mb-3">
                <input type="text" name="category_name" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter category name">
              </div>
              <button type="submit" id="save-category-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Save</button>
            </div>
          </form>

          <?php if(count($categoryController->show()) > 0){ ?>

            <div class="grid md:grid-cols-2 gap-3">

            <?php foreach($categoryController->show() as $category): ?>

              <div class="flex items-center gap-2 border border-gray-300/40 py-3 px-5 rounded-lg">
                <div>
                  <p class="text-xs font-semibold text-black leading-none"><?= $category->category_name ?></p>
                  <p class="text-[9px] font-semibold text-black/60">Category</p>
                </div>
                <button type="button" class="update-category bg-light-gray w-6 h-6 rounded-full ml-auto text-xs disabled:cursor-wait" data-id="<?= $category->category_id ?>">
                  <i class="ri-restart-line pointer-events-none"></i>
                </button>
              </div>

            <?php endforeach ?>

            </div>

          <?php } else{ ?>

            <div class="h-[200px] flex flex-col items-center justify-center gap-1">
              <img src="<?php echo SYSTEM_URL ?>public/icons/category.svg" alt="category" class="w-4 h-4">
              <p class="text-[9px] font-semibold text-black/60 text-center">No category found. <br> Create one now</p>
            </div>

          <?php } ?>

        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>