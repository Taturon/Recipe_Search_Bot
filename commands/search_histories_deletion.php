<?php

require_once('/var/www/html/recipe_search_bot/release/db_connect.php');

try {
	$retention_period = require_once('/var/www/html/recipe_search_bot/config/retention_period.php');
	$retention_limit = date('Y-m-d H:i:s', strtotime('-' . $retention_period['retention_period'] . ' day'));
	$sql = 'DELETE FROM `histories` WHERE `created_at` < ?';
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$retention_limit]);
	$rows = $stmt->rowCount();
	$success = date('Y-m-d H:i:s ') . $rows . '件の検索履歴を削除しました' . PHP_EOL;
	error_log($success, 3, '/var/www/html/recipe_search_bot/logs/search_histories_deletion.log');
} catch (PDOException $e) {
	$error = date('Y-m-d H:i:s ') . '検索履歴の削除に失敗しました ' . $e->getMessage() . PHP_EOL;
	error_log($error, 3, '/var/www/html/recipe_search_bot/logs/search_histories_deletion.log');
	exit($error);;
}

