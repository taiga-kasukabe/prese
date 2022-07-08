<!--退会-->

<?php
session_start();
//データベース情報の読み込み
include('./conf/config.php');
$employee = array();
$temp = 0;

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
} catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
}

$id = $_SESSION['id'];
$sql =  "DELETE FROM users_table WHERE id = :id";
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue(':id', $id);
$stmt -> execute();

?>
<h1>退会しましたしました</h1>
<p>ご利用いただきありがとうございました。</p>
<a href="./login_form.php">ログインページへ</a>