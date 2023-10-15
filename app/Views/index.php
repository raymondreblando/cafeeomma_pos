<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Login";

  use App\Utils\Utilities;

  if(Utilities::isAdmin()) Utilities::redirectAuthorize("dashboard");
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

?>

  <main class="min-h-screen grid place-items-center bg-light-gray">
    <div class="w-[min(26rem,90%)] rounded-md p-6">
      <div class="flex items-center justify-center gap-2 mb-6">
        <img src="<?php echo SYSTEM_URL ?>public/images/logo.png" alt="logo" class="w-10 h-10">
        <div>
          <p class="text-lg font-semibold text-black leading-none">Cafe Eomma</p>
          <p class="text-xs font-medium text-black">Point of Sale System</p>
        </div>
      </div>
      <h1 class="text-2xl font-semibold text-black text-center">Welcome back</h1>
      <p class="text-xs font-medium text-black/60 text-center mb-4">Efficiently manage orders and transactions with our user-friendly point of sale solution</p>

      <?php 
        $helper->query("SELECT * FROM `system_logs` s LEFT JOIN `accounts` a ON s.user_id=a.user_id WHERE NOT s.user_id = ? AND s.type = ? GROUP BY s.user_id", ['5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In']);

        if($helper->rowCount() > 0){
      ?>

          <p class="text-[10px] font-medium text-black/60 text-center mb-2">Recent system logins</p>
          <div class="flex justify-center items-center gap-1 mb-6">

          <?php foreach($helper->fetchAll() as $recent): ?>

            <div class="bg-white rounded-md py-2 px-4">
              <img src="<?php echo SYSTEM_URL ?>uploads/users/<?= $recent->profile == 1 ? $recent->user_id.".jpg" : $recent->gender.".svg" ?>" alt="profile" class="w-8 h-8 object-cover rounded-full mx-auto mb-1">
              <p class="text-[10px] font-medium text-black text-center"><?= $recent->username ?></p>
            </div>

          <?php endforeach ?>

          </div>

      <?php } ?>

      <form autocomplete="off" class="w-[min(20rem,100%)] rounded-md p-4 mx-auto" id="login-form">
        <p class="text-sm font-semibold text-black text-center mb-4">Log in to your account</p>
        <div class="flex items-center h-10 bg-white rounded-full px-6 mb-3">
          <input type="text" name="username" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter your username">
          <img src="<?php echo SYSTEM_URL ?>public/icons/user-linear.svg" alt="user" class="w-3 h-3">
        </div>
        <div class="flex items-center gap-2 h-10 bg-white rounded-full px-6 mb-3">
          <input type="password" name="password" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Account password">
          <i role="button" class="show-password ri-eye-line text-xs text-black/60"></i>
          <img src="<?php echo SYSTEM_URL ?>public/icons/eye-shield-security-linear.svg" alt="security" class="w-3 h-3">
        </div>
        <button type="submit" id="login-btn" class="w-full h-10 rounded-full bg-primary text-white text-[10px] font-medium disabled:cursor-wait">Log In</button>
      </form>
    </div>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>