# ディレクトリの説明
## 概要
各テーブルを作成しレコードを挿入するプログラムや不具合を起こすレコードを抽出するプログラムが記述されたファイルを格納したディレクトリです。

### checkerディレクトリ
- レシピ検索時のループ検索やカルーセルテンプレートのタイトルの上限文字数超過を引き起こすレコードを抽出するファイルが格納されたディレクトリです。

#### 各ファイルの詳細
- loop_checker.php
	- クイックリプライ選択時に同じ選択肢が表示されるループ検索を起こす検索対象文字列を検知するプログラムです。
- exceed_checker.php
	- カルーセルテンプレートのタイトルの上限20文字を超過しているレシピを抽出するプログラムです。

#### 確認方法
1. build/db_connect.phpのPDO_DSN,USERNAME,PASSWORDを.env.phpで定義する。
2. このディレクトリ(recipe_search_bot/build/checker)上で次のコマンドを実行する。
	- php exceed_checker.php
		- レシピ名が表示された場合はDBを操作し対象のcategory_nameを20文字以内に修正してください。
		- 「20文字を超えるレシピ名はありませんでした」と表示されれば問題なし。
	- loop_checker.php
		- レシピ名が表示された場合はDBを操作し対象のcategory_nameを曖昧検索した結果が1件になる様に修正してください。
		- 「ループを起こすレシピ名はありませんでした」と表示されれば問題なし。

### 各種create_tableディレクトリ
recipesテーブル・feelingsテーブル・seasoningsテーブルを作成するファイルが格納されたディレクトリです。

#### 各ファイルの詳細
- table_create.php
	- 各種テーブルを作成するプログラムです。
- insert.php
	- 各種テーブル作成時にレコードを挿入するSQL文を組み立てるプログラムです。

#### 作成方法
1. build/db_connect.phpのPDO_DSN,USERNAME,PASSWORDを.env.phpで定義する。
2. 各種ディレクトリ(recipe_search_bot/build/[テーブル名]\_table_create)上で次のコマンドを実行する。
	- php table_create.php
		- 「テーブル作成に失敗しました」と表示された場合は.env.phpの定数定義などを見直してください。
		- 「テーブル作成に成功しました」と表示されれば問題なし。
