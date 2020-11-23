<?php

// ヒット件数を変数に格納
$count = count($info['shop']);

// 画像カルーセルの上限まで結果をセット
for ($i = 0; $i < 13; $i++) {
	$data = $info['shop'][$i];

	// タイトルが40文字以上の場合はトリミング
	if (mb_strlen($data['name']) > 40) {
		$str_t = str_replace(PHP_EOL, '', $data['name']);
		$str_t = preg_split('//u', $str_t, 0, PREG_SPLIT_NO_EMPTY);
		$title = '';
		for ($i = 0; $i < 37; $i++) {
			$title .= $str_t[$i];
		}
		$title .= '...';

	// デフォルトでは改行文字を削除
	} else {
		$title = str_replace(PHP_EOL, '', $data['name']);
	}

	// 説明が60文字以上の場合はトリミング
	if (mb_strlen($data['access']) > 60) {
		$str_d = str_replace(PHP_EOL, '', $data['access']);
		$str_d = preg_split('//u', $str_d, 0, PREG_SPLIT_NO_EMPTY);
		$description = '';
		for ($i = 0; $i < 57; $i++) {
			$description .= $str_d[$i];
		}
		$description .= '...';

	// デフォルトでは改行文字を削除
	} else {
		$description = str_replace(PHP_EOL, '', $data['access']);
	}

	// 画像テンプレテートの部品を構築
	$columns[] = [
		'thumbnailImageUrl' => $data['photo']['pc']['l'],
		'title'   => $title,
		'text'    => $description,
		'actions' => [
			[
				'type' => 'uri',
				'uri' => $data['urls']['pc'],
				'label' => '詳細はこちら>>'
			]
		]
	];

	// 検索ヒット件数と同じ件数まで到達した場合
	if ($i + 1 === $count) {
		break;
	}
}

// テンプレートオブジェクト及びカルーセルテンプレートの生成
$template = ['type' => 'carousel', 'columns' => $columns];
$reply['messages'][0] = ['type' => 'template', 'altText' => 'すみません...', 'template' => $template];
