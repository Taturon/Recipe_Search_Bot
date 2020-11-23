<?php

require_once('db_connect.php');

$line_id = $event['source']['userId'];
date_default_timezone_set('Asia/Tokyo');
$retention_period = require_once('../../config/retention_period.php');
$retention_limit = date('Y-m-d H:i:s', strtotime('-' . $retention_period['retention_period'] . ' day'));
$sql = 'SELECT `word` from `histories` WHERE `line_id` = ? AND created_at >= ? ORDER BY `created_at` DESC LIMIT 10';
$stmt = $dbh->prepare($sql);
$stmt->execute([$line_id, $retention_limit]);
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
