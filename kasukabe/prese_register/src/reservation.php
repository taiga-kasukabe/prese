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
$id = $_SESSION['id'];

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



// 該当予約情報取得
$sql = "SELECT * FROM rsvDB WHERE empid = :empid AND rsvdate = :rsvdate AND rsvtime = :rsvtime";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->bindValue(':rsvdate', $reservation_date);
$stmt->bindValue(':rsvtime', $time);
$stmt->execute();
$unrsvInfo = $stmt->fetch();

// 予約動作
if ($unrsvInfo['flag'] != 1) {
    $sql = "UPDATE rsvDB SET stuid = :stuid, comment = :comment, flag = 1 WHERE rsvDB. id=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':stuid', $id);
    $stmt->bindValue(':comment', $comment);
    $stmt->bindValue(':id', $unrsvInfo['id']);
    $stmt->execute();
}
?>

<!-- ページ表示 -->
<?php if (!empty($unrsvInfo) && $unrsvInfo['flag']!=1) { ?>
    <h1>予約完了しました</h1>
    <h2>登録ID名：<?php echo $id; ?>さん</h2>
<?php } else { ?>
    <h1>予期せぬエラーが発生しました</h1>
    <p>同時に他の方が予約したかもしれません</p>
    <p>内々定者の方に予定が入ったかもしれません</p>
<?php } ?>

<input type="button" onclick="location.href='./home.php'" value="ホームへ">

<script src="./js/script.js"></script>