<?php

/*
注意:ブラウザ確認の更新やCUIでのphpコマンド実行によって大量のデータが
dbConnect.phpで設定したDBに挿入されます。実行時は注意して下さい
 */

// 入力パラメータの設定
$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426';
$params['applicationId'] = '1006164421113190409';
$params['format'] = 'json';
$params['categoryType'] = 'small';
$params['elements'] = 'categoryName,categoryUrl';

// リクエストURLの生成
$canonical_string = '';
foreach($params as $k => $v) {
		$canonical_string .= '&' . $k . '=' . $v;
}
$canonical_string = substr($canonical_string, 1);
$url = $baseurl . '?' . $canonical_string;
//var_dump($url);
// データの取得
$categories = json_decode(@file_get_contents($url, true))->result->small;
//var_dump($categories);
// DB格納用配列の生成
foreach ($categories as $key => $category) {
	$recipes[$key]['name'] = $category->categoryName;
	$category_id = str_replace('https://recipe.rakuten.co.jp/category/', '', $category->categoryUrl);
	$category_id = substr($category_id, 0, -1);
	$recipes[$key]['category_id'] = $category_id;
}

require __DIR__. '/vendor/autoload.php';

//ダウンロードしたファイル
$keyFile = __DIR__. "/credentials.json";

// アカウント認証情報インスタンスを作成
$client = new Google_Client();
$client->setAuthConfig($keyFile);
//任意名
$client->setApplicationName("Sheet API TEST");
//サービスの権限スコープ
$scopes = [Google_Service_Sheets::SPREADSHEETS];
$client->setScopes($scopes);

//シート情報を操作するインスタンスを生成
$sheet = new Google_Service_Sheets($client);

//保存するデータ
foreach ($recipes as $recipe) {
	$values = [
    	[$recipe['name'], $recipe['category_id']]
	];
	//データ操作領域を設定
	$body = new Google_Service_Sheets_ValueRange([
    	'values' => $values,
	]);
	//追記
	$response = $sheet->spreadsheets_values->append(
    "1LvO-cN-zGSRuXR0dnhJnCVTKiTUd6HMc3Xhuwc2Sk1U", // 作成したスプレッドシートのIDを入力
    'シート1', //シート名
    $body, //データ
    ["valueInputOption" => 'USER_ENTERED']
);

//書き込んだ処理結果を確認
var_export($response->getUpdates());
