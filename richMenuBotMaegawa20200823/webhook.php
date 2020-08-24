<?php

require_once('./LINEBotTiny.php');

$channelAccessToken = 'チャンネルアクセストーク';
$channelSecret = 'チャンネルセレクト';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
		case 'message':
			$message = $event['message'];
			switch ($message['type']) {
				case 'text':
					$reply['replyToken'] = $event['replyToken'];
					$reply['messages'][] = ['type' => 'text', 'text' => $message['text']];
					require_once('conditionalBranch.php');
					$client->replyMessage($reply);
					break;
				default:
					error_log('Unsupported message type: ' . $message['type']);
					break;
			}
			break;
		default:
			error_log('Unsupported event type: ' . $event['type']);
			break;
	}
};
