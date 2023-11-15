<?php

require_once __DIR__.'/../../config/init.php';

$helper->query('SELECT * FROM `notifications` WHERE `status` = ? ORDER BY `id` DESC', ['Unread']);
$notification = $helper->fetch();

if (isset($_SESSION['notif'])) {
  $_SESSION['notif']['status'] = $_SESSION['notif']['id'] === $notification->id ? 'Old' : 'New';
} else {
  $_SESSION['notif']['id'] = $notification->id;
  $_SESSION['notif']['status'] = 'New';
}

echo json_encode($_SESSION['notif']);