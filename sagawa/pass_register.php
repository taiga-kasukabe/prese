<?php
session_start();

//変数定義

include("./conf/vari_session_pass.php");
include("./conf/config.php");


//データベースへ接続、テーブルがない場合は作成
try {
  //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //エラー処理
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }


$sql =  "UPDATE users_table SET password = :password, password_confirm = :password_confirm WHERE mail=:mail";
$stmt = $pdo -> prepare($sql);
//$stmt -> bindValue(':password', $password);
//$stmt -> bindValue(':password_confirm', $password_confirm);
$params = array(':password' => $password, ':password_confirm' => $password_confirm);
$stmt -> execute($params);

?>
<h1>再登録しました</h1>
<p>登録ID名：<?php echo $id;?></p>
<p>こちらのリンクからログインしてください</p>
<a href="./login_form.php">ログインページへ</a>