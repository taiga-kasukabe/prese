<?php

//言語設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//メール情報
$to = "$mail";
$subject = "【NTT東日本】ユーザー登録が完了しました．";
$message = "ユーザー登録が完了しました．";
$headers = "From:yu.sato.fortest@gmail.com";

mb_send_mail($to, $subject, $message, $headers);

?>
