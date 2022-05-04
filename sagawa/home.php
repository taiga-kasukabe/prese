<link rel="stylesheet" href="./css/mouseover.css">
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

//users_table接続
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $pdo -> prepare($sql_user);
$stmt -> bindValue(':id', $id);
$stmt -> execute();
$member = $stmt -> fetch();

//empDB接続
$sql_emp = "SELECT * FROM emp_table";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
<h1>ホーム</h1>

<p>こんにちは、<?php echo $member['username']; ?> さん</p>

<a href="./mypage.php">マイページ</a>
<a href="./diagnose.php">簡易診断はこちら</a>

<h2>社員リスト</h2>

<div>
    <?php for ($n = 0; $n < count($employee); $n++) { ?>
        <div class="mouseoverParent">
            <p><?php echo $employee[$n]['empname']; ?></p>
            <img src="./images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
            <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
            <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
            <p>職種：<?php echo $employee[$n]['empcareer']; ?></p><br><br>
            <div class="mouseoverChild">
                <?php echo $employee[$n]['empname']; ?>
                <img src="./images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
                <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
                <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
                <p>職種：<?php echo $employee[$n]['empcareer']; ?></p>
                <p>趣味：<?php echo $employee[$n]['emphobby']; ?></p>
            </div>
        </div>
        <br><br>
    <?php } ?>
</div>
<h2>社員リストはここまで</h2>