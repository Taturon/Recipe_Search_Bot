<?php

// 全カテゴリ名を取得
require_once('../dbConnect.php');
$sql = "SELECT category_name FROM rakuten_recipe";
$stmt = $dbh->query($sql);
$names = $stmt->fetchAll();

// それぞれ検索し、曖昧検索で2以上ヒットするカテゴリ名を抽出
foreach($names as $name) {
	$name = '%' . $name['category_name'] . '%';
	$sql = "SELECT * FROM rakuten_recipe WHERE category_name LIKE ?";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(1, $name, PDO::PARAM_STR);
	$stmt->execute();
	$ids = $stmt->fetchAll();
	if (count($ids) > 1) {
		foreach ($ids as $id) {
			$loops[] = $id;
		}
	}
}

// ブラウザなどにFB
if (!empty($loops)) {
	var_dump($loops);
} else {
	echo 'ループを起こすレシピ名はありませんでした' . PHP_EOL;
}
