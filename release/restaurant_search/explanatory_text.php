<?php

// ユーザーの設定値を取得
require('../restaurant_search/radius_search.php');
$config = require_once('../../config/radius.php');
$radius = $config[$radius];

// 返信用メッセージの設定
$rep = '位置情報をお教え下されば';
$rep .= PHP_EOL . '設定された半径内でご紹介できる' . PHP_EOL . 'お店をお伝え致します！' . PHP_EOL;
$rep .= PHP_EOL . 'あなたの設定半径 : ' . $radius;
$reply['messages'][0] = ['type' => 'text', 'text' => $rep];
