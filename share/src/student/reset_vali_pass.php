<?php
session_start();
$_SESSION = array();

//変数定義
//include("./conf/vari_reset.php");
//DB接続用
include("../../conf/config.php");

$password = ($_POST['password']);
$password_confirm = ($_POST['password_confirm']);
$err_msg = array();

//データベースへ接続、テーブルがない場合は作成
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}


//正規表現でパスワードをバリデーション
if (strlen($_POST['password']) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
    $err_msg['pass_length'] = 'パスワードは8文字以上の半角英数字を入力してください';
}

//パスワード再入力のチェック
if ($_POST['password'] != $_POST['password_confirm']){
    $err_msg['pass_confirm'] = 'パスワード(確認)が一致しません';
}

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$password_confirm = password_hash($_POST['password_confirm'], PASSWORD_DEFAULT);

$_SESSION['err'] = array();
$_SESSION['err'] = $_SESSION['err'] + $err_msg;

$_SESSION['user'] = array();
$_SESSION['user']['password'] = $password;
$_SESSION['user']['password_confirm'] = $password_confirm;
$_SESSION['user']['id'] = $_POST["id"];

//条件により確認or再登録
if(empty($_SESSION['err'])){
    // 登録
    header('Location: ./pass_register.php');
} else {
    // パスワード再登録やり直し
    $msg = "再入力と一致していません";
    $link = '<a href="./reset_pass_form.php">戻る</a>';
}

?>
<?php echo $msg; ?>
<?php echo $link; ?>
