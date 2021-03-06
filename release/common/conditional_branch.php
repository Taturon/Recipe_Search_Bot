<?php

// 入力値による分岐処理
switch ($message['text']) {
	case 'レシピ検索':
		require_once('../recipe_search/recipe_search_text.php');
		break;
	case '気分 de レシピ':
		require_once('../feelings/feelings.php');
		break;
	case 'スタミナが欲しい':
	case '二日酔い':
	case '元気が欲しい':
	case '風邪気味':
		require_once('../feelings/recipes_by_feeling.php');
		break;
	case 'お店検索':
		require_once('../restaurant_search/explanatory_text.php');
		break;
	case '単位換算':
		require_once('../calculate/calculate_text.php');
		break;
	case '検索履歴':
		require_once('../histories/search_histories.php');
		break;
	case '半径設定':
		require_once('../set_radius/select_radius.php');
		break;
	default:
		require_once('../calculate/calculate.php');
		break;
}
