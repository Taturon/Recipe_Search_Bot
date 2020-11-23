<?php

// 気分による分岐
if ($message['text'] === 'スタミナが欲しい') {
	$feeling_id = 1;
} elseif ($message['text'] === '二日酔い') {
	$feeling_id = 2;
} elseif ($message['text'] === '元気が欲しい') {
	$feeling_id = 3;
} elseif ($message['text'] === '風邪気味') {
	$feeling_id = 4;
}

// 気分に紐づけられたレシピの抽出
require_once('db_connect.php');
$sql = 'SELECT recipes.category_id FROM recipes INNER JOIN feelings ON feelings.recipe_id = recipes.id WHERE feeling_id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $feeling_id, PDO::PARAM_STR);
$stmt->execute();
$ids = $stmt->fetchAll();
if ($ids) {
	require_once('../common/make_carousel.php');
}
