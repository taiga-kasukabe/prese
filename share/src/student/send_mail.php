<?php

//PHPMailerの実装 ※Composer利用なし
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('../../PHPMailer/src/PHPMailer.php');
require('../../PHPMailer/src/Exception.php');
require('../../PHPMailer/src/SMTP.php');

//メールを送信するアカウント情報の読み込み
include("../../conf/mail_pass.php");


mb_language("japanese");
mb_internal_encoding("UTF-8");

//インスタンス生成
$sendmail = new PHPMailer(true);

//文字エンコードを指定
$sendmail->CharSet = "iso-2022-jp";
$sendmail->Encoding = "7bit";

try{

    //SMTPサーバの設定
    $sendmail->isSMTP();
    $sendmail->Host = 'smtp.gmail.com';
    $sendmail->SMTPAuth = true;
    $sendmail->Username = $user_name;
    $sendmail->Password = $user_pass;
    $sendmail->SMTPSecure = 'tls';
    $sendmail->Port = 587;

    //送受信先の設定
    $sendmail->setFrom($user_name);
    $sendmail->addAddress($mail);

    //送信内容の設定
    $sendmail->Subject = mb_encode_mimeheader('【NTT東日本】登録完了');
    $sendmail->Body = mb_convert_encoding('登録が完了しました．', "JIS", "UTF-8");

    $sendmail->send();

} catch (Exception $e) {
    echo "Error:{$sendmail->ErrorInfo}";
}

//参考
//https://miya-system-works.com/blog/detail/107
//https://qiita.com/e__ri/items/857b12e73080019e00b5

?>
