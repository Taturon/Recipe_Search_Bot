<?php
// 定数の定義・変数への代入
const PDO_DSN = 'mysql:host=localhost;dbname=[各人のDB名];charset=utf8mb4';
const USERNAME = '[ユーザー名]';
const PASSWORD = '[パスワード]';

// DB接続
try {
	$dbh = new PDO(PDO_DSN, USERNAME, PASSWORD, [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit('DB接続に失敗しました<br>' . $e->getMessage());;
}
