<?php

// テーブル削除・作成・データ挿入のトライ
try {

	// DB接続
	require_once('../db_connect.php');

	// トランザクションの開始
	$dbh->beginTransaction();

	// テーブルの消去
	$sql = 'DROP TABLE IF EXISTS recipes';
	$stmt = $dbh->query($sql);

	// テーブルの構築
	$sql = 'CREATE TABLE `recipes` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`category_name` varchar(255) UNIQUE NOT NULL,
		`category_id` varchar(20) UNIQUE NOT NULL,
		PRIMARY KEY(id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin';
	$stmt = $dbh->query($sql);

	// データの挿入
	require_once('insert.php');
	$stmt = $dbh->query($sql);

	// 変更の反映
	$dbh->commit();
	echo 'recipesテーブル作成に成功しました' . PHP_EOL;

// トライ中にエラーが発生した場合
} catch (Exception $e) {

	// 変更の取り消し
	$dbh->rollBack();
	exit('recipesテーブル作成に失敗しました' . PHP_EOL . $e->getMessage() . PHP_EOL);;
}
