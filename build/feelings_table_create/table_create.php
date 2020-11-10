<?php

// DB接続
require_once('../db_connect.php');

// テーブル削除・作成・データ挿入のトライ
try {

	// トランザクションの開始
	$dbh->beginTransaction();

	// テーブルの消去
	$sql = 'DROP TABLE IF EXISTS feelings';
	$stmt = $dbh->query($sql);

	// テーブルの構築
	$sql = 'CREATE TABLE `feelings` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`recipe_id` int(11) NOT NULL,
		`feeling_id` int(11) NOT NULL,
		PRIMARY KEY(id)
	)';
	$stmt = $dbh->query($sql);

	// データの挿入
	$sql = "INSERT INTO `feelings` (`recipe_id`, `feeling_id`) VALUES
		(10, 1),
		(1471, 1),
		(194, 2),
		(345, 2),
		(174, 3),
		(176, 3),
		(1574, 4),
		(319, 4)
	";
	$stmt = $dbh->query($sql);

	// 変更の反映
	$dbh->commit();
	echo 'テーブル作成に成功しました' . PHP_EOL;

// トライ中にエラーが発生した場合
} catch (Exception $e) {

	// 変更の取り消し
	$dbh->rollBack();
	exit('テーブル作成に失敗しました' . PHP_EOL . $e->getMessage() . PHP_EOL);;
}
