<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>登録取り消し</title>
</head>
<?php
session_start();
include("../conf/config.php");
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

$empid = $_POST['empid'];
$rsvdate = $_POST['rsvdate'];
$rsvtime = $_POST['rsvtime'];

if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql =  "UPDATE rsvdb SET stuid = '' ,comment = '' , flag = 0 WHERE stuid = :stuid AND empid = :empid AND rsvdate = :rsvdate AND rsvtime = :rsvtime";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':stuid', $id);
    $stmt->bindValue(':empid', $empid);
    $stmt->bindValue(':rsvdate', $rsvdate);
    $stmt->bindValue(':rsvtime', $rsvtime);
    $stmt->execute();
}
?>

<?php if (!empty($_SESSION['id'])) { ?>
    <h1>予約キャンセルしました</h1>
    <a href="./mypage.php">マイページへ</a>
<?php } else { ?>
    <h1>セッションが切れました</h1>
    <h2>再ログインしてください</h2>
    <a href="./login_form.php">ログインページへ</a>
<?php } ?>