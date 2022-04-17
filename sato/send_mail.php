<?php

//セッション開始
session_start();

//セッション情報の引き継ぎ，変数定義
include("./conf/variable_session.php");

//言語設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//メール情報
$to = "$mail";
$subject = "【NTT東日本】ユーザー登録が完了しました．";
$message = "ユーザー登録が完了しました．";
$headers = "loud24111@gmail.com";

mb_send_mail($to, $subject, $message, $headers);

?>
