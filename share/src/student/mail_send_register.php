<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include('../../conf/mail_pass.php');
include('../../../vendor/autoload.php');

$mail = new PHPMailer(true);

try {
    //ホスト（さくらのレンタルサーバの初期ドメイン）
    $host = $mail_host;

    //メールアカウントの情報（さくらのレンタルサーバで作成したメールアカウント）
    $user = $mail_address;
    $password = $mail_pass;

    //差出人
    $from = $mail_address;
    $from_name = 'NTT東日本採用担当';

    //宛先
    $to = $stuInfo['mail'];
    $to_name = $username;

    //件名
    $subject = '登録完了';

    //本文
    $body = '<h1>NTT東日本採用担当です．</h1><p>会員登録完了しました．</p>';

    //諸々設定
    //$mail->SMTPDebug = 2; //デバッグ用
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $host;
    $mail->Username = $user;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Port = 587;
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";
    $mail->isHTML(true);
    $mail->setFrom($from, $from_name);
    $mail->addAddress($to, $to_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //メール送信
    $mail->send();
} catch (Exception $e) {
    echo '失敗: ', $mail->ErrorInfo;
}
