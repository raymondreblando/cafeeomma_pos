<?php

require_once __DIR__.'/../../config/init.php';

$response = '';

$helper->query("SELECT * FROM `cart` c LEFT JOIN `menus` m ON c.menu_id=m.menu_id LEFT JOIN `categories` ca ON m.category_id=ca.category_id");

if($helper->rowCount() > 0){

   $response .= '
    <div class="main-wrapper">
      <div class="bg-white flex flex-col md:flex-row items-center justify-between gap-4 py-3 px-6 rounded-xl mb-3">
        <div>
          <p class="text-sm font-bold text-black">Order Summary</p>
          <p class="text-[9px] font-semibold text-black/60">Dive into the details of the order</p>
        </div>
      </div>
      <div class="summary-wrapper">
    ';

    foreach($helper->fetchAll() as $order){

      $response .= '
        <div class="order-view-card">
          <div class="w-full h-24 grid place-items-center bg-light-gray rounded-xl mb-3">
            <img src="'.SYSTEM_URL.'uploads/menus/'.$order->menu_id.'.png" alt="'.$order->menu_name.'" class="h-20">
          </div>
          <p class="text-[10px] font-semibold text-black leading-none">'.$order->menu_name.'</p>
          <p class="text-[8px] font-semibold text-black/60 mb-3">'.$order->category_name.'</p>
      ';

      if(!empty($order->size_id)){

        $helper->query("SELECT * FROM `sizes` WHERE `size_id` = ?", [$order->size_id]);
        $size_data = $helper->fetch();

        $response .= '<p class="text-[10px] font-semibold text-black/60 mb-3">'.$size_data->size.'</p>';

      } else{

        $response .= '<p class="text-[10px] font-semibold text-black/60 mb-3">No size available</p>';

      }

      $response .= '
          <div class="flex items-center justify-between gap-3">
            <div>
              <p class="text-[8px] font-semibold text-black/60">Price</p>
              <p class="text-[10px] font-bold text-black">P'.$order->amount.'</p>
            </div>
            <span class="w-6 h-6 rounded-full buy-btn bg-primary text-[10px] font-semibold text-center leading-6 text-white">x'.$order->quantity.'</span>
          </div>
        </div>
      ';
      
    }

    $helper->query("SELECT * FROM `cart_summary`");
    $summary_data = $helper->fetch();

    $response .= '
      </div>
      <div class="order-stats">
        <div class="flex justify-between gap-2 py-2">
          <p class="text-xs font-bold text-black">Amount</p>
          <p class="text-xs font-bold text-black">P'.$summary_data->amount.'</p>
        </div>
        <div class="flex justify-between gap-2 py-2">
          <p class="text-xs font-bold text-black">VAT</p>
          <p class="text-xs font-bold text-black">P'.$summary_data->vat.'</p>
        </div>
        <div class="flex justify-between gap-2 py-2">
          <p class="text-xs font-bold text-black">Discount</p>
          <p class="text-xs font-bold text-black">P'.$summary_data->discount.'</p>
        </div>
        <div class="flex justify-between gap-2 py-2 border-b-2 border-b-gray-300/40">
          <p class="text-xs font-bold text-black">Cash</p>
          <p class="text-xs font-bold text-black">P'.$summary_data->cash.'</p>
        </div>
        <div class="flex justify-between gap-2 py-2">
          <p class="text-xs font-bold text-black">Change</p>
          <p class="text-xs font-bold text-black">P'.$summary_data->order_change.'</p>
        </div>
      </div>
    </div>
   ';

} else{
  
  $response .= '
    <div>
      <div class="flex items-center justify-center gap-2 mb-6">
        <img src="'.SYSTEM_URL.'public/images/logo.png" alt="logo" class="w-10 h-10">
        <div>
          <p class="text-lg font-semibold text-black leading-none">Cafe Eomma</p>
          <p class="text-xs font-medium text-black">Point of Sale System</p>
        </div>
      </div>
      <h1 class="text-2xl font-semibold text-black text-center">Welcome to Cafe Eomma</h1>
      <p class="text-xs font-medium text-black/60 text-center mb-8">Step into a world of convenience and flavor at Cafe Eomma</p>
    </div>
  ';

}

echo $response;