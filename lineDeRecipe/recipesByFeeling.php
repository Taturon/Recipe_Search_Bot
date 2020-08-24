<?php

// 気分による分岐
if ($message['text'] === 'スタミナがつく料理') {
	$feeling_id = 1;
} elseif ($message['text'] === '二日酔いに効く料理') {
	$feeling_id = 2;
} elseif ($message['text'] === '食欲が出る料理') {
	$feeling_id = 3;
} elseif ($message['text'] === '風邪気味に効く料理') {
	$feeling_id = 4;
}

// 気分に紐づけられたレシピの抽出
require_once('dbConnect.php');
$sql = 'SELECT rakuten_recipe.category_id FROM rakuten_recipe INNER JOIN recipes_by_feeling ON recipes_by_feeling.recipe_id = rakuten_recipe.id WHERE feeling_id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $feeling_id, PDO::PARAM_STR);
$stmt->execute();
$ids = $stmt->fetchAll();


if ($ids) {
	require_once('makeCarousel.php');
}
