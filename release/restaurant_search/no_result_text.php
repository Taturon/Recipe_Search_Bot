<?php
$rep = 'すみません!' . PHP_EOL . 'お近くにご紹介できる' . PHP_EOL . 'お店がございません...' . PHP_EOL;
$rep .= PHP_EOL . '別の位置情報をお教え頂くか';
$rep .= PHP_EOL . 'メニュー > 半径設定' . PHP_EOL . 'で検索半径を広げてみて下さい!';
$reply['messages'][0] = ['type' => 'text', 'text' => $rep];
