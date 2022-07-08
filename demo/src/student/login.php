<?php
//セッションの開始
session_start();

//$idに入力されたログインIDを代入
$id = $_POST['id'];

//データベース情報の読み込み
include('../../conf/config.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

//データベースからログインIDが一致するユーザー情報を取得する
$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

//入力されたパスワードとデータベースから取得したパスワードが一致しているか確認
if (password_verify($_POST['password'],$member['password'])) {
    $_SESSION['id'] = $member['id'];
    header('Location:./home.php');
} else {
    $_SESSION['err_msg'] = 'IDもしくはパスワードが間違っています。';
    header('Location:./login_form.php');
}