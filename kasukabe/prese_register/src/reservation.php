<link rel="stylesheet" href="./css/table.css">

<?php
session_start();

// 変数定義
include('../conf/db_conf.php');

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
$stmt->bindValue(':empid', $_POST['empid']);
$stmt->execute();
$employee = $stmt->fetch();

$date = date('m/d');
$date_1 = date('m/d', strtotime('1 day'));
?>

<h1>予約画面</h1>
<p><?php echo $employee['empname']; ?></p>
<img src="./images/<?php echo $employee['empimg_id']; ?>" alt="社員画像" height="300">
<p>年次：<?php echo $employee['empyear']; ?>年目</p>
<p>役職：<?php echo $employee['empjob']; ?></p>
<p>職種：<?php echo $employee['empcareer']; ?></p>
<p>趣味：<?php echo $employee['emphobby']; ?></p>

<table>
    <tr>
        <th>時間(時)</th><?php for ($i = 1; $i <= 10; $i++) print '<th>' . date('m/d', strtotime($i . 'day')) . '</th>'; ?>
    </tr>
    <tr>
        <th>1000</th><?php for ($i = 0; $i < 10; $i++) print '<td></td>'; ?>
    </tr>
    <tr>
        <th>1100</th><?php for ($i = 0; $i < 10; $i++) print '<td></td>'; ?>
    </tr>
    <tr>
        <th>1300</th><?php for ($i = 0; $i < 10; $i++) print '<td></td>'; ?>
    </tr>
    <tr>
        <th>1400</th><?php for ($i = 0; $i < 10; $i++) print '<td></td>'; ?>
    </tr>
    <tr>
        <th>1500</th><?php for ($i = 0; $i < 10; $i++) print '<td></td>'; ?>
    </tr>
    <tr>
        <th>1600</th><?php for ($i = 0; $i < 10; $i++) print '<td></td>'; ?>
    </tr>
</table>

<button type="button" id="btn"><span>a</span></button>

<script src="./js/script.js"></script>