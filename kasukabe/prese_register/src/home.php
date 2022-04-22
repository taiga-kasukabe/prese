<?php
session_start();

// 変数定義
include('../conf/db_conf.php');

try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
$id = $_SESSION['id'];

$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

// session_destroy();
?>
<p>こんにちは，<?php echo $member['username'];?>さん</p>
<a href="./mypage.php">マイページへ</a><br>
<a href="./diagnose_form.php">簡易診断へ</a>