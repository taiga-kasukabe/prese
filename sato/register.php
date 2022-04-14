<?php

// セッションを開始する
session_start();

// 変数定義
//各種入力情報，正規表現，エラーメッセージ配列
include("./conf/variable.php");

//データベース情報
//あとで分ける
$dsn = "mysql:host=localhost; dbname=user_table; charset=utf8;";
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
$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh -> prepare($sql);
$stmt -> bindValue(':mail', $mail);
$stmt -> execute();
$member = $stmt -> fetch();

if($member = false){
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="signup.php">戻る</a>';
} else {

    $sql = "INSERT INTO users(name, mail, pass) VALUES (:name, :mail, :pass)";
    $stmt = $dbh -> prepare($sql);
    $stmt -> bindValue(':name', $name);
    $stmt -> bindValue(':mail', $mail);
    $stmt -> bindValue(':pass', $pass);
    $stmt -> execute();

    $msg = '会員登録が完了しました。';
    $link = '<a href="login_form.php">ログインページ</a>';
}

?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>