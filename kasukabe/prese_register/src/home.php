<link rel="stylesheet" href="./css/mouseover.css">

<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$employee = array();
$temp = 0;

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
$id = $_SESSION['id'];

$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

$sql = "SELECT * FROM empDB";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM `empDB` WHERE empyear = (SELECT MAX(empyear) FROM empDB)";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$employeeYear = $stmt->fetch();
$empyearMax = $employeeYear['empyear'];
?>


<!-- ここからページ表示 -->
<p>こんにちは，<?php echo $member['username']; ?>さん</p>

<a href="./mypage.php">マイページへ</a><br>
<a href="./diagnose_form.php">簡易診断へ</a>

<h2>社員検索</h2>
<form action="" method="POST">
    <input type="radio" name="gender" value="woman">女性
    <input type="radio" name="gender" value="man">男性
    <br>
    <input type="checkbox" name="job" value="nwp">NWP
    <input type="checkbox" name="job" value="se">SE
    <input type="checkbox" name="job" value="serviceDev">サービス開発
    <br>
    <select name="empyearB4">
        <?php for ($i = 3; $i <= $empyearMax; $i++) { ?>
            <option value="<?php echo $i; ?>year"><?php echo $i; ?></option>
        <?php } ?>
    </select>
    年目〜
    <select name="empyearAft">
        <?php for ($i = 3; $i <= $empyearMax; $i++) { ?>
            <option value="<?php echo $i; ?>year"><?php echo $i; ?></option>
        <?php } ?>
    </select>年目
    <input type="submit" value="検索">
</form>

<h2>
    社員リスト
</h2>

<div>
    <?php for ($n = 0; $n < count($employee); $n++) { ?>
        <div class="mouseoverParent">
            <p><?php echo $employee[$n]['empname']; ?></p>
            <img src="../images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
            <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
            <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
            <p>職種：<?php echo $employee[$n]['empcareer']; ?></p><br><br>
            <div class="mouseoverChild">
                <?php echo $employee[$n]['empname']; ?>
                <img src="../images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
                <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
                <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
                <p>職種：<?php echo $employee[$n]['empcareer']; ?></p>
                <p>趣味：<?php echo $employee[$n]['emphobby']; ?></p>
            </div>
        </div>
        <br><br>
    <?php } ?>
</div>
<h2>社員リストはここまで</h2>