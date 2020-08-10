<?php
function getRakutenResult() {

	// ベースとなるリクエストURL
	$baseurl = 'https://app.rakuten.co.jp/services/api/Recipe/CategoryRanking/20170426';
	// リクエストのパラメータ作成
	$params = array();
	$params['applicationId'] = '1070228718341633238'; // アプリID
	$params['format'] = 'json';

	$canonical_string = '';
	foreach($params as $k => $v) {
		    $canonical_string .= '&' . $k . '=' . $v;
	}
	// 先頭の'&'を除去
	$canonical_string = substr($canonical_string, 1);

	// リクエストURL を作成
	$url = $baseurl . '?' . $canonical_string;
	var_dump($canonical_string);
	// XMLをオブジェクトに代入
	$rakuten_json = json_decode(@file_get_contents($url, true));
	$items = array();
	foreach($rakuten_json->result as $item) {
		$items[] = array(
			'title' => (string)$item->recipeTitle,
			'description' => (string)$item->recipeDescription,
			'img' => (string)$item->foodImageUrl,
			'url' => (string)$item->recipeUrl
		);
	}
	return $items;
}
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
<title>楽天商品検索API テスト</title>
<meta charset='utf-8'>
</head>
<body>
<table border='1'>
<tr>
<th>title</th>
<th>image</th>
<th>recipe url</th>
<th>description</th>
</tr>
<?php
$rakuten_relust = getRakutenResult();
foreach ($rakuten_relust as $item):
?>
<tr>
<td><?php echo $item['title']; ?></td>
<td><img src='<?php echo $item['img']; ?>' width=100 height=100></td>
<td><a href='<?php echo $item['url']; ?>'><?php echo $item['url']; ?></a></td>
<td><?php echo $item['description']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
