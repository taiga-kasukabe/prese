<!--退会-->

<?php
session_start();
//データベース情報の読み込み
include('../conf/config.php');
$employee = array();
$temp = 0;

//データベースへ接続、テーブルがない場合は作成
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}



$id = $_SESSION['id'];
$sql =  "DELETE FROM users_table WHERE id = :id";
$stmt = $dbh -> prepare($sql);
$stmt -> bindValue(':id', $id);
$stmt -> execute();

?>
<h1>退会しましたしました</h1>
<p>ご利用いただきありがとうございました。</p>
<a href="./login_form.php">ログインページへ</a>