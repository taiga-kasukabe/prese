<!--パスワードリセット、メアド確認-->
<?php
session_start();
$_SESSION = array();
//DB接続用
include("./conf/config.php");
$mail = $_POST['mail'];

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
    
//メールアドレスの重複チェック
//データベース内のメールアドレスを取得
$sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $pdo -> prepare($sql_mail);
$stmt -> bindValue(':mail', $mail);
$stmt -> execute();
$member = $stmt -> fetch();

if (!empty($member)) {
  header('Location: ./reset_pass_form.php');
}
else {
  $msg = 'メールアドレスが登録されていません';
}

?>
<?php echo $msg; ?>