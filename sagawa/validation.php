<?php
session_start();
$_SESSION = array();
//DB接続用
require_once('config.php');

//変数定義
include("./conf/variable.php");

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }

// username_kanaがカナのみか
if(!preg_match("/^[ァ-ヾ]+$/u", $username_kana)){
    $err_msg['username_kana'] = '姓名(カナ)にはカタカナを入力してください';
}

//メールアドレスのバリデーション
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
    $err_msg['mail_expression'] = '正しいメールアドレスを入力してください';
}

//メールアドレスの重複チェック
//データベース内のメールアドレスを取得
$sql = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $dbh -> prepare($sql_mail);
$stmt -> bindValue(':mail', $mail);
$stmt -> execute();
$member = $stmt -> fetch();

if (!empty($member)) {
    $err_msg['mail_duplicate'] = 'このメールアドレスは既に登録されています';
}

//メアド再入力チェック
if ($mail != $mail_confirm) {
    $err_msg['mail_confirm'] = 'メールアドレス(再入力)が一致しません';
}

// telバリデーション
if (!preg_match($tel_pattern, $tel)) {
    $err_msg['tel_confirm'] = '正しい電話番号を入力してください';
}

//telの重複チェック
$sql = "SELECT * FROM users_table WHERE tel = :tel";
$stmt = $dbh -> prepare($sql_tel);
$stmt -> bindValue(':mail', $tel);
$stmt -> execute();
$member = $stmt -> fetch();

if (!empty($member)) {
    $err_msg['tel_duplicate'] = 'この電話番号は既に登録されています';
}

//正規表現でパスワードをバリデーション
if (strlen($_POST['password']) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
    $err_msg['pass_length'] = 'パスワードは8文字以上の半角英数字を入力してください';
}

//パスワード再入力のチェック
if ($_POST['password'] != $_POST['password_confirm']){
    $err_msg['pass_confirm'] = 'パスワード(確認)が一致しません';
}



?>