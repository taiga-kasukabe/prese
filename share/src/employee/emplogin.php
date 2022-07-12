<?php

session_start();

$eid = $_POST['empid'];
include('../../conf/config.php');

//データベース接続
try {
  $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
  $msg = $e->getMessage();
}

$sql = "SELECT * FROM emp_table WHERE empid = :empid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $eid);
$stmt->execute();
$member = $stmt->fetch();

if (!isset($member['empid']) || $_POST['emppassword'] != $member['emppassword']) {
  $_SESSION['err_msg'] = 'IDもしくはパスワードが間違っています。';
  header('Location:./emplogin_form.php');
} else if (($_POST['emppassword'] = $member['emppassword'])) {
  //save the user's data in DB on SESSION
  $_SESSION['empid'] = $member['empid'];
  header('Location:./empmypage.php');
}
?>