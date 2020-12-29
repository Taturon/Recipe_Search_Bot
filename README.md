# レシピ検索ボットくん v3.0
![トップ画像](images/line_de_recipe.png)

[友達追加はコチラ](https://line.me/R/ti/p/@774hxoph)

## コンセプト
冷蔵庫の残り物の処理に困っていませんか？

そんな時の為のレシピ検索ボットくん！

食材名を入力するだけでレシピを簡単検索できます！

## ターゲット層
- 毎日のご飯レシピに悩む主婦・主夫層
- 料理に慣れていない若年層
- 新しいレシピを気軽に探したい層
- レシピを考える時間を節約したい方

## 機能

1. **レシピ検索**
	- 食材名から各種レシピを検索できます
	- DBに約1500種のレシピカテゴリーが登録されておりそれぞれ4つのレシピを表示できます
	- 該当カテゴリーが多い場合はクイックリプライで更に絞り込み検索できます

2. **気分 de レシピ**
	- 以下の4つのシチュエーションにマッチしたレシピを表示できます
		- スタミナが欲しい
		- 二日酔い
		- 元気が欲しい
		- 風邪気味

3. **お店検索**
	- 送信された位置情報から特定の半径以内のレストランを検索できる機能
	- 検索半径は下記の「半径設定」で変更可能
		- 設定できる半径は300 m, 500 m, 1 km, 3 kmの4つ

4. **単位換算**
	- 調味料のml/L/g/小さじ/大さじ/カップを違いに換算します
	- 現時点で約150種の調味料に対応
	- 「醤油」と「しょうゆ」などのある程度の表記ゆれにも対応
	- DBに保存されていない調味料が検索された場合にはログを取る処理を追加し拡張性を確保

5. **検索履歴**
	- 直近の検索履歴10件をクイックリプライで表示します
	- 1週間に1回のペースで古い履歴・不要な履歴を削除するバッチ処理も追加

6. **半径設定**
	- 「お店検索」の検索半径を設定できる機能

## デモ動画

|レシピ検索／検索履歴|気分 de レシピ|お店検索／半径設定|単位換算|
|---|---|---|---|
|<img alt="recipe_search_demo" src="videos/recipe_search_demo.gif">|<img alt="recipes_by_feelings_demo" src="videos/recipes_by_feelings_demo.gif">|<img alt="restaurant_search_demo" src="videos/restaurant_search_demo.gif">|<img alt="unit_conversion_demo" src="videos/unit_conversion_demo.gif">|

## 開発環境
- サーバー                  Linux(CentOS)  8.2.2004
- Webサーバーソフトウェア   Apache         2.4.37
- データベース              MySQL          8.0.21
- 言語                      PHP            7.4.12

## 使用ツール
- バージョン管理            Git
- ソースコード管理          GitHub
- デザイン関連              Canva

## 製作陣
- [SHU0527](https://github.com/SHU0527)
- [ChinenKatsuki](https://github.com/ChinenKatsuki)
- [ゆかり。](https://github.com/Kobayashi-Yukari)
- [Taturon](https://github.com/Taturon)
