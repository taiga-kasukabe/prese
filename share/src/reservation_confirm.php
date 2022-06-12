<?php
session_start();

// 変数定義
include('../conf/config.php');
$comment = $_POST['comment'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");
list($empid, $time, $reservation_date, $weekNum) = explode(":", $_POST['free']);


//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

// 社員リスト取得
$sql = "SELECT * FROM emp_table WHERE empid = :empid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$employee = $stmt->fetch();
?>

<!-- 表示画面 -->
<h1>予約確認画面</h1>

<p><?php echo $employee['empname']; ?></p>
<img src="./images/<?php echo $employee['empimg_id']; ?>" alt="社員画像" height="300">
<p>年次：<?php echo $employee['empyear']; ?>年目</p>
<p>役職：<?php echo $employee['empjob']; ?></p>
<p>職種：<?php echo $employee['empcareer']; ?></p>
<p>趣味：<?php echo $employee['emphobby']; ?></p>

<h2>予約日程：<?php echo date('m/d', strtotime($reservation_date)) . '(' . $weekJa[$weekNum] . ')'; ?></h2>
<h2>予約時間：<?php echo substr_replace($time, ':', 2, 0); ?></h2>
<h2>相談内容：<?php if (!empty($comment)) {
                echo $comment;
            } else {
                echo "特になし";
            } ?></h2>
<form action="./reservation.php" method="get">
    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
    <input type="hidden" name="time" value="<?php echo $time; ?>">
    <input type="hidden" name="date" value="<?php echo $reservation_date ?>">
    <input type="hidden" name="weekNum" value="<?php echo $weekNum; ?>">
    <input type="hidden" name="comment" value="<?php echo $comment; ?>">
    <input type="submit" value="予約">
</form>

<form action="./reservation_form.php" method="GET">
    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
    <input type="hidden" name="week" value="0">
    <input type="submit" value="戻る">
</form>