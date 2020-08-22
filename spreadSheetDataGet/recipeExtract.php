<?php
//色々試した結果、関数にしないとできませんでした
function getData() {
	require __DIR__. '/vendor/autoload.php';

	//ダウンロードしたファイル
	$keyFile = __DIR__. "/linebot-4d3669a28a66.json";//取得したサービスキーのパスを指定

	$client = new Google_Client();//Googleクライアントインスタンスを作成
	$client->setScopes([//スコープを以下の内容でセット
	\Google_Service_Sheets::SPREADSHEETS,
	\Google_Service_Sheets::DRIVE,]);
	$client->setAuthConfig($keyFile);//サービスキーをセット

	$sheet = new Google_Service_Sheets($client);//シートを操作するインスタンス
	$sheet_id = '●●●●';//対象のスプレッドシートのIDを指定
	$range = 'test!A1:B1575';//取得範囲を指定（dataシートのA1〜B8）
	$response = $sheet->spreadsheets_values->get($sheet_id, $range);
	$values = $response->getValues();//帰ってきたresponseから値を取得
	return $values;
}


//返ってきた値を変数に格納
$values = getData();
$message['text'] = 'ソーセージ';
//スプレッドシート内の値を検索するために最初にforeach
foreach ($values as $value) {
	$value['category_name'] = $value[0];
	$value['category_id'] = $value[1];
	unset ($value[0], $value[1]);
	//strposを使ってあいまい検索を行いヒットした値を出力する
	if (strpos($value['category_name'], $message['text']) !== false) {


		// ヒット件数が13件より多い場合(クイックリプライの上限)
		if (count($value) > 13) {
			$rep = count($ids) . "件ヒットしました！";
			$rep .= "\n対応するレシピが多すぎます！";
			$rep .= "\nもう少し具体的に\n教えて欲しいです！";
			$reply['messages'][0]['text'] = $rep;

			// ヒット件数が1件より多い場合
		} elseif (count($value) > 1) {
			$rep = count($value) . "件ヒットしました！";
			$rep .= "\n下記より選択して下さい！";
			//var_dump($ids['category_id']);
			$reply['messages'][0]['text'] = $rep;
			//foreach ($ids as $id) {
				$reply['messages'][0]['quickReply']['items'][] = [
					'type' => 'action',
					'action' => [
						'type' => 'message',
						'label' => $value['category_name'],
						'text' => $value['category_name']
					]
				];
			//}
			//ヒット件数が1件の場合
		} elseif (count($value) === 1) {
			// 取得したidを使ってレシピデータを配列に格納
			$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426';
			$params['applicationId'] = '1070228718341633238';
			$params['elements'] = 'recipeTitle,recipeDescription,recipeMaterial,foodImageUrl,recipeUrl';
			$params['categoryId'] = $value['category_id'];
			$canonical_string = '';
			foreach($params as $k => $v) {
				$canonical_string .= '&' . $k . '=' . $v;
			}
			$canonical_string = substr($canonical_string, 1);
			$url = $baseurl . '?' . $canonical_string;
			$recipes = json_decode(@file_get_contents($url, true), true);
			// 得られた結果を繰り返し処理
			foreach ($recipes as $recipe['result']) {

				// 各データの最上位にresult階層があるので更に繰り返し処理
				foreach ($recipe['result'] as $data) {
					var_dump($data);
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
						'title' => $title,
						'text' => $description,
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
			var_dump($template);
		}
	}
}
