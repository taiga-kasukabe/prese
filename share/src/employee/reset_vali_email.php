<!--パスワードリセット、メアド確認-->
<?php
session_start();
$_SESSION = array();
//DB接続用
include("../../conf/config.php");
$mail = $_POST['mail'];

//データベース接続
try {
  $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
  $msg = $e->getMessage();
}


//メールアドレスの存在チェック
//データベース内のメールアドレスを取得
$sql_mail = "SELECT * FROM emp_table WHERE empmail = :empmail";
$stmt = $dbh->prepare($sql_mail);
$stmt->bindValue(':empmail', $_POST['mail']);
$stmt->execute();
$mail_emp = $stmt->fetch();

if (!empty($mail_mem)) {
  $_SESSION['empid'] = $mail_emp['empid'];
  header('Location: ./reset_email.php');
} else {
  $_SESSION['err'] = array();
  $_SESSION['err'] = 'メールアドレスが登録されていません';
  header('Location: ./reset_email_form.php');
}

?>