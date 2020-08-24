<?php
$columns = [
	[
		'thumbnailImageUrl' => 'https://jp.rakuten-static.com/recipe-space/d/strg/ctrl/3/afa0c6062c8dd35a14c650fb01add81186989b37.89.2.3.2.jpg?thum=58',
		'title'   => 'ご飯がモリモリ進む・納豆みそ',
		'text'    => 'まったく納豆が食べられないパパが、これなら「食べれる♪」と言いました!!　子ども達は大量に食べます☆冷蔵庫で保管も出来ま',
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
