<?php
session_start();

//変数定義

include("../conf/vari_session_pass.php");
include("../conf/config.php");



//データベースへ接続、テーブルがない場合は作成
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}




$sql =  "UPDATE users_table SET password = :password ,password_confirm = :password_confirm WHERE id=:id";
$stmt = $dbh -> prepare($sql);
$stmt -> bindValue(':password', $password);
$stmt -> bindValue(':password_confirm', $password_confirm);
$stmt -> bindValue(':id', $id);
//$params = array(':password' => $password, ':password_confirm' => $password_confirm);
$stmt -> execute();

?>
<h1>再登録しました</h1>
<p>こちらのリンクからログインしてください</p>
<a href="./login_form.php">ログインページへ</a>