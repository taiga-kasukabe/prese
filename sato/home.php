<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>ホーム</title>
</head>

<?php

session_start();

if(!$_SESSION['user']['id']){
    echo 'ログインが必要です';
    exit;
}

//データベース情報の読み込み
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

//ユーザー情報の取得
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_user);
$stmt->bindValue(':id', $id);
$member = $stmt->fetch();

//社員情報の取得
$sql_emp = "SELECT * FROM emb_table";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<body>
<h1>ホーム</h1>

<p>こんにちは、<?php echo $member['username']; ?> さん</p>

<a href="./mypage.php">マイページ</a>
<a href="./diagnose.php">簡易診断はこちら</a>

<h2><?php echo $employee[0]['empname']; ?></h2>
<p>年次：<?php echo $employee[0]['empyear']; ?></p>
<p>役職：<?php echo $employee[0]['empjob']; ?></p>
<p>年次：<?php echo $employee[0]['empcareer']; ?></p>