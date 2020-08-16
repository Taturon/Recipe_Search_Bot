## 動作確認の方法
- 基本的に動作確認方法は前回と同じです。
- 詳しくはtestBotTaturon20200811のREADMEご確認願います。
1. まずcreateSeasoningsTable.sqlをphpMyAdmin上で実行し、換算用のDBを構築して下さい。
2. 次にdbConnect.phpとwebhook.phpの[]で囲われた部分に各人のデータを書き込んでください。
3. LINE Developersのダッシュボードへアクセスし、動作確認URLを設定する。
4. 「醤油小さじ1杯」や「みりん10ml」と入力すると換算された値が表示されます。
