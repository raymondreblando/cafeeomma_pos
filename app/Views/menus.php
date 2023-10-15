<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Menus";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

?>

  <main class="min-h-screen grid md:grid-cols-[11rem_auto] bg-light-gray">

    <?php require('./app/Views/partials/_sidebar.php') ?>

    <section>

      <?php require('./app/Views/partials/_topnav.php') ?>

      <div class="pt-20 md:pt-5 pb-5 px-8">

      <?php if(Utilities::isAdmin()){  ?>

        <div class="flex items-center justify-between gap-4 mb-4">
          <select class="filter-select appearance-none w-[10rem] h-10 bg-white text-[10px] font-medium text-black px-4 rounded-md">
            <option value="">Filter by category</option>

            <?php foreach($categoryController->show() as $category): ?>

            <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>

            <?php endforeach ?>

          </select>
          <a href="<?php echo SYSTEM_URL ?>add-menu" class="w-max h-10 flex items-center gap-2 bg-primary text-xs text-white py-2 px-4 rounded-full">
            <i class="ri-add-line"></i>
            <p class="text-[10px]">Add Menu</p>
          </a>
        </div>

        <?php if(count($menuController->show()) > 0){ ?>

          <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-8 gap-2">

          <?php foreach($menuController->show() as $menu): ?>

            <div class="search-area flex flex-col bg-white rounded-xl p-4">
              <div class="w-full h-24 grid place-items-center bg-light-gray rounded-xl mb-3">
                <img src="<?php echo SYSTEM_URL ?>uploads/menus/<?= $menu->menu_id.".png" ?>" alt="<?= $menu->menu_name ?>" class="h-20">
              </div>
              <p class="finder1 text-[10px] font-semibold text-black leading-none"><?= $menu->menu_name ?></p>
              <p class="finder2 text-[8px] font-semibold text-black/60 mb-3"><?= $menu->category_name ?></p>
              <p class="finder5 hidden"><?= $menu->category_id ?></p>

              <?php  
                $helper->query("SELECT * FROM `sizes` WHERE `menu_id` = ? ORDER BY `size`", [$menu->menu_id]);

                if($helper->rowCount() > 0){
              ?>

                  <div class="flex items-center gap-2 mb-3">
                    <p class="text-[8px] font-bold text-black">Size</p>

                  <?php foreach($helper->fetchAll() as $size): ?>

                    <span class="finder3 text-[8px] font-semibold p-[2px] bg-gray-200 rounded-sm"><?= $size->size ?></span>

                  <?php endforeach ?>

                  </div>

              <?php } else{ ?>

                <div class="flex items-center gap-2 mb-3">
                  <p class="text-[8px] font-bold text-black">Size</p>
                  <span class="text-[8px] font-semibold py-[2px] px-[4px] bg-gray-200 rounded-sm">Not Applicable</span>
                </div>

              <?php } ?>

              <div class="flex items-center justify-between gap-3 mt-auto">
                <div>
                  <p class="text-[8px] font-semibold text-black/60">Price</p>
                  <p class="finder4 text-[10px] font-bold text-black">P<?= $menu->menu_price ?></p>
                </div>
                <a href="<?php echo SYSTEM_URL ?>menu/<?= $menu->menu_id ?>" class="w-6 h-6 rounded-full buy-btn bg-primary text-xs text-center leading-6 text-white" title="Update Menu"><i class="ri-restart-line"></i></a>
              </div>
            </div>

          <?php endforeach ?>

          </div>

        <?php } else{ ?>

          <div class="min-h-[calc(100vh-10rem)] flex flex-col items-center justify-center gap-1">
            <img src="<?php echo SYSTEM_URL ?>public/icons/menu.svg" alt="menu" class="w-6 h-6">
            <p class="text-[10px] font-semibold text-black/60 text-center">No menu record found</p>
          </div>

        <?php } ?>

      <?php } else{ ?>

        <div class="grid lg:grid-cols-[auto_18rem] gap-4">
          <div>
            <div class="flex items-center justify-between gap-4 mb-4">
              <div class="hidden-scroll w-[calc(100vw-10rem)] md:w-full flex gap-2 overflow-x-auto rounded-full">
                <span role="button" class="shrink-0 filter-box category active">All Menus</span>

                <?php foreach($categoryController->show() as $category): ?>

                  <span role="button" class="shrink-0 filter-box category" data-id="<?= $category->category_id ?>"><?= $category->category_name ?></span>

                <?php endforeach ?>

              </div>
              <button class="show-order w-max block lg:hidden bg-primary text-sm text-white py-2 px-4 rounded-full"><i class="ri-apps-2-line"></i></button>
            </div>

        <?php if(count($menuController->show()) > 0){ ?>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-2">

              <?php foreach($menuController->show() as $menu): ?>

                <div class="search-area menu-card bg-white rounded-xl p-4">
                  <div class="w-full h-24 grid place-items-center bg-light-gray rounded-xl mb-3">
                    <img src="<?php echo SYSTEM_URL ?>uploads/menus/<?= $menu->menu_id.".png" ?>" alt="<?= $menu->menu_name ?>" class="h-20">
                  </div>
                  <p class="finder1 text-[10px] font-semibold text-black leading-none"><?= $menu->menu_name ?></p>
                  <p class="finder2 text-[8px] font-semibold text-black/60 mb-3"><?= $menu->category_name ?></p>
                  <p class="finder5 hidden"><?= $menu->category_id ?></p>

                  <?php  
                    $helper->query("SELECT * FROM `sizes` WHERE `menu_id` = ? ORDER BY `size`", [$menu->menu_id]);

                    if($helper->rowCount() > 0){
                  ?>

                      <div class="flex items-center gap-2 mb-3">
                        <p class="text-[8px] font-bold text-black">Size</p>

                      <?php foreach($helper->fetchAll() as $size): ?>

                        <button type="button" class="finder3 size-option" data-id="<?= $size->size_id ?>"><?= $size->size ?></button>

                      <?php endforeach ?>

                      </div>

                  <?php } else{ ?>

                    <div class="flex items-center gap-2 mb-3">
                      <span class="text-[8px] font-semibold py-[2px] px-[4px] bg-gray-200 rounded-sm">No size available</span>
                    </div>

                  <?php } ?>

                  <div class="flex items-center justify-between gap-3">

                    <?php 
                      $helper->query("SELECT * FROM `inventory` WHERE `menu_id` = ?", [$menu->menu_id]);
                      
                    if($helper->rowCount() > 0){
                      $inventory_data = $helper->fetch();
                    ?>
                    
                      <div>
                        <p class="text-[8px] font-semibold text-black/60"><?php echo $inventory_data->inventory_stocks == 0 ? "Menu was" : "Price" ?></p>
                        <p class="text-[10px] font-bold text-black"><?php echo $inventory_data->inventory_stocks == 0 ? "Sold Out" : "P".$menu->menu_price ?></p>
                      </div>

                      <?php if($inventory_data->inventory_stocks == 0){ ?>

                        <button type="button" class="w-6 h-6 rounded-full buy-btn bg-gray-100 text-xs text-black cursor-not-allowed" title="Buy"><i class="ri-add-line"></i></button>

                      <?php } else{ ?>

                        <button type="button" class="w-6 h-6 rounded-full buy-btn bg-primary text-xs text-white" title="Buy" data-id="<?= $menu->menu_id ?>"><i class="ri-add-line pointer-events-none"></i></button>

                      <?php } ?>
                    
                    <?php } else{ ?>  

                      <div>
                        <p class="text-[8px] font-semibold text-black/60">Menu was</p>
                        <p class="text-[10px] font-bold text-black">Sold Out</p>
                      </div>
                      <button type="button" class="w-6 h-6 rounded-full buy-btn bg-gray-100 text-xs text-black cursor-not-allowed" title="Buy"><i class="ri-add-line"></i></button>

                    <?php } ?>  
                      
                  </div>
                </div>

              <?php endforeach ?>

            </div>
            <div class="orders-wrapper">
              <div class="flex items-center justify-between gap-2 pb-2 border-b border-b-gray-300/40 mb-2">
                <div>
                  <p class="text-[11px] font-semibold text-black leading-none">Order Summary</p>
                  <p class="text-[9px] font-semibold text-black/60">Dive into the details of the order</p>
                </div>
                <button class="close-order block lg:hidden"><i class="ri-close-line"></i></button>
              </div>

              <?php 
                $total_amount = 0;
                
                if(count($cartController->show()) > 0){
                  $cart_datas = $cartController->show();
              ?>

                <div class="custom-scroll max-h-[calc(100vh-28rem)] overflow-y-auto">

                  <?php 
                    foreach($cart_datas as $cart_item): 
                      $price = 0;
                      $selected_size = '';

                      if(!empty($cart_item->size_id)){
                        $helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$cart_item->size_id]);
                        $size_data = $helper->fetch();
                        $selected_size = $size_data->size;
                        $price = $size_data->size_price;
                        $total_amount += $size_data->size_price * $cart_item->quantity;
                      } else{
                        $price = $cart_item->menu_price;
                        $total_amount +=  $cart_item->menu_price * $cart_item->quantity;
                      }
                  ?>

                    <div class="flex items-center justify-between gap-3 py-2 px-2">
                      <div class="flex items-center gap-2">
                        <div class="w-14 h-14 grid place-items-center bg-light-gray rounded-xl">
                          <img src="<?php echo SYSTEM_URL ?>uploads/menus/<?= $cart_item->menu_id.".png" ?>" alt="<?= $cart_item->menu_name ?>" class="h-10">
                        </div>
                        <div>
                          <p class="text-[11px] font-semibold text-black leading-none"><?= $cart_item->menu_name ?></p>
                          <p class="text-[9px] font-semibold text-black/60"><?= $cart_item->category_name ?></p>
                          <p class="text-[10px] font-bold text-black leading-none">P<?= $price ?></p>

                          <?php if(!empty($selected_size)){ ?>

                            <p class="text-[8px] font-semibold p-[1px] text-primary"><?= $selected_size ?></p>

                          <?php } ?>

                        </div>
                      </div>
                      <div class="text-center">
                        <p class="text-[11px] font-semibold text-black leading-none mb-1">Qty</p>
                        <div class="flex items-center gap-2">
                          <button class="minus-btn text-[10px] text-primary font-semibold py-[0.5px] px-[3px] rounded-full border border-primary disabled:cursor-wait" data-id="<?= $cart_item->cart_id ?>"><i class="ri-subtract-line pointer-events-none"></i></button>
                          <span class="count text-[10px] font-bold text-black"><?= $cart_item->quantity ?></span>
                          <button class="add-btn text-[10px] text-primary font-semibold py-[0.5px] px-[3px] rounded-full border border-primary disabled:cursor-wait" data-id="<?= $cart_item->cart_id ?>"><i class="ri-add-line pointer-events-none"></i></button>
                        </div>
                      </div>
                    </div>

                  <?php endforeach ?>

                </div>

              <?php } else{ ?>

                <div class="h-[calc(100vh-28rem)] flex flex-col justify-center items-center gap-1">
                  <p class="text-[10px] text-left font-medium text-black">No item was added</p>
                </div>

              <?php } ?>

              <div class="grid grid-cols-2 gap-2 border-t border-t-gray-300/40 py-3 mt-auto">
                <p class="text-[10px] text-left font-medium text-black">Total Amount</p>
                <p class="text-[10px] text-right font-bold text-black leading-none" id="total-amount" data-id="<?php echo number_format($total_amount + ($total_amount * (5/100)), 2)  ?>">P<?php echo number_format($total_amount + ($total_amount * (5/100)), 2) ?></p>
                <p class="text-[10px] text-left font-medium text-black">Cash</p>
                <p class="text-[10px] text-right font-bold text-black leading-none" id="cash" data-id="0">P0</p>
                <p class="text-[10px] text-left font-medium text-black">Change</p>
                <p class="text-[10px] text-right font-bold text-black leading-none" id="change">P0</p>
                <p class="text-[10px] text-left font-medium text-black">Discount</p>
                <p class="text-[10px] text-right font-bold text-black leading-none" id="discount">P0</p>
                <p class="text-[10px] text-left font-medium text-black">VAT</p>
                <p class="text-[10px] text-right font-bold text-black leading-none" id="vat" data-id="<?php echo $total_amount * (5/100) ?>">P<?php echo $total_amount * (5/100) ?></p>
              </div>
              <div class="pt-4">
                <select id="discount-select" class="appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3">
                  <option value="0.00">Select Discount</option>
                  <option value="0.20">20%</option>
                </select>
                <input id="cash-input" type="text" class="w-full h-10 text-[10px] font-medium text-black placeholder:text-black/60 px-6 bg-gray-100 rounded-full mb-2" placeholder="Enter cash amount" autocomplete="off">
                <button type="button" id="checkout-btn" class="w-full h-10 text-[10px] text-white px-6 bg-primary rounded-full disabled:cursor-wait">Checkout Order</button>
              </div>
            </div>
          </div>

        <?php } else{ ?>

          <div class="min-h-[calc(100vh-10rem)] flex flex-col items-center justify-center gap-1">
            <img src="<?php echo SYSTEM_URL ?>public/icons/menu.svg" alt="menu" class="w-6 h-6">
            <p class="text-[10px] font-semibold text-black/60 text-center">No menu record found</p>
          </div>

        <?php } ?>

      <?php } ?>

      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>