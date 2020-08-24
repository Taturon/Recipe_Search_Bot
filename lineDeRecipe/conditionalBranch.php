<?php

// 入力値による分岐処理
switch ($message['text']) {
	case 'レシピ検索':
		require_once('recipeSearchText.php');
		break;
	case '気分 de レシピ':
		require_once('feelings.php');
		break;
	case 'スタミナがつく料理':
		$feeling_id = 1;
	case '二日酔いに効く料理':
		$feeling_id = 2;
	case '食欲が出る料理':
		$feeling_id = 3;
	case '風邪気味に効く料理':
		$feeling_id = 4;
		require_once('recipesByFeeling.php');
		break;
	case '単位換算':
		require_once('calculateText.php');
		break;
	case 'むらっしゅさんのお言葉':
		require_once('murashuBot.php');
		break;
	default:
		require_once('calculate.php');
		break;
}
