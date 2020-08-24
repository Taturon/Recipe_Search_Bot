<?php
if (preg_match('/むらっしゅさんのお言葉/', $message['text'])) {
	require_once('dbConnect.php');
	$i = rand(1, 15);
	$data_get = $dbh->prepare('SELECT tweet FROM murashu_tweets WHERE id = :id');
	$data_get->execute(array('id' => $i));
	$tweet = $data_get->fetch();

	$template = array('type' => 'confirm',
		'text' => $tweet['tweet'],
		'actions' => array(
			array('type'=>'message', 'label'=>'もう一声！', 'text'=>'むらっしゅさんのお言葉' ),
			array('type'=>'message', 'label'=>'レシピ検索', 'text'=>'レシピ検索' )
		)
	);

	$reply['messages'][0] = array('type' => 'template',
		'altText' => '代替テキスト',
		'template' => $template
	);
}

?>
