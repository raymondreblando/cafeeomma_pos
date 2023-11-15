<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Ingredients";

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

      <div class="pt-20 md:pt-5 pb-5 px-8">
        <div class="flex items-center justify-between gap-4 mb-4">
          <div class="flex items-center gap-3">
            <a href="<?php  echo SYSTEM_URL ?>menu-inventory" class="inv_link <?= $title === 'Inventory' ? 'active' : '' ?>">Menus</a>
            <a href="<?php  echo SYSTEM_URL ?>ingredient-inventory" class="inv_link <?= $title === 'Ingredients' ? 'active' : '' ?>">Ingredients</a>
          </div>
          <a href="<?php echo SYSTEM_URL ?>add-ingredient" class="w-max h-10 flex items-center gap-2 bg-primary text-xs text-white py-2 px-4 rounded-full">
            <i class="ri-add-line"></i>
            <p class="text-[10px]">Add New</p>
          </a>
        </div>

        <?php if(count($ingredientController->show()) > 0){ ?>

          <div class="w-[calc(100vw-3.5rem)] md:w-[calc(100vw-16rem)] bg-white overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
              <thead>
                <th class="group table-th text-[10px] border-l-0 border-t-0 cursor-pointer">
                  Ingredient Name
                  <i class="inline-table text-sm ml-2 ri-arrow-down-s-fill group-[.th-sort-desc]:rotate-180"></i>
                </th>
                <th class="group table-th text-[10px] border-l-0 border-t-0 cursor-pointer">
                  Stocks
                  <i class="inline-table text-sm ml-2 ri-arrow-down-s-fill group-[.th-sort-desc]:rotate-180"></i>
                </th>
                <th class="text-[10px] border-t-0">Stock Unit</th>
                <th class="group table-th text-[10px] border-l-0 border-t-0 cursor-pointer">
                  Reorder Level
                  <i class="inline-table text-sm ml-2 ri-arrow-down-s-fill group-[.th-sort-desc]:rotate-180"></i>
                </th>
                <th class="text-[10px] border-t-0">Reorder Unit</th>
                <th width="10%" class="text-[10px] border-r-0 border-t-0"></th>
              </thead>
              <tbody>

              <?php foreach($ingredientController->show() as $ingredient): ?>

                <tr class="search-area border-b border-b-gray-300/40 last:border-b-none">
                  <td class="border border-gray-300/40 border-l-0">
                    <div class="w-max flex items-center gap-2">
                      <p class="finder1 text-[11px] text-black font-semibold leading-none"><?= $ingredient->ing_name ?></p>
                    </div>
                  </td>
                  <td class="finder4 border border-gray-300/40"><?php echo Utilities::convertUnit($ingredient->ing_stocks, $ingredient->ing_unit, 'reverse') ?></td>
                  <td class="finder5 border border-gray-300/40"><?= $ingredient->ing_unit ?></td>
                  <td class="finder6 border border-gray-300/40"><?php echo Utilities::convertUnit($ingredient->reorder_level, $ingredient->reorder_unit, 'reverse') ?></td>
                  <td class="finder6 border border-gray-300/40"><?= $ingredient->reorder_unit ?></td>
                  <td class="border border-gray-300/40 border-r-0">
                    <a href="<?php echo SYSTEM_URL ?>ingredient/<?= $ingredient->ing_id ?>" class="flex justify-center items-center gap-1 text-[9px] uppercase bg-light-gray text-black py-2 px-4 rounded-full">
                      <img src="<?php echo SYSTEM_URL ?>public/icons/rotate-right-linear.svg" alt="update" class="w-3 h-3">
                      Update
                    </a>
                  </td>
                </tr>

              <?php endforeach ?>

              </tbody>
            </table>
          </div>

        <?php } else{ ?>

          <div class="min-h-[calc(100vh-10rem)] flex flex-col items-center justify-center gap-1">
            <img src="<?php echo SYSTEM_URL ?>public/icons/inventory.svg" alt="ingredient" class="w-6 h-6">
            <p class="text-[9px] font-semibold text-black/60 text-center">No ingredient record found</p>
          </div>

        <?php } ?>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>