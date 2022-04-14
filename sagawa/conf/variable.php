<?php
// 会員登録情報
$username = $_POST['username'];
$username_kana = $_POST['username_kana'];
$mail = $_POST['mail'];
$mail_confirm = $_POST['mail_confirm'];
$tel = $_POST['tel'];
$school = $_POST['school'];
$department1 = $_POST['department1'];
$department2 = $_POST['department2'];
$student_year = $_POST['student_year'];
$id = $_POST['id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$password_confirm = password_hash($_POST['password_confirm'], PASSWORD_DEFAULT);

// 正規表現
$tel_pattern = '/^0[0-9]{9,10}\z/'; //

// エラーメッセージ
$err_msg = array();
?>