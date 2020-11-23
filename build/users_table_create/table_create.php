<?php

// テーブル削除・作成・データ挿入のトライ
try {

	// DB接続
	require_once('../db_connect.php');

	// トランザクションの開始
	$dbh->beginTransaction();

	// テーブルの消去
	$sql = 'DROP TABLE IF EXISTS users';
	$stmt = $dbh->query($sql);

	// テーブルの構築
	$sql = 'CREATE TABLE `users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`line_id` varchar(40) UNIQUE NOT NULL,
		`radius` char DEFAULT 3 NOT NULL,
		`created_at` timestamp NOT NULL,
		`updated_at` timestamp NOT NULL,
		`deleted_at` timestamp NULL DEFAULT NULL,
		PRIMARY KEY(id)
	)';
	$stmt = $dbh->query($sql);

	// 変更の反映
	$dbh->commit();
	echo 'usersテーブル作成に成功しました' . PHP_EOL;

// トライ中にエラーが発生した場合
} catch (Exception $e) {

	// 変更の取り消し
	$dbh->rollBack();
	exit('usersテーブル作成に失敗しました' . PHP_EOL . $e->getMessage() . PHP_EOL);;
}
