<!-- mail送信 -->
<!-- ./conf/mail_conf.phpを読み込む必要あり -->

<?php
// PHPMailer のクラスをグローバル名前空間（global namespace）にインポート
// スクリプトの先頭で宣言する必要があります
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Composer のオートローダーの読み込み（ファイルの位置によりパスを適宜変更）
require '/Applications/MAMP/htdocs/php_mailer/vendor/autoload.php';

// ユーザ情報読み込み
$user_mail = 'taiga.kasukabe@gmail.com';
$user_pass = 'mffjkyfejmlkdcdx';

// メール情報読み込み
$subject = date('m月d日', strtotime($unrsvInfo['rsvdate'])) .  '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($unrsvInfo['rsvdate']))))] . ") " . date('H:i', strtotime($unrsvInfo['rsvtime'])) . '〜' . date('H:i', strtotime($unrsvInfo['rsvtime'] . " +1 hours")) . "に面談予約が入りました";
$message_html =
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
NTT東日本SE内々定の".$empInfo['empname'] . "です．<br>
当日は[zoom, teams, google meets, etc.]で面談したいと思います！<br>
リンクはこちら：<br>
以上，よろしくお願いします！<br>
＝＝＝＝</p>
<p>詳しくは<a href='localhost/share/src/employee/emplogin_form.php'>こちら</a>から確認してください</p>";
$message_plain = "PRESE Web制作班です．学生から面談予約が入りました．日時：" . date('m月d日', strtotime($unrsvInfo['rsvdate'])) .  '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($unrsvInfo['rsvdate']))))] . ") " . date('H:i', strtotime($unrsvInfo['rsvtime'])) . '〜' . date('H:i', strtotime($unrsvInfo['rsvtime'] . " +1 hours"));
$from = "taiga.kasukabe@gmail.com";
$mail = $empInfo['empmail'];

//mbstring の日本語設定
mb_language("japanese");
mb_internal_encoding("UTF-8");

// インスタンスを生成（引数に true を指定して例外 Exception を有効に）
$gmail = new PHPMailer(true);

//日本語用設定
$gmail->CharSet = "iso-2022-jp";
$gmail->Encoding = "7bit";

try {
    //サーバの設定
    // $gmail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
    $gmail->isSMTP();   // SMTP を使用
    $gmail->Host       = 'smtp.gmail.com';  // ★★★ Gmail SMTP サーバーを指定
    $gmail->SMTPAuth = true;   // SMTP authentication を有効に
    $gmail->Username = $user_mail;  // ★★★ Gmail ユーザ名
    $gmail->Password   = $user_pass;  // ★★★ Gmail パスワード
    $gmail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ★★★ 暗号化（TLS)を有効に
    $gmail->Port = 587;  //★★★ ポートは 587

    //受信者設定
    //差出人アドレス, 差出人名
    $gmail->setFrom($from, mb_encode_mimeheader('PRESE'));
    // 受信者アドレス, 受信者名（受信者名はオプション）
    $gmail->addAddress($mail, mb_encode_mimeheader("登録者様"));
    // 追加の受信者（受信者名は省略可能）
    // $gmail->addAddress('xxxxxx@example.com');
    //返信用アドレス（差出人以外に必要であれば）
    // $gmail->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));
    //Cc 受信者の指定
    // $gmail->addCC('someone@example.com');

    //コンテンツ設定
    $gmail->isHTML(true);   // HTML形式を指定
    //メール表題（タイトル）
    $gmail->Subject = mb_encode_mimeheader($subject);
    //本文（HTML用）
    $gmail->Body  = mb_convert_encoding($message_html, "JIS", "UTF-8");
    //テキスト表示の本文
    $gmail->AltBody = mb_convert_encoding($message_plain, "JIS", "UTF-8");

    $gmail->send();  //送信
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$gmail->ErrorInfo}";
}
?>