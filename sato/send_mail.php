<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('/xampp/htdocs/PHPMailer/src/PHPMailer.php');
require('/xampp/htdocs/PHPMailer/src/Exception.php');
require('/xampp/htdocs/PHPMailer/src/SMTP.php');

mb_language("japanese");
mb_internal_encoding("UTF-8");

$sendmail = new PHPMailer(true);

$sendmail->CharSet = "iso-2022-jp";
$sendmail->Encoding = "7bit";

try{

$sendmail->isSMTP();
$sendmail->Host = 'smtp.gmail.com';
$sendmail->SMTPAuth = true;
$sendmail->Username = 'yu.sato.fortest@gmail.com';
$sendmail->Password = 'prese_ysato';
$sendmail->SMTPSecure = 'tls';
$sendmail->Port = 587;

$sendmail->setFrom('yu.sato.fortest@gmail.com');
$sendmail->addAddress('yu.sato.r6@dc.tohoku.ac.jp');

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
