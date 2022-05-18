<?php

// セッションを開始する
session_start();

// セッション情報の引継ぎ
include("./conf/variable_session.php");

//データベース情報
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

    $sql = "INSERT INTO users_table(username, username_kana, mail, mail_confirm, tel, school, department1, department2, student_year, id, password, password_confirm) VALUES (:username, :username_kana, :mail, :mail_confirm, :tel, :school, :department1, :department2, :student_year, :id, :password, :password_confirm)";
    $stmt = $dbh -> prepare($sql);
    $stmt -> bindValue(':username', $username);
    $stmt -> bindValue(':username_kana', $username_kana);
    $stmt -> bindValue(':mail', $mail);
    $stmt -> bindValue(':mail_confirm', $mail_confirm);
    $stmt -> bindValue(':tel', $tel);
    $stmt -> bindValue(':school', $school);
    $stmt -> bindValue(':department1', $department1);
    $stmt -> bindValue(':department2', $department2);
    $stmt -> bindValue(':student_year', $student_year);
    $stmt -> bindValue(':id', $id);
    $stmt -> bindValue(':password', $password);
    $stmt -> bindValue(':password_confirm', $password_confirm);
    $stmt -> execute();

    //メール送信
    include("./send_mail.php");

    $msg = '会員登録が完了しました。';
    $link = '<a href="login_form.php">ログインページ</a>';


?>

<html>
<body>
<h1><?php echo $msg; ?></h1>
登録ID名：<?php echo $id; ?><br>
先ほど登録完了メールを送りました。<br>
ご確認ください。<br><br>
<?php echo $link; ?>