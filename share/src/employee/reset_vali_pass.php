<?php
session_start();
// $_SESSION = array();

//変数定義
//include("./conf/vari_reset.php");
//DB接続用
include("../../conf/config.php");

$empid = $_SESSION['empid'];
$old_password = $_POST['old_password'];
$password = ($_POST['password']);
$password_confirm = ($_POST['password_confirm']);
$err_msg = array();

//データベースへ接続、テーブルがない場合は作成
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

//データベースからログインIDが一致するユーザー情報を取得する
$sql = "SELECT * FROM emp_table WHERE empid = :empid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$employee = $stmt->fetch();

// 旧パスワードの一致を確認
if (!password_verify($old_password, $employee['emppassword'])) {
    $err_msg['old_pass_confirm'] = '・旧パスワードが一致しません';
}

//正規表現でパスワードをバリデーション
if (strlen($_POST['password']) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
    $err_msg['pass_length'] = '・パスワードは8文字以上の半角英数字を入力してください';
}

//パスワード再入力のチェック
if ($_POST['password'] != $_POST['password_confirm']){
    $err_msg['pass_confirm'] = '・パスワード（再入力）が一致しません';
}

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$password_confirm = password_hash($_POST['password_confirm'], PASSWORD_DEFAULT);

$_SESSION['err'] = array();
$_SESSION['err'] = $_SESSION['err'] + $err_msg;

$_SESSION['emp'] = array();
$_SESSION['emp']['password'] = $password;
$_SESSION['emp']['password_confirm'] = $password_confirm;
$_SESSION['emp']['empid'] = $empid;

//条件により確認or再登録
if(empty($_SESSION['err'])){
    // 登録
    header('Location: ./pass_register.php');
} else {
    // パスワード再登録やり直し
    header('Location: ./reset_pass_form.php');

}

?>
