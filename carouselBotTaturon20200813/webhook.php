<?php

require_once('./LINEBotTiny.php');

$channelAccessToken = '[各人のアクセストークン]';
$channelSecret = '[各人のチャンネルシークレット]';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
		case 'message':
			$message = $event['message'];
			switch ($message['type']) {
				case 'text':
					$reply['replyToken'] = $event['replyToken'];
					$reply['messages'][] = ['type' => 'text', 'text' => $message['text']];
					require_once('recipeExtract.php');
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
