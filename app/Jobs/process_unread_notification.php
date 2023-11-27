<?php

require_once __DIR__.'/../../config/init.php';

$helper->query('SELECT * FROM `notifications` WHERE `status` = ? ORDER BY `id` DESC', ['Unread']);
$notifications = $helper->fetchAll();

if (count($notifications) > 0) {
  if (isset($_SESSION['notif'])) {
    $_SESSION['notif']['status'] = $_SESSION['notif']['id'] === $notifications[0]->id ? 'Old' : 'New';
  } else {
    $_SESSION['notif']['id'] = $notifications[0]->id;
    $_SESSION['notif']['status'] = 'New';
  }
}

echo json_encode($_SESSION['notif']);