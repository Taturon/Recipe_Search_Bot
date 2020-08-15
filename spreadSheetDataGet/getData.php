<?php

require __DIR__. '/../vendor/autoload.php';

//ダウンロードしたファイル
$keyFile = __DIR__. "/../▲▲▲▲▲▲.json";//取得したサービスキーのパスを指定

$client = new Google_Client();//Googleクライアントインスタンスを作成
$client->setScopes([//スコープを以下の内容でセット
		    \Google_Service_Sheets::SPREADSHEETS,
					    \Google_Service_Sheets::DRIVE,]);
$client->setAuthConfig($keyFile);//サービスキーをセット

$sheet = new Google_Service_Sheets($client);//シートを操作するインスタンス
$sheet_id = '●●●●●●';//対象のスプレッドシートのIDを指定
$range = 'test!A1:B1575';//取得範囲を指定（dataシートのA1〜B8）
$response = $sheet->spreadsheets_values->get($sheet_id, $range);
$values = $response->getValues();//帰ってきたresponseから値を取得

foreach ($values as $value) {
	if (strpos($value[0], '卵') !== false) {
		var_dump($value[0]);
	}
}
?>
