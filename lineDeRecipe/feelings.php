<?php

// 下記画像はテスト画像です
$base_url = 'https://procir-study.site/kobayashi320/images';

// イメージマップの設定
$reply['messages'][0] = [
	'type' => 'imagemap',
	'baseUrl' => $base_url,
	'altText' => '気分 de レシピのイメージマップ',
	'baseSize' => ['width' => 1040, 'height' => 1040],
	'actions' => [
		[
			'type' => 'message',
			'text' => 'スタミナがつく料理',
			'area' => [
				'x' => 0,
				'y' => 0,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '二日酔いに効く料理',
			'area' => [
				'x' => 520,
				'y' => 0,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '食欲が出る料理',
			'area' => [
				'x' => 0,
				'y' => 520,
				'width' => 520,
				'height' => 520
			]
		],
		[
			'type' => 'message',
			'text' => '風邪気味に効く料理',
			'area' => [
				'x' => 520,
				'y' => 520,
				'width' => 520,
				'height' => 520
			]
		],
	]
];

/*
	// クイックリプライの場合
	$messages = array('スタミナがつく料理', '二日酔いに効く料理', '食欲が出る料理', '風邪気味に効く料理');
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
