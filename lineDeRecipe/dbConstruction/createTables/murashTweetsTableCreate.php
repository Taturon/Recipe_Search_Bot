<?php

// テーブル削除・作成・データ挿入のトライ
try {

	// DB接続
	require_once('../dbConnect.php');

	// トランザクションの開始
	$dbh->beginTransaction();

	// テーブルの消去
	$sql = 'DROP TABLE IF EXISTS murashu_tweets';
	$stmt = $dbh->query($sql);

	// テーブルの構築
	$sql = 'CREATE TABLE `murashu_tweets` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tweet` varchar(140) NOT NULL,
		PRIMARY KEY(id)
	)';
	$stmt = $dbh->query($sql);

	// データの挿入
	require_once('murashTweetsInsert.php');
	$stmt = $dbh->query($sql);

	// 変更の反映
	$dbh->commit();
	echo 'テーブル作成に成功しました' . PHP_EOL;

// トライ中にエラーが発生した場合
} catch (Exception $e) {

	// 変更の取り消し
	$dbh->rollBack();
	exit('テーブル作成に失敗しました' . PHP_EOL . $e->getMessage());;
}
