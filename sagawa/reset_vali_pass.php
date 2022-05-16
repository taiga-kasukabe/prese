<?php
session_start();
$_SESSION = array();

//変数定義
include("./conf/vari_reset.php");

//正規表現でパスワードをバリデーション
if (strlen($_POST['password']) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
    $err_msg['pass_length'] = 'パスワードは8文字以上の半角英数字を入力してください';
}

//パスワード再入力のチェック
if ($_POST['password'] != $_POST['password_confirm']){
    $err_msg['pass_confirm'] = 'パスワード(確認)が一致しません';
}

$_SESSION['err'] = array();
$_SESSION['err'] = $_SESSION['err'] + $err_msg;

$_SESSION['user']['password'] = $password;
$_SESSION['user']['password_confirm'] = $password_confirm;
$_SESSION['user']['password_row'] = $_POST['password'];
$_SESSION['user']['password_confirm_row'] = $_POST["password_confirm"];

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
