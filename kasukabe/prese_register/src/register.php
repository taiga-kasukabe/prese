<?php
session_start();

// 読み込み
include("../conf/variable_session.php");
include("../conf/db_conf.php");
include("../conf/mail_conf.php");

// DBに接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    // エラーログ出力
    $err_msg['db_error'] = $e->getMessage();
}

$sql = "INSERT INTO users_table (id, username, username_kana, mail, mail_confirm, tel, school, department1, department2, student_year, password, password_confirm) VALUES (:id, :username, :username_kana, :mail, :mail_confirm, :tel, :school, :department1, :department2, :student_year, :password, :password_confirm)";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':username_kana', $username_kana);
$stmt->bindValue(':mail', $mail);
$stmt->bindValue(':mail_confirm', $mail_confirm);
$stmt->bindValue(':tel', $tel);
$stmt->bindValue(':school', $school);
$stmt->bindValue(':department1', $department1);
$stmt->bindValue(':department2', $department2);
$stmt->bindValue(':student_year', $student_year);
$stmt->bindValue(':id', $id);
$stmt->bindValue(':password', $password);
$stmt->bindValue(':password_confirm', $password_confirm);
$stmt->execute();

// メール送信
include("./mail_send.php");
?>

<h1>登録しました</h1>
<p>登録ID名：<?php echo $id;?></p><br>
<p>登録完了しました．<br>先ほど登録完了メールを送りました．<br>ご確認ください</p><br>
<p>こちらのリンクからログインしてください</p>
<a href="./login_form.php">ログインページへ</a>