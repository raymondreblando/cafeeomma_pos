<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Account Security";

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

      <div class="min-h-[calc(100vh-4.5rem)] flex items-center justify-center pt-20 md:pt-5 pb-5 px-8">
        <div class="w-[min(26rem,100%)] bg-white rounded-2xl p-6">
          <div class="mb-6">
            <p class="text-sm font-semibold text-black">Account Security</p>
            <p class="text-[10px] font-semibold text-black/60">Prioritize security by updating your account password in our POS system. Take control of your login credentials and ensure the safety of your account.</p>
          </div>
          <form autocomplete="off" id="account-security-form">
            <div class="flex items-center gap-2 w-full h-10 bg-light-gray rounded-full px-6 mb-3">
              <input type="password" name="current_password" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter current account password">
              <i role="button" class="show-password ri-eye-line text-xs text-black/60"></i>
              <img src="<?php echo SYSTEM_URL ?>public/icons/eye-shield-security-linear.svg" alt="security" class="w-3 h-3">
            </div>
            <div class="flex items-center gap-2 w-full h-10 bg-light-gray rounded-full px-6 mb-3">
              <input type="password" name="new_password" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter new account password">
              <i role="button" class="show-password ri-eye-line text-xs text-black/60"></i>
              <img src="<?php echo SYSTEM_URL ?>public/icons/eye-shield-security-linear.svg" alt="security" class="w-3 h-3">
            </div>
            <div class="flex items-center gap-2 w-full h-10 bg-light-gray rounded-full px-6 mb-3">
              <input type="password" name="confirm_password" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Confirm account password">
              <i role="button" class="show-password ri-eye-line text-xs text-black/60"></i>
              <img src="<?php echo SYSTEM_URL ?>public/icons/eye-shield-security-linear.svg" alt="security" class="w-3 h-3">
            </div>
            <button type="submit" id="account-security-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Save</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>