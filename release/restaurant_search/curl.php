<?php

// 各パラメーターの設定
$base_url = 'https://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
$api_key= HOT_PEPPER_API_KEY;
$params['lat'] = $message['latitude'];
$params['lng'] = $message['longitude'];
$params['range'] = '5';
$params['order'] = '4';

// 検索クエリURLの組み立て
$url = $base_url . '?key=' . $api_key;
foreach ($params as $k => $param) {
	$url .= '&' . $k . '=' . $param;
}

// 情報の取得
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// データを配列化
$xml = simplexml_load_string($response);
$info = json_decode(json_encode($xml), true);

// 検索ヒット数による分岐
if ($info['results_available'] === '0') {
	require_once('restaurant_search/no_result_text.php');
} else {
	require_once('restaurant_search/make_carousel.php');
}
