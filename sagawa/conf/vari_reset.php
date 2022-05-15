<?php
$repassword = password_hash($_POST['repassword'], PASSWORD_DEFAULT);
$repassword_confirm = password_hash($_POST['repassword_confirm'], PASSWORD_DEFAULT);
// エラーメッセージ
$err_msg = array();
?>