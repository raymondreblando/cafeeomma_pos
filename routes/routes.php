<?php

Flight::set('flight.views.path', 'app/');

Flight::route('/', function(){
    Flight::render('Views/index.php');
});

Flight::route('/dashboard', function(){
    Flight::render('Views/dashboard.php');
});

Flight::route('/menu-inventory', function(){
    Flight::render('Views/inventory.php');
});

Flight::route('/add-inventory', function(){
    Flight::render('Views/add-inventory.php');
});

Flight::route('/inventory/@id', function($id){
    Flight::render('Views/update-inventory.php', array('id' => $id));
});

Flight::route('/ingredient-inventory', function(){
    Flight::render('Views/ingredient-inventory.php');
});

Flight::route('/add-ingredient', function(){
    Flight::render('Views/add-ingredient.php');
});

Flight::route('/ingredient/@id', function($id){
    Flight::render('Views/update-ingredient.php', array('id' => $id));
});

Flight::route('/category', function(){
    Flight::render('Views/categories.php');
});

Flight::route('/menus/@filter?', function($filter){
    Flight::render('Views/menus.php', array('filter' => $filter));
});

Flight::route('/add-menu', function(){
    Flight::render('Views/add-menu.php');
});

Flight::route('/menu/@id', function($id){
    Flight::render('Views/update-menu.php', array('id' => $id));
});

Flight::route('/sales', function(){
    Flight::render('Views/orders.php');
});

Flight::route('/order/@id', function($id){
    Flight::render('Views/order-items.php', array('id' => $id));
});

Flight::route('/accounts', function(){
    Flight::render('Views/accounts.php');
});

Flight::route('/create-account', function(){
    Flight::render('Views/create-account.php');
});

Flight::route('/account/@id', function($id){
    Flight::render('Views/update-account.php', array('id' => $id));
});

Flight::route('/security', function(){
    Flight::render('Views/account-security.php');
});

Flight::route('/profile', function(){
    Flight::render('Views/profile.php');
});

Flight::route('/order-summary', function(){
    Flight::render('Views/order-view.php');
});

Flight::route('/logout', function(){
    Flight::render('Views/logout.php');
});

// Flight::route('/not-found', function(){
//   Flight::render('views/404.php');
// });

// Flight::map('notFound', function () {
//   Flight::redirect('/not-found');
// });