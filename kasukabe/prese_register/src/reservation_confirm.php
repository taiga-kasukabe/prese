<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$empid = $_GET['empid'];
$time =  $_GET['time'];
$reservation_date =  $_GET['date'];

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

$date = date('m/d');
$date_1 = date('m/d', strtotime('1 day'));

?>

<!-- 表示画面 -->
<h1>予約確認画面</h1>

<p><?php echo $employee['empname']; ?></p>
<img src="./images/<?php echo $employee['empimg_id']; ?>" alt="社員画像" height="300">
<p>年次：<?php echo $employee['empyear']; ?>年目</p>
<p>役職：<?php echo $employee['empjob']; ?></p>
<p>職種：<?php echo $employee['empcareer']; ?></p>
<p>趣味：<?php echo $employee['emphobby']; ?></p>

<h2>予約時間：<?php echo $time; ?></h2>
<h2>予約日程：<?php echo $reservation_date; ?></h2>

<form action="./reservation.php" method="GET">
    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
    <input type="hidden" name="week" value="0">
    <input type="submit" value="戻る">
</form>