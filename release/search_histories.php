<?php

require_once('db_connect.php');

$line_id = $event['source']['userId'];
$sql = 'SELECT `word` from `histories` WHERE `line_id` = ? ORDER BY `id` DESC LIMIT 10';
$stmt = $dbh->prepare($sql);
$stmt->execute([$line_id]);
$histories = $stmt->fetchAll();

if (count($histories) > 0) {
	$reply['messages'][0]['text'] = '直近10件の検索履歴です!';
	foreach ($histories as $history) {
		$reply['messages'][0]['quickReply']['items'][] = [
			'type' => 'action',
			'action' => [
				'type' => 'message',
				'label' => $history['word'],
				'text' => $history['word']
			]
		];
	}
} else {
	$reply['messages'][0]['text'] = '検索履歴がありません';
}
