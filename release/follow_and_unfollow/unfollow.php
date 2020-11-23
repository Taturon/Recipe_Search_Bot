<?php

require_once('db_connect.php');

$line_id = $event['source']['userId'];
$deleted_at = date('Y-m-d H:i:s');
$sql = 'UPDATE `users` SET `deleted_at` = ? WHERE `line_id` = ?';
$stmt = $dbh->prepare($sql);
$stmt->execute([$deleted_at, $line_id]);
