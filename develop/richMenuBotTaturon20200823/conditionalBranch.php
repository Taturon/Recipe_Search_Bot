<?php

// 入力値による分岐処理
switch ($message['text']) {
	case 'レシピ検索':
		$rep = "「ジャガイモ」「ブロッコリー」";
		$rep .= "\nなどの食材名や";
		$rep .= "\n「お弁当 ゆで卵」「卵を使わない」";
		$rep .= "\nなどの食材名以外の";
		$rep .= "\nキーワードを教えて頂くと";
		$rep .= "\n対応するレシピをお教えします！";
		$reply['messages'][0]['text'] = $rep;
		break;
	case '気分 de レシピ':
		require_once('feelings.php');
		break;
	case 'スタミナがつく料理':
	case '二日酔いに効く料理':
	case '食欲が出る料理':
	case '風邪気味に効く料理':
		require_once('recipesByFeeling.php');
		break;
	case '単位換算':
		$rep = "ml/L/g/小さじ/大さじ/カップ";
		$rep .= "\nを互いに換算します！";
		$rep .= "\n入力例）「みりん1ml」「醤油大3」";
		$reply['messages'][0]['text'] = $rep;
		break;
	case 'むらっしゅさんのお言葉':
		// 要処理ファイル読み込み追加
		break;
	default:
		require_once('calculate.php');
		break;
}
