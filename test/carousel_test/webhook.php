<?php

require_once('./line_bot_tiny.php');

$channel_access_token = '[FILTERED]';
$channel_secret = '[FILTERED]';

$client = new LINEBotTiny($channel_access_token, $channel_secret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
		case 'message':
			$message = $event['message'];
			switch ($message['type']) {
				case 'text':
					$reply['replyToken'] = $event['replyToken'];
					$reply['messages'][] = ['type' => 'text', 'text' => $message['text']];
					require_once('carousel_test.php');
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
