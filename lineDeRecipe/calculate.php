<?php

// 正規表現の設定
$reg_exp1 = '/[０-９0-9.０-９0-9]+(ml|mL|ミリリットル|l|L|リットル|g|グラム|cup|カップ)/u';
$reg_exp2 = '/[^(ml)|^(mL)|^(ミリリットル)|^(l)|^(L)|^(リットル)|^(g)|^(グラム)|^(cup)|^(カップ)]/u';
$reg_exp3 = '/(大さじ|小さじ|大|小)[０-９0-9.０-９0-9]+杯*/u';
$reg_exp4 = '/[^(大さじ)|^(小さじ)|^(大)|^(小)]/u';

// ml・g・cupの場合
if (preg_match($reg_exp1, $message['text'])) {

	// 数値・単位・換算対象文字列の抽出
	$n = mb_convert_kana($message['text'], 'n');
	$n = preg_replace('/[^0-9.]/', '', $n);
	$unit = preg_replace($reg_exp2, '', $message['text']);
	$str = preg_replace($reg_exp1, '', $message['text']);

	if (is_numeric($n)) {

		// 換算対象文字列でDB検索
		require_once('dbConnect.php');
		$sql = 'SELECT name, tea_spoon, table_spoon, cup FROM seasonings WHERE name = ?';
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(1, $str, PDO::PARAM_STR);
		$stmt->execute();
		$units = $stmt->fetch();

		// 検索結果があった場合
		if ($units) {
			switch ($unit) {
				case 'ml':
				case 'mL':
				case 'ミリリットル':
					// 換算
					$tea_spoon = round($n / 5, 1);
					$table_spoon = round($n / 15, 1);
					$cup = round($n / 200, 1);
					$g = round($units['cup'] / 200 * $n, 1);

					// 返信用メッセージの作成
					$rep = '小さじ約' . $tea_spoon . '杯' . PHP_EOL;
					$rep .= '大さじ約' . $table_spoon . '杯' . PHP_EOL;
					$rep .= '約' . $cup . ' カップ' . PHP_EOL;
					$rep .= '約' . $g . ' g' . PHP_EOL;
					break;
				case 'l':
				case 'L':
				case 'リットル':
					// 換算
					$tea_spoon = round($n * 1000 / 5, 1);
					$table_spoon = round($n * 1000 / 15, 1);
					$cup = round($n * 1000 / 200, 1);
					$g = round($units['cup'] / 200 * $n * 1000, 1);

					// 返信用メッセージの作成
					$rep = '小さじ約' . $tea_spoon . '杯' . PHP_EOL;
					$rep .= '大さじ約' . $table_spoon . '杯' . PHP_EOL;
					$rep .= '約' . $cup . ' カップ' . PHP_EOL;
					$rep .= '約' . $g . ' g' . PHP_EOL;
					break;
				case 'g':
				case 'グラム':
					// 換算
					$tea_spoon = round($n / (float)$units['tea_spoon'], 1);
					$table_spoon = round($n / (float)$units['table_spoon'], 1);
					$cup = round($n / $units['cup'], 1);
					$ml = round(200 / $units['cup'] * $n, 1);

					// 返信用メッセージの作成
					$rep = '小さじ約' . $tea_spoon . '杯' . PHP_EOL;
					$rep .= '大さじ約' . $table_spoon . '杯' . PHP_EOL;
					$rep .= '約' . $cup . ' カップ' . PHP_EOL;
					$rep .= '約' . $ml . ' ml' . PHP_EOL;
					break;
				case 'cup':
				case 'カップ':
					// 換算
					$tea_spoon = round($n * 40, 1);
					$table_spoon = round($n * 200 / 15, 1);
					$ml = round($n * 200, 1);
					$g = round($units['cup'] * $n, 1);

					// 返信用メッセージの作成
					$rep = '小さじ約' . $tea_spoon . '杯' . PHP_EOL;
					$rep .= '大さじ約' . $table_spoon . '杯' . PHP_EOL;
					$rep .= '約' . $ml . ' ml' . PHP_EOL;
					$rep .= '約' . $g . ' g' . PHP_EOL;
					break;
			}
			$rep .= 'です!';
			$reply['messages'][0]['text'] = $rep;

		// DB検索に引っかからなかった場合
		} else {
			$rep = 'すみません...' . PHP_EOL;
			$rep .= 'お探しの調味料は' . PHP_EOL;
			$rep .= 'データベースに' . PHP_EOL;
			$rep .= '登録されておりません';
			$reply['messages'][0]['text'] = $rep;
		}
	}

// 小さじ・大さじの場合
} elseif (preg_match($reg_exp3, $message['text'])) {

	// 数値・単位・換算対象文字列の抽出
	$n = mb_convert_kana($message['text'], 'n');
	$n = preg_replace('/[^0-9.]/', '', $n);
	$unit = preg_replace($reg_exp4, '', $message['text']);
	$str = preg_replace($reg_exp3, '', $message['text']);

	if (is_numeric($n)) {

		// 換算対象文字列でDB検索
		require_once('dbConnect.php');
		$sql = 'SELECT name, tea_spoon, table_spoon, cup FROM seasonings WHERE name = ?';
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(1, $str, PDO::PARAM_STR);
		$stmt->execute();
		$units = $stmt->fetch();

		// 検索結果があった場合
		if ($units) {
			switch ($unit) {
				case '小':
				case '小さじ':
					// 換算
					$table_spoon = round($n / 3, 1);
					$cup = round($n / 40, 1);
					$ml = round($n * 5, 1);
					$g = round($units['tea_spoon'] * $n, 1);

					// 返信用メッセージの作成
					$rep = '大さじ約' . $table_spoon . '杯' . PHP_EOL;
					$rep .= '約' . $cup . ' カップ' . PHP_EOL;
					$rep .= '約' . $ml . ' ml' . PHP_EOL;
					$rep .= '約' . $g . ' g' . PHP_EOL;
					break;
				case '大':
				case '大さじ':
					// 換算
					$tea_spoon = round($n * 3, 1);
					$cup = round($n / (200 / 15), 1);
					$ml = round($n * 15, 1);
					$g = round($units['table_spoon'] * $n, 1);

					// 返信用メッセージの作成
					$rep = '小さじ約' . $tea_spoon . '杯' . PHP_EOL;
					$rep .= '約' . $cup . ' カップ' . PHP_EOL;
					$rep .= '約' . $ml . ' ml' . PHP_EOL;
					$rep .= '約' . $g . ' g' . PHP_EOL;
					break;
			}
			$rep .= 'です!';
			$reply['messages'][0]['text'] = $rep;

		// DB検索に引っかからなかった場合
		} else {
			$rep = 'すみません...' . PHP_EOL;
			$rep .= 'お探しの調味料は' . PHP_EOL;
			$rep .= 'データベースに登録されておりません';
			$reply['messages'][0]['text'] = $rep;
		}
	}

// 単位換算ではなかった場合
} else {
	require_once('recipeExtract.php');
}
