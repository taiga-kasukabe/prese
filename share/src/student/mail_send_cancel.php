<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include('../../conf/mail_pass.php');
include('../../../vendor/autoload.php');
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

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
    $to = $empInfo['empmail'];
    $to_name = $username;

    //件名
    $subject = date('m月d日', strtotime($rsvdate)) .  '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($rsvdate))))] . ") " . date('H:i', strtotime($rsvtime)) . '〜' . date('H:i', strtotime($rsvtime . " +1 hours")) . "の予約がキャンセルされました";

    //本文
    $body =
        "<h1>PRESE Web制作班です．</h1>
        <p>以下の日程の予約がキャンセルされました．</p>
        <p>日時：" . date('m月d日', strtotime($rsvdate)) .  '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($rsvdate))))] . ") " . date('H:i', strtotime($rsvtime)) . '〜' . date('H:i', strtotime($rsvtime . " +1 hours")) . "</p>
        <p>詳しくは<a href='https://ntteast.sakura.ne.jp/prese/share/src/employee/emplogin_form.php'>こちら</a>からご確認ください</p>";

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
