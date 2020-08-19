## DB再構築方法
1. dbConnect.phpのDB名、UN、PWを適切な値に切り替える。
2. このディレクトリ（loopSearchAvoidanceTaturon20200819）上で次のコマンドを実行する。
 - php tableRestructuring.php
 - エラー時の対応
  - 「DB接続に失敗しました」
   - dbConnect.phpのDB名などに誤りがないか確認して下さい
  - 「データ保存に失敗しました」
   - データインサート中になんらかの不具合が発生した可能性があります。
   - 再度「php tableRestructuring.php」を実行して下さい。
## 各ファイルの詳細
- tableRestructuring.php
 - レシピID検索テーブルを再構築するファイルです。
- recipesInsert.php
 - 修正したレシピデータを挿入するSQL文が書かれたファイルです。
- loopCheck.php
 - ループ検索となってしまうデータ一覧を出力するファイルです。
 - DB再構築前にCUIで実行すると値が500を超える配列データが出力されるので注意して下さい。
 - DB再構築後に実行（php loopCheck.php）し「ループを起こすレシピ名はありませんでした！」と表示されればDB再構築は問題なく行えています。
## その他
- スプレッドシートのDBへ反映させる場合は、DB再構築後に全データを取得後に繰り返し処理などでスプレッドシートDBを構築されるとよろしいかと思われます。
