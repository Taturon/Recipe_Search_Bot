<?php

// テーブル削除・作成・データ挿入のトライ
try {

	// DB接続
	require_once('../db_connect.php');

	// トランザクションの開始
	$dbh->beginTransaction();

	// テーブルの消去
	$sql = 'DROP TABLE IF EXISTS histories';
	$stmt = $dbh->query($sql);

	// テーブルの構築
	$sql = 'CREATE TABLE `histories` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`line_id` varchar(40) NOT NULL,
		`category_name` varchar(255) NOT NULL,
		`created_at` timestamp NOT NULL,
		PRIMARY KEY(id)
	)';
	$stmt = $dbh->query($sql);

	// 変更の反映
	$dbh->commit();
	echo 'historiesテーブル作成に成功しました' . PHP_EOL;

// トライ中にエラーが発生した場合
} catch (Exception $e) {

	// 変更の取り消し
	$dbh->rollBack();
	exit('historiesテーブル作成に失敗しました' . PHP_EOL . $e->getMessage() . PHP_EOL);;
}
