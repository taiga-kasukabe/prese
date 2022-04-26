<!--ホーム-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
</head>

<?php

session_start();
//データベース情報の読み込み
include('./conf/config.php');
//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
} catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
}

$id = $_SESSION['id'];

//users_table接続
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $pdo -> prepare($sql_user);
$stmt -> bindValue(':id', $id);
$stmt -> execute();
$member = $stmt -> fetch();
//empDB接続
$sql_emp = "SELECT * FROM empdb_";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
<h1>ホーム</h1>

<p>こんにちは、<?php echo $member['username']; ?> さん</p>

<a href="./mypage.php">マイページ</a>
<a href="./diagnose.php">簡易診断はこちら</a>

<?php  for ($num = 0; $num < count($employee); $num++) { ?>
    
    <h2><?php echo $employee[$num]['empname']; ?></h2>
    <img src="./images/<?php echo $employee[$num]['empimg_id']; ?>" width="300">
    <p>年次：<?php echo $employee[$num]['empyear']; ?>年目</p>
    <p>役職：<?php echo $employee[$num]['empjob']; ?></p>
    <p>職種：<?php echo $employee[$num]['empcareer']; ?></p><br><br>

<?php } ?>