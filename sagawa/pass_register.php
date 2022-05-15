<?php
session_start();

//変数定義
include("./conf/vari_session_pass.php");
include("./conf/config.php");

$id = $_SESSION['id'];

//データベースへ接続、テーブルがない場合は作成
try {
  //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //エラー処理
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

//users_table接続
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $pdo -> prepare($sql_user);
$stmt -> bindValue(':id', $id);
$stmt -> execute();
$member = $stmt -> fetch();


$sql =   "UPDATE users_table SET password = :password WHERE id=:id";
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue(':repassword', $repassword);
$stmt -> bindValue(':repassword_confirm', $repassword_confirm);
$stmt -> execute();

?>
<h1>再登録しました</h1>
<p>登録ID名：<?php echo $id;?></p>
<p>こちらのリンクからログインしてください</p>
<a href="./login_form.php">ログインページへ</a>