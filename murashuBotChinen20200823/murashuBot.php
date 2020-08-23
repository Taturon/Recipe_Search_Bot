<?php
if (preg_match('/<値を入力>/', $message['text'])) {
	require_once('dbConnect.php');
	$i = rand(1, 15);
	$data_get = $dbh->prepare('SELECT tweet FROM murashu_tweets WHERE id = :id');
	$data_get->execute(array('id' => $i));
	$tweet = $data_get->fetch();

	$template = array('type' => 'confirm',
		'text' => $tweet['tweet'],
		'actions' => array(
			array('type'=>'message', 'label'=>'もう一声！', 'text'=>'<テキストメッセージを入力>' ),
			array('type'=>'message', 'label'=>'レシピ検索', 'text'=>'<レシピ検索のメッセージを入力>' )
		)
	);

	$reply['messages'][] = array('type' => 'template',
		'altText' => '代替テキスト',
		'template' => $template
	);
}

?>
