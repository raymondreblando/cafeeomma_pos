<?php

  require_once __DIR__.'/../../config/init.php';
  $title = "Update Account";

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();
  if(Utilities::isEmployee()) Utilities::redirectAuthorize("menus");

  require('./app/Views/partials/_header.php');
  require('./app/Views/partials/_loader.php');
  require('./app/Views/partials/_toast.php');

  $account_data = $accountController->showOne(Utilities::sanitize($id));

?>

  <main class="min-h-screen grid md:grid-cols-[11rem_auto] bg-light-gray">

    <?php require('./app/Views/partials/_sidebar.php') ?>

    <section>

      <?php require('./app/Views/partials/_topnav.php') ?>

      <div class="min-h-[calc(100vh-4.5rem)] flex items-center justify-center pt-20 md:pt-5 pb-5 px-8">
        <div class="w-[min(30rem,100%)] bg-white rounded-2xl p-6">
          <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
            <a href="<?php echo SYSTEM_URL ?>accounts" class="text-xs font-medium text-black bg-light-gray py-2 px-4 rounded-full">
              <i class="ri-arrow-left-s-line"></i>
              Back
            </a>
            <div class="md:text-right">
              <p class="text-xs font-semibold text-black leading-none">Update Account</p>
              <p class="text-[10px] font-semibold text-black/60">Keep your team profiles current and accurate</p>
            </div>
          </div>
          <form autocomplete="off" id="update-account-form">
            <div class="grid md:grid-cols-2 gap-4">
              <input type="hidden" name="aid" value="<?php echo $account_data->user_id ?>">
              <div class="upload-container aspect-square w-full h-[200px] relative bg-light-gray cursor-pointer rounded-2xl p-3">
                <input type="file" name="profile" class="upload-input" hidden>
                <img src="<?php echo SYSTEM_URL ?>uploads/users/<?php echo $account_data->profile == 1 ? $account_data->user_id.".jpg" : "" ?>" alt="profile" class="upload-overview w-full h-full object-cover pointer-events-none" <?php echo $account_data->profile == 1 ? "" : "hidden" ?>>
                <div class="icon absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 pointer-events-none" <?php echo $account_data->profile == 1 ? "hidden" : "" ?>>
                  <img src="<?php echo SYSTEM_URL ?>public/icons/gallery-export-linear.svg" alt="image" class="w-6 h-6 mx-auto mb-2 pointer-events-none">
                  <p class="text-[9px] font-semibold pointer-events-none text-center text-black/60">Upload employee photo</p>
                </div>
              </div>
              <div>
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                  <input type="text" name="employee_name" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter employee name" value="<?php echo $account_data->fullname ?>">
                </div>
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                  <input type="text" name="username" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter employee username" value="<?php echo $account_data->username ?>">
                </div>
                <select name="gender" class="filter-categories appearance-none w-full h-10 bg-light-gray text-[10px] font-medium text-black/60 px-6 rounded-full mb-3">
                  <option value="">Select Gender</option>
                  <option value="Male" <?php echo $account_data->gender == "Male" ? "selected" : "" ?>>Male</option>
                  <option value="Female" <?php echo $account_data->gender == "Female" ? "selected" : "" ?>>Female</option>
                </select>
                <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
                  <input type="text" name="contact_number" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter contact number" maxlength="11" value="<?php echo $account_data->contact_number ?>">
                </div>
              </div>
            </div>
            <div class="flex items-center h-10 bg-light-gray rounded-full px-6 mb-3">
              <input type="text" name="address" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter address" value="<?php echo $account_data->address ?>">
            </div>
            <button type="submit" id="update-account-btn" class="w-full md:w-fit h-10 bg-primary text-white text-[10px] font-medium px-8 rounded-full disabled:cursor-wait">Update Account</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php require('./app/Views/partials/_footer.php') ?>