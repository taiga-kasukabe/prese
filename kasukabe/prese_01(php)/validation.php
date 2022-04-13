<?php

//use session
session_start();

//initialize variable
$email = '';
$password = '';
$err_msg = array();

// judge POST
if (!empty($_POST)) {
    // 各データを変数に格納
    $email = $_POST['email'];
    $password = $_POST['password'];

    // checking email validation
    // 空白チェック
    if ($email === '') {
        $err_msg['email'] = '入力必須です';
    }
    // 文字数チェック
    if (strlen($email) > 255) {
        $err_msg['email'] = '255文字で入力してください';
    }
    // パスワードバリデーションチェック
    // 空白チェック
    if ($password === '') {
        $err_msg['password'] = '入力してください';
    }
    // 文字数チェック
    if (strlen($password) > 255 || strlen($password) < 5) {
        $err_msg['password'] = '６文字以上２５５文字以内で入力してください';
    }
    // 形式チェック
    if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
        $err_msg['password'] = '半角英数字で入力してください';
    }
}
?>