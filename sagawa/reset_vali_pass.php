<?php
session_start();

//変数定義
include("./conf/config.php");
//変数定義
include("./conf/vari_reset.php");

//データベースへ接続、テーブルがない場合は作成
try {
  //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //エラー処理
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

//正規表現でパスワードをバリデーション
if (strlen($_POST['repassword']) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['repassword'])) {
    $err_msg['pass_length'] = 'パスワードは8文字以上の半角英数字を入力してください';
}

//パスワード再入力のチェック
if ($_POST['repassword'] != $_POST['repassword_confirm']){
    $err_msg['pass_confirm'] = 'パスワード(確認)が一致しません';
}

$_SESSION['err'] = array();
$_SESSION['err'] = $_SESSION['err'] + $err_msg;

$_SESSION['user']['repassword'] = $repassword;
$_SESSION['user']['repassword_confirm'] = $repassword_confirm;
$_SESSION['user']['repassword_row'] = $_POST['repassword'];
$_SESSION['user']['repassword_confirm_row'] = $_POST["repassword_confirm"];

//条件により確認or再登録
if(empty($_SESSION['err'])){
    // 登録
    header('Location: ./pass_register.php');
} else {
    // パスワード再登録やり直し
    header('Location: ./reset_pass_form.php');
}

?>
