<?php

/*
動作確認される場合は下記の[アクセストークン]、[チャンネルシークレット]を
適切な値に置き換え、ご自身のオウム返しボットのwebhook URLを
このファイルが設置されているディレクトリのパスを反映させたものに
設定して下さい。
*/

require_once('./LINEBotTiny.php');

$channelAccessToken = '[アクセストークン]';
$channelSecret = '[チャンネルシークレット]';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
	case 'message':
		$message = $event['message'];
		switch ($message['type']) {
		case 'text':
			require_once('recipe_extract.php');
			$client->replyMessage([
				'replyToken' => $event['replyToken'],
				'messages' => [
					[
						'type' => 'text',
						'text' => $message['text']
					]
				]
			]);
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
