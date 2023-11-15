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
        <div class="flex flex-wrap items-center gap-4 mb-4">
          <div class="relative flex-1 md:flex-initial h-10 px-4 bg-white rounded-md">
            <input type="date" id="start-date-filter" class="w-full h-full text-[10px] font-medium text-dark bg-transparent uppercase">
            <img src="<?php echo SYSTEM_URL ?>public/icons/calendar-linear.svg" alt="calendar" class="absolute top-1/2 -translate-y-1/2 right-4 bg-white w-3 h-3 pointer-events-none">
          </div>
          <div class="relative flex-1 md:flex-initial h-10 px-4 bg-white rounded-md">
            <input type="date" id="end-date-filter" class="w-full h-full text-[10px] font-medium text-dark bg-transparent uppercase">
            <img src="<?php echo SYSTEM_URL ?>public/icons/calendar-linear.svg" alt="calendar" class="absolute top-1/2 -translate-y-1/2 right-4 bg-white w-3 h-3 pointer-events-none">
          </div>

          <?php 
            if (Utilities::isAdmin()){ 
              require('./app/Views/partials/_notification.php');
          ?>

            <select class="staff-sort appearance-none w-[10rem] h-10 bg-white text-[10px] font-medium text-black px-4 rounded-md">
              <option value="">Select Staff</option>
              <?php 
                $helper->query("SELECT * FROM `accounts` WHERE NOT `role_id` = ? ORDER BY `account_status` ASC", ['b2fd54eb-4e49-11ee-8673-088fc30176f9']);
                $staffs = $helper->fetchAll();

                foreach ($staffs as $staff) :
              ?>

                <option value="<?= $staff->user_id ?>"><?= $staff->fullname ?></option> 

              <?php endforeach ?>
            </select>

          <?php } ?>
        </div>

        <?php if(count($orderController->show()) > 0){ ?>

          <div class="w-[calc(100vw-3.5rem)] md:w-[calc(100vw-16rem)] bg-white overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
              <thead>
                <th class="text-[10px] border-l-0 border-t-0">Order #</th>

                <?php if (Utilities::isAdmin()){ ?>
                  <th class="text-[10px] border-t-0">Staff</th>
                <?php } else { ?>
                  <th class="text-[10px] border-t-0">Quantity</th>
                <?php } ?>

                <th class="text-[10px] border-t-0">Subtotal</th>
                <th class="text-[10px] border-t-0">VAT</th>
                <th class="text-[10px] border-t-0">Discount</th>
                <th class="text-[10px] border-t-0">Amount</th>
                <th class="text-[10px] border-t-0">Cash</th>
                <th class="text-[10px] border-t-0">Change</th>
                <th class="text-[10px] border-t-0">Date</th>
              </thead>
              <tbody>

              <?php 
                $total_sales = 0;
                foreach($orderController->show() as $order): 
                  $total_sales += $order->amount;
              ?>

                <tr class="sales-row search-area border-b border-b-gray-300/40 last:border-b-none hover:bg-gray-100 transition-all duration-200 cursor-pointer" data-id="<?= $order->order_id ?>">
                  <td class="finder1 border border-gray-300/40 border-l-0"><?= $order->order_no ?></td>

                  <?php if (Utilities::isAdmin()){ ?>
                    <td class="finder2 staffFinder border border-gray-300/40" data-id="<?= $order->staff_id ?>"><?= $order->fullname ?></td>
                  <?php } else {  ?>
                    <td class="finder2 border border-gray-300/40"><?= $order->order_quantity > 1 ? $order->order_quantity." Items" : $order->order_quantity." Item" ?></td>
                  <?php } ?>

                  <td class="finder3 border border-gray-300/40">P<?= $order->subtotal ?></td>
                  <td class="border border-gray-300/40">P<?= $order->vat ?></td>
                  <td class="border border-gray-300/40">P<?= $order->discount ?></td>
                  <td class="finder3 salesFinder border border-gray-300/40">P<?= $order->amount ?></td>
                  <td class="finder4 border border-gray-300/40">P<?= $order->cash ?></td>
                  <td class="border border-gray-300/40">P<?= $order->order_change ?></td>
                  <td class="finder5 border border-gray-300/40"><?= Utilities::formatDate($order->date_added, "M d, Y h:i A") ?></td>
                  <td class="finder6 dateFinder hidden"><?= Utilities::formatDate($order->date_added, "Y-m-d") ?></td>
                </tr>

              <?php endforeach ?>

              </tbody>
            </table>
          </div>

          <div class="fixed bottom-4 left-8 md:left-[13rem] w-[calc(100vw-3.5rem)] md:w-[calc(100vw-16rem)] flex justify-between items-center bg-white py-3 px-4">
            <p class="text-xs text-black font-bold">Total Sales</p>
            <p class="total-sales text-xs text-black font-bold">P<?= number_format($total_sales, 2) ?></p>
          </div>

        <?php } else{ ?>

          <div class="min-h-[calc(100vh-10rem)] flex flex-col items-center justify-center gap-1">
            <img src="<?php echo SYSTEM_URL ?>public/icons/order.svg" alt="order" class="w-6 h-6">
            <p class="text-[9px] font-semibold text-black/60 text-center">No orders found</p>
          </div>

        <?php } ?>

      </div>
    </section>

    <div class="dialog fixed inset-0 grid place-items-center bg-black/60 z-30 hidden">
      <div class=" max-w-[400px] bg-white p-8 rounded-lg">
        <h1 class="text-lg text-black font-semibold mb-2">Order Items</h1>
        <div class="custom-scroll order-item-wrapper w-[300px] max-h-[315px] overflow-y-auto">
        </div>
        <div class="flex justify-end gap-3">
          <button class="close-dialog-btn text-xs text-black font-semibold py-2 px-4 hover:bg-gray-200 rounded-md transition-all duration-200" type="button">Close</button>
        </div>
      </div>
    </div>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>