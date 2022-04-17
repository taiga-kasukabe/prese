<?php
session_start();
$_SESSION = array();
//DB接続用
include("./conf/config.php");

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
$sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $pdo -> prepare($sql_mail);
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
$sql_tel = "SELECT * FROM users_table WHERE tel = :tel";
$stmt = $pdo -> prepare($sql_tel);
$stmt -> bindValue(':tel', $tel);
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

//session情報の保存
//errの持ち越し
$_SESSION['err'] = array();
$_SESSION['err'] = $_SESSION['err'] + $err_msg;

$_SESSION['user'] = array();
$_SESSION['user']['username'] = $username;
$_SESSION['user']['username_kana'] = $username_kana;
$_SESSION['user']['mail'] = $mail;
$_SESSION['user']['mail_confirm'] = $mail_confirm;
$_SESSION['user']['tel'] = $tel;
$_SESSION['user']['school'] = $school;
$_SESSION['user']['department1'] = $department1;
$_SESSION['user']['department2'] = $department2;
$_SESSION['user']['student_year'] = $student_year;
$_SESSION['user']['id'] = $id;
$_SESSION['user']['password'] = $password;
$_SESSION['user']['password_confirm'] = $password_confirm;
$_SESSION['user']['password_row'] = $_POST['password'];
$_SESSION['user']['password_confirm_row'] = $_POST["password_confirm"];

//条件により確認or再登録
if(empty($_SESSION['err'])){
    // 確認ページへ
    header('Location: ./register_conf.php');
} else {
    // 新規登録やり直し
    header('Location: ./register_form.php');
}

?>