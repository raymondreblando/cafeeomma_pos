<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';

date_default_timezone_set('Asia/Hong_Kong');

use Dotenv\Dotenv;
use Config\Database;
use App\Utils\DbHelper;
use App\Providers\AuthProvider;
use App\Controllers\InventoryController;
use App\Controllers\CategoryController;
use App\Controllers\MenuController;
use App\Controllers\CartController;
use App\Controllers\OrderController;
use App\Controllers\AccountController;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$database = new Database();
$conn = $database->getConnetion($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

$helper = new DbHelper($conn);
$authProvider = new AuthProvider($helper);
$inventoryController = new InventoryController($helper);
$categoryController = new CategoryController($helper);
$menuController = new MenuController($helper);
$cartController = new CartController($helper);
$orderController = new OrderController($helper);
$accountController = new AccountController($helper);

define('SYSTEM_URL', $_ENV['SYSTEM_URL']);

if(isset($_SESSION['uid'])){
  $helper->query("SELECT * FROM `accounts` a LEFT JOIN `roles` r ON a.role_id=r.role_id WHERE a.user_id = ?", [$_SESSION['uid']]);
  $user_data = $helper->fetch();
} 