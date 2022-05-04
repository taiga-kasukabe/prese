<!--簡易診断-->
<link rel="stylesheet" href="./css/mouseover.css">
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>簡易診断</title>
</head>

<?php

session_start();
//データベース情報の読み込み
include('./conf/config.php');
$employee = array();
$temp = 0;

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
} catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
}

$id = $_SESSION['id'];

//empDB接続
$sql_emp = "SELECT * FROM emp_table";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>社員検索<h1>
    <div id="gender">性別：
        <input type="radio" name="gen" value="男性" required>男性
        <input type="radio" name="gen" value="女性" required>女性
    </div>

    <div id="jobs">職種：
        <input type="checkbox" name="job" value="SE" required>SE
        <input type="checkbox" name="job" value="NWP" required>NWP
        <input type="checkbox" name="job" value="サービス開発" required>サービス開発
    </div>

<p>
<input type="submit" value="検索">
</p>