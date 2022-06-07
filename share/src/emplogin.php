<?php

session_start();

$eid = $_POST['eid'];
include('../conf/config.php');

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
  $msg = 'idもしくはパスワードが間違っています。';
  $link = '<a href="./emplogin_form.php" class="err_msg">戻る</a>';
} else if (($_POST['epass'] = $member['epassword'])) {
  //save the user's data in DB on SESSION
  $_SESSION['eid'] = $member['eid'];
  $msg = 'ログインしました。';
  $link = '<a href="./registerFree_form.php?week=0">ホームへ</a>';
}
?>

<div class="err_msg"><?php echo $msg; ?></div>
<?php echo $link; ?>