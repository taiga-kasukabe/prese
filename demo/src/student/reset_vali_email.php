<!--パスワードリセット、メアド確認-->
<?php
session_start();
$_SESSION = array();
//DB接続用
include("../../conf/config.php");
$mail = $_POST['mail'];
//$id = $_POST['id'];

//データベース接続
try {
  $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
  $msg = $e->getMessage();
}


//メールアドレスの存在チェック
//データベース内のメールアドレスを取得
$sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $dbh->prepare($sql_mail);
$stmt->bindValue(':mail', $_POST['mail']);
$stmt->execute();
$mail_mem = $stmt->fetch();

if (!empty($mail_mem)) {
  $_SESSION['id'] = $mail_mem['id'];
  header('Location: ./reset_email.php');
} else {
  $_SESSION['err'] = array();
  $_SESSION['err'] = 'メールアドレスが登録されていません';
  header('Location: ./reset_email_form.php');
}

?>