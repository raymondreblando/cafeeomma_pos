<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Order Details";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

  $order_data = $orderController->showOne(Utilities::sanitize($id));

?>

  <main class="min-h-screen grid md:grid-cols-[11rem_auto] bg-light-gray">

    <?php require('./app/Views/partials/_sidebar.php') ?>

    <section>

      <?php require('./app/Views/partials/_topnav.php') ?>

      <div class="min-h-[calc(100vh-4.5rem)] flex items-center justify-center pt-20 md:pt-5 pb-5 px-8">
        <div class="w-[min(30rem,100%)] bg-white rounded-2xl p-6">
          <a href="<?php echo SYSTEM_URL ?>orders" class="block w-fit text-xs font-medium text-black bg-light-gray py-2 px-4 rounded-full mb-4">
            <i class="ri-arrow-left-s-line"></i>
            Back
          </a>
          <div class="flex items-center justify-between gap-4 mb-6">
            <div>
              <p class="text-xs font-semibold text-black leading-none">Order <?php echo $order_data->order_no ?></p>
              <p class="text-[10px] font-semibold text-black/60">The order was take on <?php echo Utilities::formatDate($order_data->date_added, "M d, Y") ?></p>
            </div>
            <div>
              <p class="text-xs font-semibold text-black leading-none">P<?php echo $order_data->amount ?></p>
              <p class="text-[10px] font-semibold text-black/60">Amount</p>
            </div>
          </div>
          <p class="text-[10px] font-medium text-black/60 mb-2">Here are the orderred items in this order transaction</p>
          <div class="grid md:grid-cols-3 gap-3">

            <?php 
              $helper->query("SELECT * FROM `orderred_items` o LEFT JOIN `menus` m ON o.menu_id=m.menu_id LEFT JOIN `categories` c ON m.category_id=c.category_id WHERE o.order_id = ?", [$order_data->order_id]);
    
              foreach($helper->fetchAll() as $order_item):
            ?>

              <div class="bg-white rounded-xl p-4 border border-gray-300/40">
                <div class="w-full h-24 grid place-items-center bg-light-gray rounded-xl mb-3">
                  <img src="<?php echo SYSTEM_URL ?>uploads/menus/<?= $order_item->menu_id.".png" ?>" alt="<?= $order_item->menu_name ?>" class="h-20">
                </div>
                <p class="text-[10px] font-semibold text-black leading-none"><?= $order_item->menu_name ?></p>
                <p class="text-[8px] font-semibold text-black/60 mb-1"><?= $order_item->category_name ?></p>

                <?php 
                  if(!empty($order_item->size_id)){ 
                    $helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$order_item->size_id]);
                    $size_data = $helper->fetch();
                ?>

                <p class="text-[10px] font-semibold text-black/60 mb-3"><?php echo $size_data->size ?></p>

                <?php } else{ ?>

                  <p class="text-[10px] font-semibold text-black/60 mb-3">No size available</p>

                <?php } ?>


                <div class="flex items-center justify-between gap-3">
                  <div>
                    <p class="text-[8px] font-semibold text-black/60">Price</p>
                    <p class="text-[10px] font-bold text-black">P<?= $order_item->amount ?></p>
                  </div>
                  <div>
                    <p class="text-[8px] font-semibold text-black/60">Qty</p>
                    <p class="text-[10px] font-bold text-black"><?= $order_item->quantity ?></p>
                  </div>
                </div>
              </div>

            <?php endforeach ?>
            
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>