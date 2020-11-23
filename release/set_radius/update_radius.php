<?php

// POSTされた値で対象のユーザー情報を更新
require_once('db_connect.php');
$radius = $event['postback']['data'];
$updated_at = date('Y-m-d H:i:s');
$line_id = $event['source']['userId'];
$sql = 'UPDATE `users` SET `radius` = ?, `updated_at` = ? WHERE `line_id` = ?';
$stmt = $dbh->prepare($sql);
$stmt->execute([$radius, $updated_at, $line_id]);
$rows = $stmt->rowCount();

// usersテーブルに情報がなかった場合は新規登録
if ($rows === 0) {
	$created_at = $updated_at;
	$sql = 'INSERT INTO `users` (`line_id`, `radius`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?)';
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$line_id, $radius, $created_at, $updated_at]);
}

// 返信用メッセージを設定
$config_radius = require_once('../config/radius.php');
$set_radius = $config_radius[$radius];
$rep = '検索半径を' . $set_radius . ' に変更しました!';
$reply['messages'][0] = ['type' => 'text', 'text' => $rep];
