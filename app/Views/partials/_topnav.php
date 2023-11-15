<?php

use App\Utils\Utilities;

?>

<div class="fixed md:static top-0 inset-x-0 flex items-center justify-between gap-4 px-8 py-3 bg-white z-[3]">
  <div class="flex-1 sm:flex-initial flex items-center gap-3">
    <button type="button" class="show-sidebar block md:hidden font-semibold"><i class="ri-menu-5-line"></i></button>
    <div class="flex-1 sm:flex-initial flex items-center gap-3 px-4 bg-gray-100 py-2 rounded-full">
      <img src="<?php echo SYSTEM_URL ?>public/icons/search-normal-linear.svg" alt="search" class="w-4 h-4">
      <input type="text" id="search-input" class="text-[11px] placeholder:text-black/60 bg-transparent" placeholder="Search" autocomplete="off">
    </div>
  </div>
  <div class="flex items-center gap-2">

    <?php if(Utilities::isAdmin()){ ?>

      <?php 
        
        $helper->query("SELECT * FROM `notifications` WHERE `status` = ?", ["Unread"]);
        $unread_count = $helper->rowCount();

        $helper->query("SELECT * FROM `notifications` ORDER BY `id` DESC");
        $notifications = $helper->fetchAll();
        
      ?>

      <div class="relative">
        <img src="<?php echo SYSTEM_URL ?>public/icons/notification-bing-linear.svg" alt="notification" role="button" class="show-notification w-4 h-4 mr-2">

        <?php if($unread_count > 0){ ?>

          <span class="absolute top-0 right-[7px] w-[10px] h-[10px] rounded-full bg-primary border-2 border-white pointer-events-none"></span>
          <span class="animate-ping absolute top-0 right-[7px] w-[10px] h-[10px] rounded-full bg-primary border-2 border-white pointer-events-none"></span>

        <?php } ?>

        <div class="notification absolute top-full right-0 w-[14rem] bg-white rounded-xl py-4 shadow-md opacity-0 invisible">
          <div class="px-6 pb-2 border-b border-b-gray-300/40">
            <p class="text-[11px] font-semibold text-black leading-none">Notifications</p>
            <p class="text-[9px] font-semibold text-black/60">Keep abreast of important updates</p>
          </div>

          <?php if(count($notifications) > 0){ ?>

            <div class="custom-scroll max-h-[210px] overflow-y-auto">

            <?php 
              foreach($notifications as $notification): 
                if ($notification->notif_type == "Menu") {
                  $helper->query("SELECT * FROM `menus` WHERE `menu_id` = ?", [$notification->referrence_id]);
                } else {
                  $helper->query("SELECT * FROM `ingredients` WHERE `ing_id` = ?", [$notification->referrence_id]);
                }
                
                $referrenceData = $helper->fetch();
            ?>

              <div class="notif <?= $notification->status == "Unread" ? "unread" : "" ?>">
                <p class="text-[9px] font-semibold text-black/60 leading-snug"><span class="text-primary"><?= $notification->notif_type == "Menu" ? $referrenceData->menu_name : $referrenceData->ing_name ?></span> stocks is getting low. Restock now.</p>
              </div>

            <?php 
              endforeach 
            ?>

            </div>

          <?php } else{ ?>

            <div class="grid place-items-center h-[100px]">
              <p class="text-[9px] font-semibold text-black/60 leading-snug">No notifications yet.</p>
            </div>

          <?php } ?>
          
        </div>
      </div>

    <?php } ?>

    <a href="<?= SYSTEM_URL ?>profile" class="flex items-center gap-2">
      <div class="hidden sm:block text-right">
        <p class="text-[11px] font-semibold text-black leading-none"><?php echo isset($user_data) ? $user_data->fullname : "" ?></p>
        <p class="text-[9px] font-semibold text-black/60"><?php echo isset($user_data) ? $user_data->role_name : "" ?></p>
      </div>
      <img src="<?php echo SYSTEM_URL ?>uploads/users/<?= $user_data->profile == 1 ? $user_data->user_id.".jpg" : $user_data->gender.".svg" ?>" alt="profile" class="w-7 h-7 object-cover rounded-full">
    </a>
  </div>
</div>