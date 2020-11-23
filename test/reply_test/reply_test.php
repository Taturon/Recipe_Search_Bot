<?php
// テストしたい機能のコメントアウトを外して下さい

/*
// テキストを返す
$reply['messages'][0] = ['type' => 'text', 'text' => 'ホゲホゲ'];
 */

/*
// ボタンテンプレートを返す
$reply['messages'][0] = [
	'type' => 'template',
	'altText' => 'ボタンテンプレート',
	'template' => [
		'type' => 'buttons',
		'title' => 'ボタン',
		'text' => '下記より選択して下さい',
		'actions' => [
			[
				'type' => 'postback',
				'label' => '1',
				'data' => '1',
				'displayText' => '1'
			],
			[
				'type' => 'postback',
				'label' => '2',
				'data' => '2',
				'displayText' => '2'
			],
			[
				'type' => 'postback',
				'label' => '3',
				'data' => '3',
				'displayText' => '3'
			],
			[
				'type' => 'postback',
				'label' => '4',
				'data' => '4',
				'displayText' => '4'
			]
		]
	]
];
*/

/*
// 画像を返す
$reply['messages'][0] = [
	'type' => 'image',
	'originalContentUrl' => 'https://taturon.com/recipe_search_bot/images/1040',
	'previewImageUrl' => 'https://taturon.com/recipe_search_bot/images/1040'
];
 */

/*
// 位置情報を返す
$reply['messages'][] = [
	'type' => 'location',
	'title' => '位置情報',
	'address' => '〒150-0002 東京都渋谷区渋谷２丁目２１−１',
	'latitude' => 35.65910807942215,
	'longitude' => 139.70372892916203
];
 */

/*
// イメージマップを返す
$base_url = 'https://taturon.com/recipe_search_bot/images/test';

$reply['messages'][0] = [
	'type' => 'imagemap',
	'baseUrl' => $base_url,
	'altText' => 'イメージマップです',
	'baseSize' => ['width' => 1040, 'height' => 1040],
	'actions' => [
		[
			'type' => 'message',
			'text' => '左上',
			'area' => [
				'x' => 0,
				'y' => 0,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '右上',
			'area' => [
				'x' => 520,
				'y' => 0,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '左下',
			'area' => [
				'x' => 0,
				'y' => 520,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '右下',
			'area' => [
				'x' => 520,
				'y' => 520,
				'width' => 520,
				'height' => 520
			]
		],
	]
];
 */

/*
// 画像カルーセルを返す
$columns = [
	[
		'thumbnailImageUrl' => 'https://jp.rakuten-static.com/recipe-space/d/strg/ctrl/3/afa0c6062c8dd35a14c650fb01add81186989b37.89.2.3.2.jpg?thum=58',
		'title'   => 'ご飯がモリモリ進む・納豆みそ',
		'text'    => 'まったく納豆が食べられないパパが、これなら「食べれる♪」と言いました!子ども達は大量に食べます☆冷蔵庫で保管も出来ま',
		'actions' => [
			[
				'type' => 'uri',
				'uri' => 'https://recipe.rakuten.co.jp/recipe/1350003742/',
				'label' => '詳しく見てみる'
			]
		]
	],
	[
		'thumbnailImageUrl' => 'https://jp.rakuten-static.com/recipe-space/d/strg/ctrl/3/e89f1f94f70329500e8ff446d51d23fc8bc050ac.72.2.3.2.jpg?thum=58',
		'title'   => '猪肉の角煮 レシピ・作り方',
		'text'    => '栄養たっぷりのジビエ猪肉を食べやすい角煮にしてみました。',
		'actions' => [
			[
				'type' => 'uri',
				'uri' => 'https://recipe.rakuten.co.jp/recipe/1050016451/?l-id=r_recom_category',
				'label' => '詳しく見てみる'
			]
		]
	]
];
$template = ['type' => 'carousel', 'columns' => $columns];
$reply['messages'][] = ['type' => 'template', 'altText' => 'すみません...', 'template' => $template];
 */
