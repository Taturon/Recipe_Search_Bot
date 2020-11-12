<?php

require_once('db_connect.php');

$line_id = $event['source']['userId'];
$sql = 'SELECT `id` FROM `users` WHERE `line_id` = ?';
$stmt = $dbh->prepare($sql);
$stmt->execute([$line_id]);
$id = $stmt->fetch();

if (!$id) {
	$created_at = $updated_at = date('Y-m-d H:i:s');
	$sql = 'INSERT INTO `users` (`line_id`, `created_at`, `updated_at`) VALUES (?, ?, ?)';
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$line_id, $created_at, $updated_at]);
} else {
	$updated_at = date('Y-m-d H:i:s');
	$sql = 'UPDATE `users` SET `updated_at` = ?, `deleted_at` = NULL WHERE `line_id` = ?';
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$updated_at, $line_id]);
}
