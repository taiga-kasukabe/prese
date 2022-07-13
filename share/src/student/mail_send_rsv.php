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
    $subject = date('m月d日', strtotime($unrsvInfo['rsvdate'])) .  '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($unrsvInfo['rsvdate']))))] . ") " . date('H:i', strtotime($unrsvInfo['rsvtime'])) . '〜' . date('H:i', strtotime($unrsvInfo['rsvtime'] . " +1 hours")) . "に面談予約が入りました";

    //本文
    $body =
        "<h1>PRESE Web制作班です．</h1>
        <p>学生から面談予約が入りました．明日までに学生にメールを送ってください！</p>
        <p>日時：" . date('m月d日', strtotime($unrsvInfo['rsvdate'])) .  '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($unrsvInfo['rsvdate']))))] . ") " . date('H:i', strtotime($unrsvInfo['rsvtime'])) . '〜' . date('H:i', strtotime($unrsvInfo['rsvtime'] . " +1 hours")) . "</p>
        <h2>予約してくださった学生情報</h2>
        <p>名前：" . $stuInfo['username'] . "<br>
        メールアドレス：" . $stuInfo['mail'] . "</p>
        <p>↓↓メール文面のテンプレはこちら↓↓<br>
        ＝＝＝＝<br>" .
        $stuInfo['username'] . "さん<br>
        面談のご予約ありがとうございます．<br>
        NTT東日本SE内々定の" . $empInfo['empname'] . "です．<br>
        当日は[zoom, teams, google meets, etc.]で面談したいと思います！<br>
        リンクはこちら：<br>
        以上，よろしくお願いします！<br>
        ＝＝＝＝</p>
        <p>詳しくは<a href='https://ntteast.sakura.ne.jp/prese/share/src/employee/emplogin_form.php'>こちら</a>から確認してください</p>";

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
