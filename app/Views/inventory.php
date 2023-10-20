<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Inventory";

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

      <div class="pt-20 md:pt-5 pb-5 px-8">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-4">
          <div class="flex items-center flex-wrap gap-3">
            <a href="<?php  echo SYSTEM_URL ?>menu-inventory" class="inv_link <?= $title === 'Inventory' ? 'active' : '' ?>">Menus</a>
            <a href="<?php  echo SYSTEM_URL ?>ingredient-inventory" class="inv_link <?= $title === 'Ingredients' ? 'active' : '' ?>">Ingredients</a>
            <select class="filter-select appearance-none w-[10rem] h-10 bg-white text-[10px] font-medium text-black px-4 rounded-md">
              <option value="">Filter by category</option>
  
              <?php foreach($categoryController->show() as $category): ?>
  
              <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
  
              <?php endforeach ?>
  
            </select>
          </div>
          <a href="<?php echo SYSTEM_URL ?>add-inventory" class="w-max h-10 flex items-center gap-2 bg-primary text-xs text-white py-2 px-4 rounded-full">
            <i class="ri-add-line"></i>
            <p class="text-[10px]">Add New</p>
          </a>
        </div>

        <?php if(count($inventoryController->show()) > 0){ ?>

          <div class="w-[calc(100vw-3.5rem)] md:w-[calc(100vw-16rem)] bg-white overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
              <thead>
                <th class="text-[10px] border-l-0 border-t-0">Menu Name</th>
                <th class="text-[10px] border-t-0">Price</th>
                <th class="text-[10px] border-t-0">Stocks</th>
                <th class="text-[10px] border-t-0">Inventory Value</th>
                <th class="text-[10px] border-t-0">Reorder Level</th>
                <th width="10%" class="text-[10px] border-r-0 border-t-0"></th>
              </thead>
              <tbody>

              <?php foreach($inventoryController->show() as $inventory): ?>

                <tr class="search-area border-b border-b-gray-300/40 last:border-b-none">
                  <td class="border border-gray-300/40 border-l-0">
                    <div class="w-max flex items-center gap-2">
                      <div class="grid place-items-center w-10 h-10 rounded-lg bg-gray-100">
                        <img src="<?php echo SYSTEM_URL ?>uploads/menus/<?= $inventory->menu_id.".png" ?>" alt="<?= $inventory->menu_name ?>" class="h-8">
                      </div>
                      <div>
                        <p class="finder1 text-[11px] text-black font-semibold leading-none"><?= $inventory->menu_name ?></p>
                        <p class="finder2 text-[9px] text-black/60 font-semibold"><?= $inventory->category_name ?></p>
                        <p class="finder3 hidden"><?= $inventory->category_id ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="finder4 border border-gray-300/40">P<?= $inventory->menu_price ?></td>
                  <td class="finder5 border border-gray-300/40"><?= $inventory->inventory_stocks ? $inventory->inventory_stocks : "Not Applicable" ?></td>
                  <td class="border border-gray-300/40"><?= $inventory->inventory_value > 0 ? "P" . $inventory->inventory_value : "Not Applicable" ?></td>
                  <td class="finder6 border border-gray-300/40"><?= $inventory->reorder_level ? $inventory->reorder_level : "Not Applicable" ?></td>
                  <td class="border border-gray-300/40 border-r-0">
                    <a href="<?php echo SYSTEM_URL ?>inventory/<?= $inventory->inventory_id ?>" class="flex justify-center items-center gap-1 text-[9px] uppercase bg-light-gray text-black py-2 px-4 rounded-full">
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
            <img src="<?php echo SYSTEM_URL ?>public/icons/inventory.svg" alt="inventory" class="w-6 h-6">
            <p class="text-[9px] font-semibold text-black/60 text-center">No inventory record found</p>
          </div>

        <?php } ?>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>