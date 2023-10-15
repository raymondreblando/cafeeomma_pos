<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Accounts";

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
        <div class="flex items-center justify-between gap-4 mb-4">
          <select class="filter-select appearance-none w-[10rem] h-10 bg-white text-[10px] font-medium text-black px-4 rounded-md">
            <option value="">Filter Accounts</option>
            <option value="1111">Active Accounts</option>
            <option value="2222">Deactivated Accounts</option>
          </select>
          <a href="<?php echo SYSTEM_URL ?>create-account" class="w-max h-10 flex items-center gap-2 bg-primary text-xs text-white py-2 px-4 rounded-full">
            <i class="ri-add-line"></i>
            <p class="text-[10px]">Create Account</p>
          </a>
        </div>

        <?php if(count($accountController->show()) > 0){ ?>

          <div class="grid sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-2">

            <?php foreach($accountController->show() as $account): ?>

              <div class="search-area bg-white rounded-2xl py-6">
                <div class="relative pb-8 border-b border-b-gray-300/40">
                  <img src="<?php echo SYSTEM_URL ?>uploads/users/<?= $account->profile == 1 ? $account->user_id.".jpg" : $account->gender.".svg" ?>" alt="profile" class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-20 object-cover rounded-full">
                </div>
                <div class="pt-11 px-6">
                  <p class="finder1 text-[11px] font-semibold text-black text-center leading-none"><?= $account->fullname ?></p>
                  <p class="finder2 text-[9px] font-semibold text-center text-black/60 mb-2"><?= $account->username ?></p>
                  <div class="flex justify-between gap-2 mb-1">
                    <p class="text-[9px] font-semibold text-center text-black/60">Contact</p>
                    <p class="finder3 text-[9px] font-semibold text-center text-black/60"><?= $account->contact_number ?></p>
                  </div>
                  <div class="flex flex-col items-center mb-3">
                    <p class="text-[9px] font-semibold text-center text-black/60">Address</p>
                    <p class="finder4 text-[9px] font-semibold text-center text-black/60"><?= $account->address ?></p>
                  </div>
                  <p class="finder5 hidden"><?= $account->account_status == "active" ? "1111" : "2222" ?></p>
                  <div class="flex justify-center gap-3">
                    <a href="<?php echo SYSTEM_URL ?>account/<?= $account->user_id ?>" class="bg-gray-100 py-[5px] px-2 rounded-full" title="Update Account">
                      <img src="<?php echo SYSTEM_URL ?>public/icons/rotate-right-linear.svg" alt="update" class="w-3 h-3">
                    </a>

                    <?php if($account->account_status == "active"){ ?>

                      <button type="button" class="deactivate-btn bg-gray-100 py-[5px] px-2 rounded-full disabled:cursor-wait" title="Deactivate Account" data-id="<?= $account->user_id ?>">
                        <img src="<?php echo SYSTEM_URL ?>public/icons/minus-cirlce-linear.svg" alt="deactivate" class="w-3 h-3 pointer-events-none">
                      </button>

                    <?php } else{ ?>

                      <button type="button" class="activate-btn bg-gray-100 py-[5px] px-2 rounded-full disabled:cursor-wait" title="Activate Account" data-id="<?= $account->user_id ?>">
                        <img src="<?php echo SYSTEM_URL ?>public/icons/tick-circle-linear.svg" alt="activate" class="w-3 h-3 pointer-events-none">
                      </button>

                    <?php } ?>
                    
                  </div>
                </div>
              </div>

            <?php endforeach ?>

          </div>

        <?php } else{ ?>

          <div class="min-h-[calc(100vh-10rem)] flex flex-col items-center justify-center gap-1">
            <img src="<?php echo SYSTEM_URL ?>public/icons/user.svg" alt="user" class="w-6 h-6">
            <p class="text-[9px] font-semibold text-black/60 text-center">No accounts found</p>
          </div>

        <?php } ?>

      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>