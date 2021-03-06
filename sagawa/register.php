<?php
session_start();

//変数定義
include("./conf/variable_session.php");
include("./conf/config.php");

//データベースへ接続、テーブルがない場合は作成
try {
  //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //エラー処理
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

  $sql = "INSERT INTO users_table(id, username, username_kana, mail, mail_confirm, tel, school, department1, department2, student_year, password, password_confirm) VALUES (:id, :username, :username_kana, :mail, :mail_confirm, :tel, :school, :department1, :department2, :student_year, :password, :password_confirm)";
  $stmt = $pdo -> prepare($sql);
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
  
?>

<h1>登録しました</h1>
<p>登録ID名：<?php echo $id;?></p>
<p>こちらのリンクからログインしてください</p>
<a href="./login_form.php">ログインページへ</a>