<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Dashboard";

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
        <div class="grid lg:grid-cols-[auto_18rem] gap-4">
          <div>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
              <div class="flex justify-between gap-3 bg-white rounded-xl p-6">
                <div class="h-max bg-primary/10 p-2 rounded-xl">
                  <img src="<?php echo SYSTEM_URL ?>public/icons/sales.svg" alt="sales" class="w-5 h-5">
                </div>
                <div class="text-right">
                  <p class="text-[11px] text-dark/80 font-semibold leading-none mb-2">Total <br> Sales</p>

                  <?php 
                    $helper->query("SELECT SUM(amount) AS sales FROM `orders`");
                    $sales = $helper->fetch();
                  ?>

                  <p class="text-dark font-bold leading-none">P<?php echo number_format($sales->sales) ?></p>
                </div>
              </div>
              <div class="flex justify-between gap-3 bg-white rounded-xl p-6">
                <div class="h-max bg-sky-100 p-2 rounded-xl">
                  <img src="<?php echo SYSTEM_URL ?>public/icons/menu-blue.svg" alt="menu" class="w-5 h-5">
                </div>
                <div class="text-right">
                  <p class="text-[11px] text-dark/80 font-semibold leading-none mb-2">Total <br> Menus</p>

                  <?php 
                    $helper->query("SELECT * FROM `menus`");
                    $menu_count = $helper->rowCount();
                  ?>

                  <p class="text-dark font-bold leading-none"><?php echo $menu_count ?></p>
                </div>
              </div>
              <div class="flex justify-between gap-3 bg-white rounded-xl p-6">
                <div class="h-max bg-teal-100 p-2 rounded-xl">
                  <img src="<?php echo SYSTEM_URL ?>public/icons/order-green.svg" alt="order" class="w-5 h-5">
                </div>
                <div class="text-right">
                  <p class="text-[11px] text-dark/80 font-semibold leading-none mb-2">Total <br> Orders</p>

                  <?php 
                    $helper->query("SELECT * FROM `orders`");
                    $order_count = $helper->rowCount();
                  ?>

                  <p class="text-dark font-bold leading-none"><?php echo $order_count ?></p>
                </div>
              </div>
              <div class="flex justify-between gap-3 bg-white rounded-xl p-6">
                <div class="h-max bg-orange-100 p-2 rounded-xl">
                  <img src="<?php echo SYSTEM_URL ?>public/icons/user-orange.svg" alt="user" class="w-5 h-5">
                </div>
                <div class="text-right">
                  <p class="text-[11px] text-dark/80 font-semibold leading-none mb-2">Total <br> Employees</p>

                  <?php 
                    $helper->query("SELECT * FROM `accounts` WHERE NOT `role_id` = ?", ['b2fd54eb-4e49-11ee-8673-088fc30176f9']);
                    $employee_count = $helper->rowCount();
                  ?>

                  <p class="text-dark font-bold leading-none"><?php echo $employee_count ?></p>
                </div>
              </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
              <div class="bg-white rounded-xl pt-4">
                <div class="flex items-center justify-between gap-4 px-6 mb-3">
                  <div>
                    <p class="text-[11px] text-black font-semibold">New Menus</p>
                    <p class="text-[9px] text-black/60 font-semibold">Explore Our Latest Culinary Creations</p>
                  </div>
                  <a href="<?php echo SYSTEM_URL ?>menus" class="text-[9px] font-semibold text-black">See All</a>
                </div>
                <div class="w-[calc(100vw-3.5rem)] md:w-auto overflow-x-auto">
                  <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                      <th class="text-[11px] border-l-0">Menu Name</th>
                      <th class="text-[11px]">Price</th>
                      <th class="text-[11px] border-r-0">Stocks</th>
                    </thead>
                    <tbody>

                      <?php 
                        $helper->query("SELECT * FROM `menus` m LEFT JOIN `categories` c ON m.category_id=c.category_id LEFT JOIN `inventory` i ON i.menu_id=m.menu_id ORDER BY m.id DESC LIMIT 3");
                        $new_menus = $helper->fetchAll();
                        $new_menu_count = 3;
                      ?>

                      <?php for($index = 0; $index < $new_menu_count; $index++): ?>

                        <?php if(isset($new_menus[$index])){ ?>

                          <tr class="border-b border-b-gray-300/40 last:border-none">
                            <td>
                              <div>
                                <p class="text-[10px] text-black font-semibold leading-none"><?= $new_menus[$index]->menu_name ?></p>
                                <p class="text-[8px] text-black/60 font-semibold"><?= $new_menus[$index]->category_name ?></p>
                              </div>
                            </td>
                            <td>P<?= $new_menus[$index]->menu_price ?></td>
                            <td><?= $new_menus[$index]->inventory_stocks ?></td>
                          </tr>

                        <?php } else{ ?>

                          <tr class="border-b border-b-gray-300/40 last:border-none">
                            <td>
                              <div>
                                <div class="w-24 h-2 rounded-full bg-gray-100 mb-[5.5px]"></div>
                                <div class="w-12 h-2 rounded-full bg-gray-100"></div>
                              </div>
                            </td>
                            <td><div class="w-16 h-2 rounded-full bg-gray-100"></div></td>
                            <td><div class="w-16 h-2 rounded-full bg-gray-100"></div></td>
                          </tr>

                        <?php } ?>

                      <?php endfor ?>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="bg-white rounded-xl pt-4">
                <div class="flex items-center justify-between gap-4 px-6 mb-3">
                  <div>
                    <p class="text-[11px] text-black font-semibold">Top Selling</p>
                    <p class="text-[9px] text-black/60 font-semibold">Unrivaled Flavors of Our Most Beloved Menu Items</p>
                  </div>
                  <a href="<?php echo SYSTEM_URL ?>menus" class="text-[9px] font-semibold text-black">See All</a>
                </div>
                <div class="w-[calc(100vw-3.5rem)] md:w-auto overflow-x-auto">
                  <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                      <th class="text-[11px] border-l-0">#</th>
                      <th class="text-[11px]">Menu Name</th>
                      <th class="text-[11px] border-r-0">Sell Quantity</th>
                    </thead>
                    <tbody>

                      <?php 
                        $helper->query("SELECT *, SUM(o.quantity) as total_sell FROM `orderred_items` o LEFT JOIN `menus` m ON o.menu_id=m.menu_id LEFT JOIN `categories` c ON m.category_id=c.category_id GROUP BY o.menu_id LIMIT 3");
                        $top_sellings = $helper->fetchAll();
                        $top_selling_count = 3;
                      ?>

                      <?php for($index = 0; $index < $top_selling_count; $index++): ?>

                        <?php if(isset($top_sellings[$index])){ ?>

                          <tr class="border-b border-b-gray-300/40 last:border-none">
                            <td><?= $index + 1 ?></td>
                            <td>
                              <div>
                                <p class="text-[10px] text-black font-semibold leading-none"><?= $top_sellings[$index]->menu_name ?></p>
                                <p class="text-[8px] text-black/60 font-semibold"><?= $top_sellings[$index]->category_name ?></p>
                              </div>
                            </td>
                            <td><?= $top_sellings[$index]->total_sell ?></td>
                          </tr>

                        <?php } else{ ?>

                          <tr class="border-b border-b-gray-300/40 last:border-none">
                            <td><div class="w-4 h-2 rounded-full bg-gray-100"></div></td>
                            <td>
                              <div>
                                <div class="w-24 h-2 rounded-full bg-gray-100 mb-[5.5px]"></div>
                                <div class="w-12 h-2 rounded-full bg-gray-100"></div>
                              </div>
                            </td>
                            <td><div class="w-8 h-2 rounded-full bg-gray-100"></div></td>
                          </tr>

                        <?php } ?>

                      <?php endfor ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-xl pt-4">
              <div class="flex items-center justify-between gap-4 px-6 mb-3">
                <div>
                  <p class="text-[11px] text-black font-semibold">Recent Orders</p>
                  <p class="text-[9px] text-black/60 font-semibold">Dive into the details of our recent transactions</p>
                </div>
                <a href="<?php echo SYSTEM_URL ?>orders" class="text-[9px] font-semibold text-black">See All</a>
              </div>
              <div class="w-[calc(100vw-3.5rem)] md:w-auto overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                  <thead>
                    <th class="text-[11px] border-l-0">Order #</th>
                    <th class="text-[11px]">Quantity</th>
                    <th class="text-[11px]">Amount</th>
                    <th class="text-[11px]">Status</th>
                    <th class="text-[11px] border-r-0">Date</th>
                  </thead>
                  <tbody>

                    <?php 
                      $helper->query("SELECT * FROM `orders` ORDER BY id DESC LIMIT 4");
                      $recent_orders = $helper->fetchAll();
                      $recent_orders_count = 4;
                    ?>

                    <?php for($index = 0; $index < $recent_orders_count; $index++): ?>

                      <?php if(isset($recent_orders[$index])){ ?>

                        <tr class="border-b border-b-gray-300/40 last:border-none">
                          <td><?= $recent_orders[$index]->order_no ?></td>
                          <td><?= $recent_orders[$index]->order_quantity ?></td>
                          <td>P<?= $recent_orders[$index]->amount ?></td>
                          <td>
                            <div class="order-status">
                              <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                              <?= $recent_orders[$index]->order_status ?>
                            </div>
                          </td>
                          <td><?= Utilities::formatDate($recent_orders[$index]->date_added, "M d, Y") ?></td>
                        </tr>

                      <?php } else{ ?>

                        <tr class="border-b border-b-gray-300/40 last:border-none">
                          <td class="py-[1.02rem]"><div class="w-16 h-2 rounded-full bg-gray-100"></div></td>
                          <td class="py-[1.02rem]"><div class="w-8 h-2 rounded-full bg-gray-100"></div></td>
                          <td class="py-[1.02rem]"><div class="w-8 h-2 rounded-full bg-gray-100"></div></td>
                          <td class="py-[1.02rem]">
                            <div class="order-status">
                              <div class="w-2 h-2 rounded-full bg-gray-100"></div>
                              <div class="w-12 h-2 rounded-full bg-gray-100"></div>
                            </div>
                          </td>
                          <td class="py-[1.02rem]"><div class="w-16 h-2 rounded-full bg-gray-100"></div></td>
                        </tr>

                      <?php } ?>

                    <?php endfor ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="grid lg:block sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl pt-4 mb-4">
              <div class="flex items-center justify-between gap-4 px-6 pb-3 border-b border-b-gray-300/40">
                <div>
                  <p class="text-[11px] text-black font-semibold">System Logs</p>
                  <p class="text-[9px] text-black/60 font-semibold">System logins and logouts</p>
                </div>
              </div>

              <?php 
                $helper->query("SELECT * FROM `system_logs` s LEFT JOIN `accounts` a ON s.user_id=a.user_id WHERE NOT s.user_id = ? ORDER BY s.id DESC LIMIT 6", ["5659b391-4e4a-11ee-8673-088fc30176f9"]);
                $logs = $helper->fetchAll();
                $logs_count = 6;
              ?>

              <?php for($index = 0; $index < $logs_count; $index++): ?>

                <?php if(isset($logs[$index])){ ?>

                  <div class="flex items-center gap-2 py-[10.5px] px-6">
                    <img src="<?php echo SYSTEM_URL ?>uploads/users/<?= $logs[$index]->profile == 1 ? $logs[$index]->user_id.".jpg" : $logs[$index]->gender.".svg" ?>" alt="profile" class="w-6 h-6 object-cover rounded-full">
                    <div>
                      <p class="text-[10px] text-black font-semibold"><?= $logs[$index]->fullname ?></p>
                      <p class="text-[8px] text-black/60 font-semibold">Employee</p>
                    </div>
                    <div class="text-right ml-auto">
                      <p class="text-[10px] text-black font-semibold"><?= Utilities::formatDate($logs[$index]->date_created, "h:i A") ?></p>
                      <p class="text-[8px] text-black/60 font-semibold"><?= $logs[$index]->type ?></p>
                    </div>
                  </div>

                <?php } else{ ?>

                  <div class="flex items-center gap-2 py-[12px] px-6">
                    <div class="w-6 h-6 rounded-full bg-gray-100"></div>
                    <div>
                      <div class="w-16 h-2 rounded-full bg-gray-100 mb-1"></div>
                      <div class="w-12 h-1 rounded-full bg-gray-100"></div>
                    </div>
                    <div class="flex flex-col items-end ml-auto">
                      <div class="w-16 h-2 rounded-full bg-gray-100 mb-1"></div>
                      <div class="w-8 h-1 rounded-full bg-gray-100"></div>
                    </div>
                  </div>

                <?php } ?>

              <?php endfor ?>

            </div>
            <div class="bg-white rounded-xl pt-4 mb-4">
              <div class="px-6 pb-3">
                <p class="text-[11px] text-black font-semibold">Employee Stats</p>
                <p class="text-[9px] text-black/60 font-semibold">Statitistic by gender</p>
              </div>
              <div class="lg:h-[206px] px-6 pb-3">
                <canvas id="chart-gender" class="stats-chart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>