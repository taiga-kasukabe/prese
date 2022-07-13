<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール送信</title>
</head>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';
require '../../conf/mail_pass.php';

$mail = new PHPMailer(true);

try {
    //ホスト（さくらのレンタルサーバの初期ドメイン）
    // $host = $mail_address;
    $host = 'ntteast.sakura.ne.jp';

    //メールアカウントの情報（さくらのレンタルサーバで作成したメールアカウント）
    // $user = $mail_address;
    // $password = $mail_pass;
    $user = 'ntteast_prese@ntteast.sakura.ne.jp';
    $password = 'Webeast2022';

    //差出人
    // $from = $mail_address;
    $from = 'ntteast_prese@ntteast.sakura.ne.jp';
    $from_name = 'NTT東日本採用担当';

    //宛先
    // $to = $mail;
    // $to_name = $username;
    $to = 'taiga.kasukabe@gmail.com';
    $to_name = 'Taiga Kasukabe';

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
    $mail->setFrom($from, $from_name);
    $mail->addAddress($to, $to_name);
    $mail->Subject = $subject;
    // $mail->Body = $body;
    $mail->Body = mb_convert_encoding($body, "JIS", "UTF-8");
    //メール送信
    $mail->send();
} catch (Exception $e) {
    echo '失敗: ', $mail->ErrorInfo;
}
?>

<body>
    <h1>送信完了</h1>
</body>

</html>