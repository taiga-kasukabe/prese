<link rel="stylesheet" href="./css/mouseover.css">

<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$err_msg = array();
// SQL用に文字列用意
if (!empty($_POST['job'])) {
    $job_array = $_POST['job'];
    $job_str = "'" . implode("', '", $job_array) . "'";
}

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

// ユーザ情報取得
$id = $_SESSION['id'];
$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

// 社員リスト取得
$sql = "SELECT * FROM empDB";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 社員最大年次取得
$sql = "SELECT * FROM empDB WHERE empyear = (SELECT MAX(empyear) FROM empDB)";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$employeeYear = $stmt->fetch();
$empyearMax = $employeeYear['empyear'];

// 社員検索
if (!empty($_POST)) {
    // バリデーション
    if ($_POST['empyearB4'] > $_POST['empyearAft']) {
        $err_msg['empyear'] = "正しい範囲を選択してください";
    }
    if (empty($_POST['job'])) {
        $err_msg['empjob'] = "どれか一つ選択してください";
    }
    if (empty($err_msg)) { //ノーエラー時
        $sql = "SELECT * FROM empDB WHERE emptag3 >= :empyearMin AND emptag3 <= :empyearMax AND emptag2 IN ($job_str) ";
        // 「両方」が選択されれば，gender用SQLなし
        if ($_POST['gender'] != "両方") {
            $sql_gender = "AND emptag1= :gender ";
            $sql .= $sql_gender;
        }
        $stmt = $dbh->prepare($sql);
        if ($_POST['gender'] != "両方") {
            $stmt->bindValue(':gender', $_POST['gender']);
        }
        $stmt->bindValue(':empyearMin', $_POST['empyearB4']);
        $stmt->bindValue(':empyearMax', $_POST['empyearAft']);
        $stmt->execute();
        $employee = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!-- ここからページ表示 -->
<p>こんにちは，<?php echo $member['username']; ?>さん</p>

<a href="./mypage.php">マイページへ</a><br>
<a href="./diagnose_form.php">簡易診断へ</a>

<h2>社員検索</h2>
<form action="" method="POST">
    <input type="radio" name="gender" value="女性" required>女性
    <input type="radio" name="gender" value="男性" required>男性
    <input type="radio" name="gender" value="両方" required>両方
    <br>
    <input type="checkbox" name="job[]" value="NWP">NWP
    <input type="checkbox" name="job[]" value="SE">SE
    <input type="checkbox" name="job[]" value="サービス開発">サービス開発
    <span style="color:#c7243a"><?php if (!empty($err_msg['empjob'])) echo $err_msg['empjob']; ?></span>
    <br>
    <select name="empyearB4" required>
        <?php for ($i = 3; $i <= $empyearMax; $i++) { ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php } ?>
    </select>
    年目〜
    <select name="empyearAft" required>
        <?php for ($i = 3; $i <= $empyearMax; $i++) { ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php } ?>
    </select>年目<span style="color: #c7243a;"> <?php if (!empty($err_msg['empyear'])) echo $err_msg['empyear']; ?></span>
    <br>
    <input type="submit" value="検索">
</form>

<h2>社員リスト</h2>
<div>
    <?php if (empty($employee)) {
        echo "<h3>該当する社員はいませんでした．</h3>";
    } ?>
    <?php for ($n = 0; $n < count($employee); $n++) { ?>
        <div class="mouseoverParent">
            <h2><?php echo $employee[$n]['empname']; ?></h2>
            <img src="./images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
            <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
            <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
            <p>職種：<?php echo $employee[$n]['empcareer']; ?></p>
            <form action="./reservation_form.php" method="GET">
                <input type="hidden" name="empid" value="<?php echo $employee[$n]['empid']; ?>">
                <input type="hidden" name="week" value="0">
                <input type="submit" value="予約はこちら">
            </form>
            <div class="mouseoverChild">
                <h2><?php echo $employee[$n]['empname']; ?></h2>
                <img src="./images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
                <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
                <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
                <p>職種：<?php echo $employee[$n]['empcareer']; ?></p>
                <p>趣味：<?php echo $employee[$n]['emphobby']; ?></p>
                <form action="./reservation_form.php" method="GET">
                    <input type="hidden" name="empid" value="<?php echo $employee[$n]['empid']; ?>">
                    <input type="hidden" name="week" value="0">
                    <input type="submit" value="予約はこちら">
                </form>
            </div>
        </div>
        <br><br>
    <?php } ?>
</div>
<h2>社員リストはここまで</h2>