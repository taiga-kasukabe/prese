<!--パスワードリセット、メアド確認-->
<?php
session_start();
$_SESSION = array();
//DB接続用
include("./conf/config.php");
$mail = $_POST['mail'];
//$id = $_POST['id'];

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    

//$sql = "SELECT * FROM users_table WHERE id = :id";
//$stmt = $pdo->prepare($sql);
//$stmt->bindValue(':id', $id);
//$stmt->execute();
//$member = $stmt->fetch();
//メールアドレスの重複チェック
//データベース内のメールアドレスを取得
$sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $pdo -> prepare($sql_mail);
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