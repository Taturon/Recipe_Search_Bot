<?php

$reply['messages'][0] = [
	'type' => 'template',
	'altText' => '半径設定用のボタンテンプレート',
	'template' => [
		'type' => 'buttons',
		'title' => 'お店検索の検索半径設定',
		'text' => '下記よりを選択して下さい',
		'actions' => [
			[
				'type' => 'postback',
				'label' => '300 m',
				'data' => '1',
				'displayText' => '300 m'
			],
			[
				'type' => 'postback',
				'label' => '500 m',
				'data' => '2',
				'displayText' => '500 m'
			],
			[
				'type' => 'postback',
				'label' => '1 km',
				'data' => '3',
				'displayText' => '1 km'
			],
			[
				'type' => 'postback',
				'label' => '3 km',
				'data' => '5',
				'displayText' => '3 km'
			]
		]
	]
];
