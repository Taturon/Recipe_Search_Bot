<?php
// 入力値を用いてDB検索し、idを配列に格納
$search = '%' . $message['text'] . '%';
require_once('db_connect.php');
$sql = "SELECT category_name, category_id FROM recipes WHERE category_name LIKE ?";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $search, PDO::PARAM_STR);
$stmt->execute();
$ids = $stmt->fetchAll();

// 検索ヒット件数が多い場合の処理
// ヒット件数が13件(クイックリプライの上限)より多い場合
if (count($ids) > 13) {
	$rep = count($ids) . "カテゴリヒットしました！";
	$rep .= "\n対応するレシピが多すぎます...";
	$rep .= "\n下記より選択されるか、";
	$rep .= "\nもう少し具体的に教えて下さい！";
	$reply['messages'][0]['text'] = $rep;
	shuffle($ids);
	$examples = array_rand($ids, 13);
	$ids = array_intersect_key($ids, $examples);
	foreach ($ids as $id) {
		$reply['messages'][0]['quickReply']['items'][] = [
			'type' => 'action',
			'action' => [
				'type' => 'message',
				'label' => $id['category_name'],
				'text' => $id['category_name']
			]
		];
	}

// ヒット件数が1件より多い場合
} elseif (count($ids) > 1) {
	$rep = count($ids) . "件ヒットしました！";
	$rep .= "\n下記より選択して下さい！";
	$reply['messages'][0]['text'] = $rep;
	foreach ($ids as $id) {
		$reply['messages'][0]['quickReply']['items'][] = [
			'type' => 'action',
			'action' => [
				'type' => 'message',
				'label' => $id['category_name'],
				'text' => $id['category_name']
			]
		];
	}

//ヒット件数が1件の場合
} elseif (count($ids) === 1) {
	$word = $ids[0]['category_name'];
	require_once('../histories/search_history_recording.php');
	require_once('../common/make_carousel.php');
}
