動作確認の手順
1.dbConnect.phpのDB名、ユーザー名、パスワードをデータを挿入したいDBのものに置き換える
2.createRakutenRecipeTable.sqlを用いてDBに「rakuten_recipe」のテーブルを作成する
3.LINE Developersのダッシュボードへアクセスし、
トップ>[プロバイダー名]>[アプリ名]>Messaging API設定>Webhook URL
をプロサーサーバーの動作確認URLに設定する
4.動作確認用URLでcategoryInsert.phpにアクセスするかCUIのphpコマンドで実行しデータを挿入する
5.エラーが出なければ挿入成功（ボットの動作確認ができるはずです）
