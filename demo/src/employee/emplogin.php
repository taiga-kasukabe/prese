<?php

session_start();

$eid = $_POST['eid'];
include('../../conf/config.php');

//データベース接続
try {
  $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
  $msg = $e->getMessage();
}

$sql = "SELECT * FROM emplogin WHERE eid = :eid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':eid', $eid);
$stmt->execute();
$member = $stmt->fetch();

if (!isset($member['eid']) || $_POST['epass'] != $member['epassword']) {
  $_SESSION['err_msg'] = 'IDもしくはパスワードが間違っています。';
  header('Location:./emplogin_form.php');
} else if (($_POST['epass'] = $member['epassword'])) {
  //save the user's data in DB on SESSION
  $_SESSION['eid'] = $member['eid'];
  header('Location:./empmypage.php');
}
?>