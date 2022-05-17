<link rel="stylesheet" href="css/table.css">

<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$empid = $_GET['empid'];
$week = $_GET['week'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");


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

// ユーザ情報取得
$id = $_SESSION['id'];
$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();
?>

<!-- 表示画面 -->
<h1>予約画面</h1>
<p><?php echo $employee['empname']; ?></p>
<img src="./images/<?php echo $employee['empimg_id']; ?>" alt="社員画像" height="300">
<p>年次：<?php echo $employee['empyear']; ?>年目</p>
<p>役職：<?php echo $employee['empjob']; ?></p>
<p>職種：<?php echo $employee['empcareer']; ?></p>
<p>趣味：<?php echo $employee['emphobby']; ?></p>

<?php
// echo $weekJa[date('w', strtotime(date('Y-m-d')))];
if ($week > 0) {
    echo '<a href="./reservation.php?empid=' . $empid . '&week=' . $week - 1 . '">前の1週間</a></br>';
}
echo '<a href="./reservation.php?empid=' . $empid . '&week=' . $week + 1 .  '">次の1週間</a>';
?>

<table>
    <tr>
        <th>時間(時)</th><?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<th>' . date('m/d', strtotime($i . 'day')) . '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($i . 'day'))))] . ')</th>'; ?>
    </tr>
    <tr>
        <th>1000</th><?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<td><a href="./reservation_confirm.php?empid=' . $empid . '&time=1000&date=' . date('md', strtotime($i . 'day')) . '">◉</td>'; ?>
    </tr>
    <tr>
        <th>1100</th>
        <?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<td><a href="./reservation_confirm.php?empid=' . $empid . '&time=1100&date=' . date('md', strtotime($i . 'day')) . '">◉</td>'; ?>
    </tr>
    <tr>
        <th>1300</th><?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<td><a href="./reservation_confirm.php?empid=' . $empid . '&time=1300&date=' . date('md', strtotime($i . 'day')) . '">◉</td>'; ?>
    </tr>
    <tr>
        <th>1400</th><?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<td><a href="./reservation_confirm.php?empid=' . $empid . '&time=1400&date=' . date('md', strtotime($i . 'day')) . '">◉</td>'; ?>
    </tr>
    <tr>
        <th>1500</th><?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<td><a href="./reservation_confirm.php?empid=' . $empid . '&time=1500&date=' . date('md', strtotime($i . 'day')) . '">◉</td>'; ?>
    </tr>
    <tr>
        <th>1600</th><?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) print '<td><a href="./reservation_confirm.php?empid=' . $empid . '&time=1600&date=' . date('md', strtotime($i . 'day')) . '">◉</td>'; ?>
    </tr>
</table>


<a href="./home.php">戻る</a>

<br>
<button type="button" id="btn"><span>a</span></button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="./js/script.js"></script>