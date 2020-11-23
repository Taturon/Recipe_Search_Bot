<?php

// ユーザー設定の検索半径取得
require_once('db_connect.php');
$line_id = $event['source']['userId'];
$sql = 'SELECT `radius` FROM `users` WHERE `line_id` = ?';
$stmt = $dbh->prepare($sql);
$stmt->execute([$line_id]);
$radius = $stmt->fetch()['radius'];
if (!$radius) {
	$radius = '3';
}
