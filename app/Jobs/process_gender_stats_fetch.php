<?php

require_once __DIR__.'/../../config/init.php';

$data = array();

$helper->query("SELECT * FROM `accounts` WHERE `gender` = ? AND NOT `role_id` = ?", ['Male', 'b2fd54eb-4e49-11ee-8673-088fc30176f9']);
array_push($data, $helper->rowCount());

$helper->query("SELECT * FROM `accounts` WHERE `gender` = ? AND NOT `role_id` = ?", ['Female', 'b2fd54eb-4e49-11ee-8673-088fc30176f9']);
array_push($data, $helper->rowCount());

echo json_encode($data);