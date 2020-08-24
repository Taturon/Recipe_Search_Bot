<?php
//グーグルスプレッドシートのデータを関数化する
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
	$sheet_id = 'スプレッドシートID';//対象のスプレッドシートのIDを指定
	$range = 'test!A1:B1575';//取得範囲を指定（dataシートのA1〜B8）
	$response = $sheet->spreadsheets_values->get($sheet_id, $range);
	$values = $response->getValues();//帰ってきたresponseから値を取得
	return $values;
}

$values = getData();
//返ってきた値を変数に格納
//$message['text'] = '肉';
$values = getData();
//スプレッドシート内の値を検索するために最初にforeach
foreach ($values as $value) {
	$value['category_name'] = $value[0];
	$value['category_id'] = $value[1];
	unset ($value[0], $value[1]);
	//あいまい検索を行いヒットした値を出力する
	if (strpos($value['category_name'], $message['text']) !== false) {
		$ids[] = $value;
	}
}

//材料名がGSSになかった場合
if ($ids == null) {
	$reply['messages'][0]['text'] = '申し訳ありません。その操作には対応しておりません';
}

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
	require_once('makeCarousel.php');
}
