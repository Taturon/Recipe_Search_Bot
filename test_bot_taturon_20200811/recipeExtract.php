<?php

// 入力値の設定
$search = '%\\' . $message['text'] . '%';

// 入力値を用いてDB検索し、idを配列に格納
require_once('dbConnect.php');
$sql = "SELECT category_id FROM rakuten_recipe WHERE category_name LIKE ?";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $search, PDO::PARAM_STR);
$stmt->execute();
$ids = $stmt->fetchAll();

// 取得したidを使ってレシピデータを配列に格納
foreach ($ids as $key => $id) {
	$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426';
	$params['applicationId'] = '1070228718341633238';
	$params['elements'] = 'foodImageUrl,recipeDescription,recipeMaterial,recipeUrl,recipeTitle';
	$params['categoryId'] = $id['category_id'];
	$canonical_string = '';
	foreach($params as $k => $v) {
		$canonical_string .= '&' . $k . '=' . $v;
	}
	$canonical_string = substr($canonical_string, 1);
	$url = $baseurl . '?' . $canonical_string;
	$recipes[$key] = json_decode(@file_get_contents($url, true), true);
}

// 得られた結果を文字列として格納
$reply = '';
foreach ($recipes as $key => $recipe) {
	foreach ($recipe['result'] as $data) {
		$reply .= $data['recipeTitle'] . "\n";
		$reply .= $data['recipeUrl'] . "\n";
	}
}
$message['text'] = $reply;
