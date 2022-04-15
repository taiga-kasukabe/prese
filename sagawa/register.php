<?php
require_once('config.php');

//変数定義
include("./conf/variable.php");

//データベースへ接続、テーブルがない場合は作成
try {
//インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
//setAttribute(属性、値)
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//繰り返し
  $pdo->exec("create table if not exists userDeta(
      id int not null auto_increment primary key,
      email varchar(255),
      password varchar(255),
      created timestamp not null default current_timestamp
    )");
//エラー処理
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

//データベース内のメールアドレスを取得
$sql = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $dbh -> prepare($sql);
$stmt -> bindValue(':mail', $mail);
$stmt -> execute();
$member = $stmt -> fetch();

if(isset($member['mail'])){
  $msg = '同じメールアドレスが存在します。';
  $link = '<a href="top.php">戻る</a>';
} else {
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
}
?>

<h1>登録しました</h1>
<p>登録ID名：<?php echo $id;?></p>