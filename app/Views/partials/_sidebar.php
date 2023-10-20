<?php

  use App\Utils\Utilities;

?>

<aside class="sidebar">
  <div>
    <div class="relative px-4 mb-3 border-b border-b-gray-300/40 pb-3 text-center">
      <p class="text-sm font-bold text-black leading-none">Cafe Eomma</p>
      <p class="text-[10px] font-medium text-black">Point of Sale System</p>
      <button class="close-sidebar absolute top-1/2 -translate-y-1/2 left-[95%] bg-white flex md:hidden items-center justify-center w-5 h-5 rounded-full"><i class="ri-arrow-left-double-line"></i></button>
    </div>
    <ul>

      <?php if(Utilities::isAdmin()){ ?>

      <li>
        <a href="<?php echo SYSTEM_URL ?>dashboard" class="group aside__link <?php echo $title == "Dashboard" ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/home-active.svg" alt="home" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/home.svg" alt="home" class="w-4 h-4 block group-[.active]:hidden">
          Dashboard
        </a>
      </li>
      <li>
        <a href="<?php echo SYSTEM_URL ?>menu-inventory" class="group aside__link <?php echo $title == "Inventory" || $title == "Add Inventory" || $title == "Update Inventory" || $title == 'Ingredients' ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/inventory-active.svg" alt="inventory" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/inventory.svg" alt="inventory" class="w-4 h-4 block group-[.active]:hidden">
          Inventory
        </a>
      </li>
      <li>
        <a href="<?php echo SYSTEM_URL ?>category" class="group aside__link <?php echo $title == "Categories" ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/category-active.svg" alt="category" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/category.svg" alt="category" class="w-4 h-4 block group-[.active]:hidden">
          Categories
        </a>
      </li>

      <?php } ?>

      <li>
        <a href="<?php echo SYSTEM_URL ?>menus" class="group aside__link <?php echo $title == "Menus" || $title == "Add Menu" || $title == "Update Menu" ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/menu-active.svg" alt="menu" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/menu.svg" alt="menu" class="w-4 h-4 block group-[.active]:hidden">
          Menus
        </a>
      </li>
      <li>
        <a href="<?php echo SYSTEM_URL ?>sales" class="group aside__link <?php echo $title == "Sales" || $title == "Order Details" ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/order-active.svg" alt="order" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/order.svg" alt="order" class="w-4 h-4 block group-[.active]:hidden">
          Sales
        </a>
      </li>

      <?php if(Utilities::isAdmin()){ ?>

      <li>
        <a href="<?php echo SYSTEM_URL ?>accounts" class="group aside__link <?php echo $title == "Accounts" || $title == "Create Account" || $title == "Update Account" ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/user-active.svg" alt="user" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/user.svg" alt="user" class="w-4 h-4 block group-[.active]:hidden">
          Accounts
        </a>
      </li>

      <?php } ?> 

      <li>
        <a href="<?php echo SYSTEM_URL ?>security" class="group aside__link <?php echo $title == "Account Security" ? "active" : "" ?>">
          <img src="<?php echo SYSTEM_URL ?>public/icons/security-active.svg" alt="security" class="w-4 h-4 hidden group-[.active]:block">
          <img src="<?php echo SYSTEM_URL ?>public/icons/security.svg" alt="security" class="w-4 h-4 block group-[.active]:hidden">
          Security
        </a>
      </li>
    </ul>
  </div>
  <ul class="mt-auto">
    <li>
      <a href="<?php echo SYSTEM_URL ?>logout" class="group aside__link">
        <img src="<?php echo SYSTEM_URL ?>public/icons/logout.svg" alt="user" class="w-4 h-4 block group-[.active]:hidden">
        Sign Out
      </a>
    </li>
  </ul>
</aside>