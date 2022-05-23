<?php
//yahooでのtest

//Composerを利用していない
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//設置した場所のパスを指定する
require('C:\xampp\htdocs\PHPMailer\src\PHPMailer.php');
require('C:\xampp\htdocs\PHPMailer\src\Exception.php');
require('C:\xampp\htdocs\PHPMailer\src\SMTP.php');

//メールを送信するアカウント情報の読み込み
include("./conf/mail_pass.php");

//文字エンコードを指定
mb_language('japanese');
mb_internal_encoding('UTF-8');

//インスタンスを生成（true指定で例外を有効化）
$sendmail = new PHPMailer(true);

//文字エンコードを指定
$sendmail->CharSet = "iso-2022-jp";
$sendmail->Encoding = "7bit";

try {
   
    // SMTPサーバの設定
    $sendmail->isSMTP();                          // SMTPの使用宣言
    $sendmail->Host       = 'smtp.gmail.com';   // SMTPサーバーを指定
    $sendmail->SMTPAuth   = true;                 // SMTP authenticationを有効化
    $sendmail->Username   = $user_name;   // SMTPサーバーのユーザ名
    $sendmail->Password   = $user_pass;           // SMTPサーバーのパスワード
    $sendmail->SMTPSecure = 'tls';  // 暗号化を有効（tls or ssl）無効の場合はfalse
    $sendmail->Port       = 587; // TCPポートを指定（tlsの場合は465や587）
     //送受信先の設定
    $sendmail->setFrom($user_name);
    $sendmail->addAddress($mail);

    $sendmail->Subject = mb_encode_mimeheader('【NTT東日本】登録完了');
    $sendmail->Body = mb_convert_encoding('登録が完了しました．', "JIS", "UTF-8");

    $sendmail->send();

} catch (Exception $e) {
    echo "Error:{$sendmail->ErrorInfo}";
}
?>