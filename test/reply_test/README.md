# ディレクトリの説明
## 概要
- 以下の返信機能を試せるテスト用ディレクトリです。
	1. テキスト
	2. 画像
	3. 位置情報
	4. イメージマップ
	5. 画像カルーセル
- 確認手順
	1. LINE Developersのダッシュボードへアクセスし、動作確認URLを再設定
	2. webhook.phpの\[FILTERED\]を適切な値に置き換える
	3. replyTest.phpの確認したい返信機能の部分のコメントアウトを外す

## 各ファイルの説明
- line_bot_tiny.php
	- Line Bot開発用SDK
- webhook.php
	- POSTリクエストを送るファイル
- carousel_test.php
	- 定型文のカルーセル2つを生成するファイル 

---

## 参考記事
- [LINE Developers ドキュメント Messaging API メッセージタイプ](https://developers.line.biz/ja/docs/messaging-api/message-types/)
- [LINE Messaging API でできることまとめ【送信編】](https://qiita.com/kakakaori830/items/52e52d969800de61ce28#%E3%82%AB%E3%83%AB%E3%83%BC%E3%82%BB%E3%83%AB%E3%83%86%E3%83%B3%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88)
