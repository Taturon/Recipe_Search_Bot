<?php

// 定数定義ファイルの読み込み
require_once('.env.php');

// 入力パラメータの設定
$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426';
$params['applicationId'] = APPLICATION_ID;
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

// 取得したカテゴリURLからカテゴリIDのみを抽出
foreach ($categories as $key => $category) {
	$recipes[$key]['name'] = $category->categoryName;
	$category_id = str_replace('https://recipe.rakuten.co.jp/category/', '', $category->categoryUrl);
	$category_id = substr($category_id, 0, -1);
	$recipes[$key]['category_id'] = $category_id;
}

// カテゴリ別画像URLの取得
$params = [];
foreach ($recipes as $key => $recipe) {
	$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426';
	$params['applicationId'] = APPLICATION_ID;
	$params['elements'] = 'foodImageUrl';
	$params['categoryId'] = $recipe['category_id'];
	$canonical_string = '';
	foreach($params as $k => $v) {
		$canonical_string .= '&' . $k . '=' . $v;
	}
	$canonical_string = substr($canonical_string, 1);
	$url = $baseurl . '?' . $canonical_string;
	$recipes[$key]['img_url'] = json_decode(@file_get_contents($url, true))->result[0]->foodImageUrl;

	// 2秒間のインターバル
	sleep(2);
}

// DBへのデータ保存
require_once('db_connect.php');
$sql = 'INSERT INTO recipes (category_name, category_id, img_url) VALUES (?, ?, ?)';
$stmt = $dbh->prepare($sql);
try {
	$dbh->beginTransaction();
	foreach ($recipes as $recipe) {
		$stmt->bindParam(1, $recipe['name'], PDO::PARAM_STR);
		$stmt->bindParam(2, $recipe['category_id'], PDO::PARAM_STR);
		$stmt->bindParam(3, $recipe['img_url'], PDO::PARAM_STR);
		$stmt->execute();
	}
	$dbh->commit();
} catch (Exception $e) {
	$dbh->rollBack();
	exit('データ保存に失敗しました' . PHP_EOL . $e->getMessage() . PHP_EOL);;
}
