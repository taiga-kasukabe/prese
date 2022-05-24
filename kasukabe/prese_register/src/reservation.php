<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$empid = $_GET['empid'];
$time =  substr_replace($_GET['time'], ':', 2, 0) . ':00';
$reservation_date =  $_GET['date'];
$weekNum = $_GET['weekNum'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");
$comment = $_GET['comment'];
var_dump($empid);
var_dump($time);
var_dump($reservation_date);
var_dump($comment);

//DB接続
try {
    $options = array(
        // SQL実行失敗時には例外をスローしてくれる
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // カラム名をキーとする連想配列で取得する．これが一番ポピュラーな設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    $dbh = new PDO($dsn, $db_username, $db_password, $options);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

// 社員リスト取得
$sql = "SELECT * FROM empDB WHERE empid = :empid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$employee = $stmt->fetch();

// ユーザ情報取得
$id = $_SESSION['id'];
$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

// 該当予約情報取得
$sql = "SELECT * FROM rsvDB WHERE empid = :empid AND rsvdate = :rsvdate AND rsvtime = :rsvtime";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->bindValue('rsvdate', $reservation_date);
$stmt->bindValue('rsvtime', $time);
$stmt->execute();
$unrsvInfo = $stmt->fetch();
var_dump($unrsvInfo);

$sql = "UPDATE rsvDB SET stuid = :stuid, comment = :comment, flag = 1 WHERE rsvDB. id=:id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue('stuid', $id);
$stmt->bindValue('comment', $comment);
$stmt->bindValue('id', $unrsvInfo['id']);
$stmt->execute();

?>

<!-- ページ表示 -->
<h1>予約完了しました</h1>
<h2>登録ID名：<?php echo $id; ?>さん</h2>

<input type="button" onclick="location.href='./home.php'" value="ホームへ">