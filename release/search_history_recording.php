<?php

require_once('db_connect.php');

$line_id = $event['source']['userId'];
$created_at = date('Y-m-d H:i:s');
$sql = 'INSERT INTO `histories` (`line_id`, `word`, `created_at`) VALUES (?, ?, ?)';
$stmt = $dbh->prepare($sql);
$stmt->execute([$line_id, $word, $created_at]);
