<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require './mail_conf.php';

$mail = new PHPMailer(true);

try {
    //ホスト（さくらのレンタルサーバの初期ドメイン）
    $host = 'ntteast.sakura.ne.jp';
    //メールアカウントの情報（さくらのレンタルサーバで作成したメールアカウント）
    $user = 'ntteast_prese@ntteast.sakura.ne.jp';
    $password = $mail_pass;
    //差出人
    $from = 'ntteast_prese@ntteast.sakura.ne.jp';
    $from_name = 'NTT東日本採用担当';
    //宛先
    $to = 'taiga.kasukabe@gmail.com';
    $to_name = 'Taiga Kasukabe';
    //件名
    $subject = 'メールの件名';
    //本文
    $body = 'メールの本文';
    //諸々設定
    //$mail->SMTPDebug = 2; //デバッグ用
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $host;
    $mail->Username = $user;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";
    $mail->setFrom($from, $from_name);
    $mail->addAddress($to, $to_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //メール送信
    $mail->send();
} catch (Exception $e) {
    echo '失敗: ', $mail->ErrorInfo;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールテスト</title>
</head>
<body>
    <h1>メールが送信されました</h1>
</body>
</html>