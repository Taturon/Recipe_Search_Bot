<?php

require_once('db_connect.php');

$line_id = $event['source']['userId'];
date_default_timezone_set('Asia/Tokyo');
$created_at = date('Y-m-d H:i:s');
$retention_period = require_once('../../config/retention_period.php');
$retention_limit = date('Y-m-d H:i:s', strtotime('-' . $retention_period['retention_period'] . ' day'));

$sql = 'SELECT `id` from `histories` WHERE `line_id` = ? AND `created_at` >= ? AND `word` = ? ORDER BY `id` DESC LIMIT 10';
$stmt = $dbh->prepare($sql);
$stmt->execute([$line_id, $retention_limit, $word]);
$id = $stmt->fetch();

if ($id) {
	$sql = 'UPDATE `histories` SET `created_at` = ? WHERE `id` = ?';
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$created_at, $id['id']]);
} else {
	$sql = 'INSERT INTO `histories` (`line_id`, `word`, `created_at`) VALUES (?, ?, ?)';
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$line_id, $word, $created_at]);
}
