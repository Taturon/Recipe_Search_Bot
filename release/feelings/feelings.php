<?php

$base_url = 'https://taturon.com/recipe_search_bot/images/feelings';

// イメージマップの設定
$reply['messages'][0] = [
	'type' => 'imagemap',
	'baseUrl' => $base_url,
	'altText' => '気分deレシピのイメージマップを表示中',
	'baseSize' => ['width' => 1040, 'height' => 1040],
	'actions' => [
		[
			'type' => 'message',
			'text' => 'スタミナが欲しい',
			'area' => [
				'x' => 0,
				'y' => 0,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '二日酔い',
			'area' => [
				'x' => 520,
				'y' => 0,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '元気が欲しい',
			'area' => [
				'x' => 0,
				'y' => 520,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '風邪気味',
			'area' => [
				'x' => 520,
				'y' => 520,
				'width' => 520,
				'height' => 520
			]
		],
	]
];
