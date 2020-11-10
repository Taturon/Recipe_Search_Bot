<?php

// 定数定義ファイルの読み込み
require_once('.env.php');

// DB接続
try {
	$dbh = new PDO(PDO_DSN, USERNAME, PASSWORD, [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit('DB接続に失敗しました' . PHP_EOL . $e->getMessage());;
}
