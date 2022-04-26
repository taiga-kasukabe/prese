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

$id = $_SESSION['id'];

//ユーザー情報の取得
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_user);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

//社員情報の取得
$sql_emp = "SELECT * FROM emp_table";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
<h1>ホーム</h1>

<p>こんにちは、<?php echo $member['username']; ?> さん</p>

<a href="./mypage.php">マイページ</a><br>
<a href="./diagnose.php">簡易診断はこちら</a><br><br>

<?php for ($num = 0; $num < count($employee); $num++) { ?>
    <h2><?php echo $employee[$num]['empname']; ?></h2>
    <img src="./images/<?php echo $employee[$num]['empimg_id'] ?>" width="300">
    <p>年次：<?php echo $employee[$num]['empyear']; ?></p>
    <p>役職：<?php echo $employee[$num]['empjob']; ?></p>
    <p>職歴：<?php echo $employee[$num]['empcareer']; ?></p><br><br><br>
<?php } ?>