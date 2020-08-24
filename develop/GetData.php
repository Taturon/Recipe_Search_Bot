<?php
require_once __DIR__ . '/vendor/autoload.php';

$keyFile = __DIR__. "/credentials.json";

$client = new Google_Client();//Googleクライアントインスタンスを作成
$client->setScopes([//スコープを以下の内容でセット
	    \Google_Service_Sheets::SPREADSHEETS,
		    \Google_Service_Sheets::DRIVE,]);
$client->setAuthConfig($keyFile);//サービスキーをセット

$sheet = new Google_Service_Sheets($client);//シートを操作するインスタンス
$sheet_id = '1LvO-cN-zGSRuXR0dnhJnCVTKiTUd6HMc3Xhuwc2Sk1U';//対象のスプレッドシートのIDを指定
$range = 'シート1!A1:M100';//取得範囲を指定（dataシートのA1〜B8）
$response = $sheet->spreadsheets_values->get($sheet_id, $range);
$values = $response->getValues();//帰ってきたresponseから値を取得

print_r($values);
?>
