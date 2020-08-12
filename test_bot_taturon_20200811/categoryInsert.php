<?php

/*
注意:ブラウザ確認の更新やCUIでのphpコマンド実行によって大量のデータが
dbConnect.phpで設定したDBに挿入されます。実行時は注意して下さい
 */


/*
ーーーーーーーーーー
入力パラメータの設定
ーーーーーーーーーー
 */


// 楽天レシピカテゴリ一覧APIのリクエストURL
$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryList/20170426';

// アプリID（Rakuten DevelopersのアプリID発行で発行されるID）
$params['applicationId'] = '1006164421113190409';

// データ形式の設定
$params['format'] = 'json';

// カテゴリタイプを指定、今回は最下位（細かいカテゴリも全て）を指定
$params['categoryType'] = 'small';

// 引っ張ってくるデータを指定（カテゴリ名とそのレシピのURL）
$params['elements'] = 'categoryName,categoryUrl';


/*
ーーーーーーーーーーーーーーーーー
リクエストURLの生成とデータの取得
ーーーーーーーーーーーーーーーーー
 */


// エラー回避のためGETパラメータ文字列格納用変数を初期化
$canonical_string = '';

// 配列$paramsのキーと値をURLのGETパラメータの形式で追加していく
foreach($params as $k => $v) {
	$canonical_string .= '&' . $k . '=' . $v;
}

// GETパラメーター先頭の"&"は不要なので削除
$canonical_string = substr($canonical_string, 1);

// APIのベースURLに上記の文字列化したGETパラメーターを連結
$url = $baseurl . '?' . $canonical_string;

// 楽天レシピカテゴリ一覧APIからデータを取得
$categories = json_decode(@file_get_contents($url, true))->result->small;


/*
ーーーーーーーーー
DB格納用配列の生成
ーーーーーーーーー
*/


// 配列データの繰り返し処理
foreach ($categories as $key => $category) {

	// 変数$recipesに$keyと"name"をキーとし、カテゴリ名を値として格納
	$recipes[$key]['name'] = $category->categoryName;

	// 取得してきたレシピURLのカテゴリIDを示す文字列以外を空文字に置き換える
	// この時点で「[カテゴリID]/」が取得できる
	$category_id = str_replace('https://recipe.rakuten.co.jp/category/', '', $category->categoryUrl);

	// 文末の余分なスラッシュを削除
	$category_id = substr($category_id, 0, -1);

	// カテゴリ名と同様に$keyと"category_id"をキーとし、上記のカテゴリIDを値として格納
	$recipes[$key]['category_id'] = $category_id;
}


/*
ーーーーーーーー
DBへのデータ保存
ーーーーーーーー
 */


// DB接続設定の読み込み
require_once('dbConnect.php');

// データ挿入のSQL文の発行
$sql = 'INSERT INTO rakuten_recipe (category_name, category_id) VALUES (?, ?)';

// prepareでSQL実行の準備
$stmt = $dbh->prepare($sql);

// 全データが挿入された場合のみDBに変更が反映されるようにtry-catch文を使用
try {

	// トランザクションの開始
	// PDOのオートコミットモードをオフにし
	// 一回一回の繰り返しでDBに変更がいちいち反映されるのを防ぐ
	$dbh->beginTransaction();

	// 多次元配列として格納したカテゴリ名とカテゴリIDの
	// それぞれに対しbindParam及びSQL実行
	foreach ($recipes as $recipe) {
		$stmt->bindParam(1, $recipe['name'], PDO::PARAM_STR);
		$stmt->bindParam(2, $recipe['category_id'], PDO::PARAM_STR);
		$stmt->execute();
	}

	// 繰り返し処理でエラーがなければ（全データがの挿入が完了したなら）
	// コミットしてDBへ変更を反映してオートコミットモードへ戻す
	$dbh->commit();

// エラーが発生した場合の処理
} catch (Exception $e) {

	// DBの全ての変更を取り消し、オートコミットモードへ戻す
	$dbh->rollBack();

	// フィードバック
	exit('データ保存に失敗しました<br>' . $e->getMessage());;
}
