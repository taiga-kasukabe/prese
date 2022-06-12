<!--退会-->

<?php
session_start();
//データベース情報の読み込み
include('../conf/config.php');
$employee = array();
$temp = 0;

//データベースへ接続、テーブルがない場合は作成
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}


$id = $_SESSION['id'];
// 当該学生の予約情報を全て未予約に変更
$sql = "SELECT * FROM rsvdb WHERE stuid = :stuid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':stuid', $id);
$stmt->execute();
$rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
$updateID = array();
if (!empty($rsvInfo)) {
    for ($i = 0; $i < count($rsvInfo); $i++) {
        $updateID[$i] = $rsvInfo[$i]['id'];
    }
    $sql = "UPDATE rsvdb SET stuid='', flag=0 WHERE id IN (" . implode(',', $updateID) . ")";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
}

// 学生アカウントの削除
$sql =  "DELETE FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();

?>
<h1>退会しました</h1>
<p>ご利用いただきありがとうございました。</p>
<a href="./login_form.php">ログインページへ</a>