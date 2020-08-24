<?php

// 全カテゴリ名を取得
require_once('../dbConnect.php');
$sql = "SELECT id, category_name FROM rakuten_recipe";
$stmt = $dbh->query($sql);
$names = $stmt->fetchAll();

// それぞれ検索し、曖昧検索で2以上ヒットするカテゴリ名を抽出
foreach($names as $name) {
	if (mb_strlen($name['category_name']) > 20) {
		$exceeds[] = $name;
	}
}

// ブラウザなどにFB
if (!empty($exceeds)) {
	var_dump($exceeds);
} else {
	echo '20文字を超えるレシピ名はありませんでした' . PHP_EOL;
}
