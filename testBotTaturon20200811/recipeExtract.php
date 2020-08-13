<?php

/*
ーーーーーーーーーーーーーーーーーーー
入力値を用いてDB検索し、idを配列に格納
ーーーーーーーーーーーーーーーーーーー
 */


// 入力値の設定
// 制御文字が入力されても検索できるように\\でエスケープ
$search = '%\\' . $message['text'] . '%';

// DB接続ファイルの読み込み
require_once('dbConnect.php');

// 曖昧検索のSQL文発行
$sql = "SELECT category_id FROM rakuten_recipe WHERE category_name LIKE ?";

// prepareでSQL実行の準備
$stmt = $dbh->prepare($sql);

// プレースホルダーへ値のバインド
$stmt->bindValue(1, $search, PDO::PARAM_STR);

// SQL文の実行
$stmt->execute();

// 取得したカテゴリIDを配列データとしてフェッチ
$ids = $stmt->fetchAll();


/*
ーーーーーーーーーーーーーーーーーーーーー
取得したidを使ってレシピデータを配列に格納
ーーーーーーーーーーーーーーーーーーーーー
 */


// 取得したIDそれぞれを用いて楽天レシピカテゴリ別ランキングAPIからレシピデータを取得
foreach ($ids as $key => $id) {

	// 楽天レシピカテゴリ別ランキングAPIのリクエストURL
	$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426';

	// アプリID（Rakuten DevelopersのアプリID発行で発行されるID）
	$params['applicationId'] = '1070228718341633238';

	// 取得するデータを指定
	$params['elements'] = 'foodImageUrl,recipeDescription,recipeMaterial,recipeUrl,recipeTitle';

	// カテゴリidをGETパラメーター生成用の変数に格納
	$params['categoryId'] = $id['category_id'];

	// エラー回避のため変数を初期化
	$canonical_string = '';

	// 配列$paramsのキーと値をURLのGETパラメータの形式で追加していく
	foreach($params as $k => $v) {
		$canonical_string .= '&' . $k . '=' . $v;
	}

	// GETパラメーター先頭の"&"は不要なので削除
	$canonical_string = substr($canonical_string, 1);

	// APIのベースURLに上記の文字列化したGETパラメーターを連結
	$url = $baseurl . '?' . $canonical_string;

	// 楽天レシピカテゴリ別ランキングAPIからデータを取得
	$recipes[$key] = json_decode(@file_get_contents($url, true), true);
}


/*
ーーーーーーーーーー
返信用テキストの作成
ーーーーーーーーーー
 */

// 変数の初期化
$reply = '';

// 得られたレシピデータを繰り返し処理
foreach ($recipes as $key => $recipe) {

	// 配列に"result"キーとした余分な階層があるので
	// その階層の中でさらに繰り返し処理
	foreach ($recipe['result'] as $data) {

		// レシピタイトルとそのURLを改行を挟んで連結
		$reply .= $data['recipeTitle'] . "\n";
		$reply .= $data['recipeUrl'] . "\n";
	}
}

// 返信用の値として格納
$message['text'] = $reply;
