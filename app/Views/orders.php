<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Sales";

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
        <div class="flex items-center gap-4 mb-4">
          <div class="relative flex-1 md:flex-initial h-10 px-4 bg-white rounded-md">
            <input type="date" id="start-date-filter" class="w-full h-full text-[10px] font-medium text-dark bg-transparent uppercase">
            <img src="<?php echo SYSTEM_URL ?>public/icons/calendar-linear.svg" alt="calendar" class="absolute top-1/2 -translate-y-1/2 right-4 bg-white w-3 h-3 pointer-events-none">
          </div>
          <div class="relative flex-1 md:flex-initial h-10 px-4 bg-white rounded-md">
            <input type="date" id="end-date-filter" class="w-full h-full text-[10px] font-medium text-dark bg-transparent uppercase">
            <img src="<?php echo SYSTEM_URL ?>public/icons/calendar-linear.svg" alt="calendar" class="absolute top-1/2 -translate-y-1/2 right-4 bg-white w-3 h-3 pointer-events-none">
          </div>
        </div>

        <?php if(count($orderController->show()) > 0){ ?>

          <div class="w-[calc(100vw-3.5rem)] md:w-[calc(100vw-16rem)] bg-white overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
              <thead>
                <th class="text-[10px] border-l-0 border-t-0">Order #</th>
                <th class="text-[10px] border-t-0">Items Quantity</th>
                <th class="text-[10px] border-t-0">Amount</th>
                <th class="text-[10px] border-t-0">VAT</th>
                <th class="text-[10px] border-t-0">Cash</th>
                <th class="text-[10px] border-t-0">Change</th>
                <th class="text-[10px] border-t-0">Date</th>
                <th width="10%" class="text-[10px] border-r-0 border-t-0"></th>
              </thead>
              <tbody>

              <?php foreach($orderController->show() as $order): ?>

                <tr class="search-area border-b border-b-gray-300/40 last:border-b-none">
                  <td class="finder1 border border-gray-300/40 border-l-0"><?= $order->order_no ?></td>
                  <td class="finder2 border border-gray-300/40"><?= $order->order_quantity > 1 ? $order->order_quantity." Items" : $order->order_quantity." Item" ?></td>
                  <td class="finder3 border border-gray-300/40">P<?= $order->amount ?></td>
                  <td class="border border-gray-300/40">P<?= $order->vat ?></td>
                  <td class="finder4 border border-gray-300/40">P<?= $order->cash ?></td>
                  <td class="border border-gray-300/40">P<?= $order->order_change ?></td>
                  <td class="finder5 border border-gray-300/40"><?= Utilities::formatDate($order->date_added, "M d, Y h:i A") ?></td>
                  <td class="finder6 dateFinder hidden"><?= Utilities::formatDate($order->date_added, "Y-m-d") ?></td>
                  <td class="border border-gray-300/40 border-r-0">
                    <a href="<?php echo SYSTEM_URL ?>order/<?= $order->order_id ?>" class="flex justify-center items-center gap-1 text-[9px] uppercase bg-light-gray text-black py-2 px-4 rounded-full">
                      <img src="<?php echo SYSTEM_URL ?>public/icons/tag-2-linear.svg" alt="items" class="w-3 h-3">
                      See Items
                    </a>
                  </td>
                </tr>

              <?php endforeach ?>

            </tbody>
          </table>
        </div>

        <?php } else{ ?>

          <div class="min-h-[calc(100vh-10rem)] flex flex-col items-center justify-center gap-1">
            <img src="<?php echo SYSTEM_URL ?>public/icons/order.svg" alt="order" class="w-6 h-6">
            <p class="text-[9px] font-semibold text-black/60 text-center">No orders found</p>
          </div>

        <?php } ?>

      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>