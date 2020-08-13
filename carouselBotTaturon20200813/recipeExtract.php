<?php

// 入力値を用いてDB検索し、idを配列に格納
$search = '%' . $message['text'] . '%';
require_once('dbConnect.php');
$sql = "SELECT category_name, category_id FROM rakuten_recipe WHERE category_name LIKE ?";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $search, PDO::PARAM_STR);
$stmt->execute();
$ids = $stmt->fetchAll();

// 検索ヒット件数が多い場合の処理
// ヒット件数が13件より多い場合(クイックリプライの上限)
if (count($ids) > 13) {
	$rep = count($ids) . "件ヒットしました！";
	$rep .= "\n対応するレシピが多すぎます！";
	$rep .= "\nもう少し具体的に\n教えて欲しいです！";
	$reply['messages'][0]['text'] = $rep;

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

	// 取得したidを使ってレシピデータを配列に格納
	foreach ($ids as $key => $id) {
		$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426';
		$params['applicationId'] = '1070228718341633238';
		$params['elements'] = 'recipeTitle,recipeDescription,recipeMaterial,foodImageUrl,recipeUrl';
		$params['categoryId'] = $id['category_id'];
		$canonical_string = '';
		foreach($params as $k => $v) {
			$canonical_string .= '&' . $k . '=' . $v;
		}
		$canonical_string = substr($canonical_string, 1);
		$url = $baseurl . '?' . $canonical_string;
		$recipes[$key] = json_decode(@file_get_contents($url, true), true);
	}

	// 得られた結果を繰り返し処理
	foreach ($recipes as $recipe) {

		// 各データの最上位にresult階層があるので更に繰り返し処理
		foreach ($recipe['result'] as $data) {

			// タイトルが40文字以上の場合はトリミング
			if (mb_strlen($data['recipeTitle']) > 40) {
				$title = mb_strimwidth($data['recipeTitle'], 0, 74, "...");
			} else {
				$title = $data['recipeTitle'];
			}

			// 説明が60文字以上の場合はトリミング
			if (mb_strlen($data['recipeDescription']) > 60) {
				$description = mb_strimwidth($data['recipeDescription'], 0, 114, "...");
			} else {
				$description = $data['recipeDescription'];
			}

			// カラムオブジェクトの生成
			$columns[] = [
				'thumbnailImageUrl' => $data['foodImageUrl'],
				'title'   => $title,
				'text'    => $description,
				'actions' => [
					[
						'type' => 'uri',
						'uri' => $data['recipeUrl'],
						'label' => '詳しく見てみる!'
					]
				]
			];
		}
	}

	// テンプレートオブジェクト及びカルーセルテンプレートの生成
	$template = ['type' => 'carousel', 'columns' => $columns];
	$reply['messages'][] = ['type' => 'template', 'altText' => 'すみません...', 'template' => $template];
}
