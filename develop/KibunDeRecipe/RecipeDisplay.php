<?php
if (preg_match('/気分Deレシピ/', $message['text'])) {
	$messages = array('スタミナがつく料理', '二日酔いに効く料理', '食欲が出る料理', '風邪気味に効く料理', 'タイ料理が食べたい');
	foreach ($messages as $message) {
		 $reply['messages'][0]['quickReply']['items'][] = [
			'type' => 'action',
			'action' => [
				'type' => 'message',
				'label' => $message,
				'text' => $message
			]
		];
	}
}
require_once('dbConnect.php');
if ($message['text'] == 'スタミナがつく料理') {
	$feeling_number = 1;
} elseif ($message['text'] == '二日酔いに効く料理') {
	$feeling_number = 2;
} elseif ($message['text'] == '食欲が出る料理') {
	$feeling_number = 3;
} elseif ($message['text'] == '風邪気味に効く料理') {
	$feeling_number = 4;
} elseif ($message['text'] == 'タイ料理が食べたい') {
	$feeling_number = 5;
}
$select = 'SELECT * FROM rakuten_recipe WHERE feeling_recipe_id = :feeling_recipe_id';
$select_data = $dbh->prepare($select);
$select_params = array(':feeling_recipe_id' => $feeling_number);
$select_data->execute($select_params);
$ids = $select_data->fetchAll();


if ($ids) {
	// 検索ヒット件数が多い場合の処理
	// ヒット件数が13件(クイックリプライの上限)より多い場合

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
					$str_t = str_replace(PHP_EOL, '', $data['recipeTitle']);
					$str_t = preg_split('//u', $str_t, 0, PREG_SPLIT_NO_EMPTY);
					$title = '';
					for ($i = 0; $i < 37; $i++) {
						$title .= $str_t[$i];
					}
					$title .= '...';
				} else {
					$title = str_replace(PHP_EOL, '', $data['recipeTitle']);
				}

				// 説明が60文字以上の場合はトリミング
				if (mb_strlen($data['recipeDescription']) > 60) {
					$str_d = str_replace(PHP_EOL, '', $data['recipeDescription']);
					$str_d = preg_split('//u', $str_d, 0, PREG_SPLIT_NO_EMPTY);
					$description = '';
					for ($i = 0; $i < 57; $i++) {
						$description .= $str_d[$i];
					}
					$description .= '...';
				} else {
					$description = str_replace(PHP_EOL, '', $data['recipeDescription']);
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
							'label' => '詳細はこちら>>'
						]
					]
				];
			}
		}

		// テンプレートオブジェクト及びカルーセルテンプレートの生成
		$template = ['type' => 'carousel', 'columns' => $columns];
		$reply['messages'][0] = ['type' => 'template', 'altText' => 'すみません...', 'template' => $template];

	} else {
		require_once('recipeExtract.php');
	}
?>
