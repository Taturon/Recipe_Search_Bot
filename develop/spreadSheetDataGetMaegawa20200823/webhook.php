<?php

require_once('./LINEBotTiny.php');

$channelAccessToken = '1VzWykZ2v1j13XZzj+FUZ3M5i+rUM2vpvmevUvz2iHucHxlM7G4Ep/BHIAu5KF6WQ+dnFZE0WvKbnZSVuBbEU1kiimisa17ldsBDgl8Qsv57eXtxf6Iyv96zCn573msBCu93Ja2TpozqU4DLypfQrAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '3c29753317491acf27e2d2879fe9e43a';

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
