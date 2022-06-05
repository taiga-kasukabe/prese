<!--パスワードリセット、メアド確認-->
<?php
session_start();
$_SESSION = array();
//DB接続用
include("../conf/config.php");
$mail = $_POST['mail'];
//$id = $_POST['id'];

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}
    

//メールアドレスの重複チェック
//データベース内のメールアドレスを取得
$sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $dbh -> prepare($sql_mail);
$stmt -> bindValue(':mail', $_POST['mail']);
$stmt -> execute();
$mail_mem = $stmt -> fetch();

//if (!empty($member AND $mail_mem)){
  if (!empty($mail_mem)){
  //$_SESSION['id'] = $member['id'];
  //$_SESSION['user']['mail'] = $_POST["mail"];
  header('Location: ./reset_pass_form.php');
  //$link = '<a href="./reset_pass_form.php">こちらから</a>';
  //$msg = 'パスワード再登録画面へ';
}
else {
  $msg = 'IDもしくはメールアドレスが登録されていません';
}

?>
//<?php echo $link; ?>
<?php echo $msg; ?>