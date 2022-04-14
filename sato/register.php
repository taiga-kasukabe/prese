<?php

// セッションを開始する
session_start();

// 変数定義
//各種入力情報，正規表現，エラーメッセージ配列
include("./conf/variable.php");

//データベース情報
//あとで分ける
$dsn = "mysql:host=localhost; dbname=presedb; charset=utf8;";
$username = "root";
$password = "";

//データベース接続
try{
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

//メールアドレスの重複がないか確認
//これもsignup.phpのバリデーションチェックと一緒の方がいい？？
$sql = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $dbh -> prepare($sql);
$stmt -> bindValue(':mail', $mail);
$stmt -> execute();
$member = $stmt -> fetch();

if(isset($member['mail'])){
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="signup.php">戻る</a>';
} else {

    $sql = "INSERT INTO users_tabel(username, username_kana, mail, mail_confirm, tel, school, depertment1, depertment2, student_year, id, pass, pass_confirm)
     VALUES (:username, :username_kana, :mail, :mail_confirm, :tel, :school, :depertment1, :depertment2, :student_year, :id, :pass, :pass_confirm)";
    $stmt = $dbh -> prepare($sql);
    $stmt -> bindValue(':username', $username);
    $stmt -> bindValue(':username_kana', $username_kana);
    $stmt -> bindValue(':mail', $mail);
    $stmt -> bindValue(':mail_confirm', $mail_confirm);
    $stmt -> bindValue(':tel', $tel);
    $stmt -> bindValue(':school', $school);
    $stmt -> bindValue(':depertment1', $depertment1);
    $stmt -> bindValue(':depertment2', $depertment2);
    $stmt -> bindValue(':student_year', $student_year);
    $stmt -> bindValue(':id', $id);
    $stmt -> bindValue(':pass', $pass);
    $stmt -> bindValue(':pass_confirm', $pass_confirm);
    $stmt -> execute();

    $msg = '会員登録が完了しました。';
    $link = '<a href="login_form.php">ログインページ</a>';
}

?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>