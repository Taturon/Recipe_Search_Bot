<?php

/*
注意:ブラウザ確認の更新やCUIでのphpコマンド実行によって大量のデータが
dbConnect.phpで設定したDBに挿入されます。実行時は注意して下さい
 */

// 入力パラメータの設定
$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426';
$params['applicationId'] = '1006164421113190409';
$params['format'] = 'json';
$params['categoryType'] = 'small';
$params['elements'] = 'categoryName,categoryUrl';

// リクエストURLの生成
$canonical_string = '';
foreach($params as $k => $v) {
	$canonical_string .= '&' . $k . '=' . $v;
}
$canonical_string = substr($canonical_string, 1);
$url = $baseurl . '?' . $canonical_string;

// データの取得
$categories = json_decode(@file_get_contents($url, true))->result->small;

// DB格納用配列の生成
foreach ($categories as $key => $category) {
	$recipes[$key]['name'] = $category->categoryName;
	$category_id = str_replace('https://recipe.rakuten.co.jp/category/', '', $category->categoryUrl);
	$category_id = substr($category_id, 0, -1);
	$recipes[$key]['category_id'] = $category_id;
}

// DBへのデータ保存
require_once('dbConnect.php');
$sql = 'INSERT INTO rakuten_recipe (category_name, category_id) VALUES (?, ?)';
$stmt = $dbh->prepare($sql);
try {
	$dbh->beginTransaction();
	foreach ($recipes as $recipe) {
		$stmt->bindParam(1, $recipe['name'], PDO::PARAM_STR);
		$stmt->bindParam(2, $recipe['category_id'], PDO::PARAM_STR);
		$stmt->execute();
	}
	$dbh->commit();
} catch (Exception $e) {
	$dbh->rollBack();
	exit('データ保存に失敗しました<br>' . $e->getMessage());;
}
?>
