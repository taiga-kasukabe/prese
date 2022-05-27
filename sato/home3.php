<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>ホーム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal3.css">
    <link rel="stylesheet" href="./css/home3.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
    </head>

<?php

session_start();

if(!isset($_SESSION['id'])){
    echo 'ログインが必要です';
    exit;
}


//データベース情報の読み込み
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

$id = $_SESSION['id'];

//ユーザー情報の取得
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_user);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

// 前回の診断結果を取得，変数に代入
$gender = $member['gender'];
$job_str = $member['job_str'];
$year_from = $member['year_from'];
$year_to = $member['year_to'];

//社員情報（全体）の取得
$sql_emp = "SELECT * FROM emp_table";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 社員情報（おすすめ）の取得
if (!empty($gender)) {
// （1）emptag2かemptag3に選択されたjobが含まれている（2）emptag1の性別と一致（3）年次が選択された範囲内
$sql_emp = "SELECT * FROM emp_table WHERE ((emptag2 IN ($job_str)) OR (emptag3 IN ($job_str))) AND (emptag1 = :gender) AND (empyear >= :year_from AND empyear <= :year_to)";
$stmt = $dbh->prepare($sql_emp);
$stmt->bindValue(':gender', $gender);
$stmt->bindValue(':year_from', $year_from);
$stmt->bindValue(':year_to', $year_to);
$stmt->execute();
$employee_rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<header>
    <div class="bg">
        <a href="./mypage.php" id="mypage">マイページ</a>
        <img src="images/ntt-east.png" id="logo">
    </div>
</header>


<body>
<div class="headImg">
    <!-- <img src="images/building.jpg"> -->
    <p>面談予約</p>
</div>

<main>
<!-- 簡易診断へのリンク -->
<br>
<a href="./diagnose.php" class="btn">
    <span class="btn_text">おすすめの社員を診断する</span>
</a>

<!-- おすすめの社員の表示 -->
<?php if (!empty($employee_rec)) { ?>
<p class="section_title">おすすめ社員一覧</p>
<div class="employee">
<?php for ($num = 0; $num < count($employee_rec); $num++) { ?>

<!-- リストの名前部分をモーダル表示のボタンに -->
    <div class="works_modal_open" data-modal-open="rec-modal-<?php echo $num; ?>">
        <img src="./images/<?php echo $employee_rec[$num]['empimg_id']; ?>">
        <h2><?php echo $employee_rec[$num]['empname']; ?></h2>
        <p>年次：<?php echo $employee_rec[$num]['empyear']; ?></p>
        <p>職種：<?php echo $employee_rec[$num]['emptag2']; ?></p>
        <!-- <p>経歴：<?php //echo $employee_rec[$num]['empcareer']; ?></p> -->
    </div>

<!-- モーダルウインドウここから -->
<div class="works_modal_wrapper" data-modal="rec-modal-<?php echo $num; ?>">
    <div class="works_modal_mask"></div>
    <div class="works_modal_window">
        <div class="works_modal_content">
            <img src="./images/<?php echo $employee_rec[$num]['empimg_id']; ?>">
            <div class="introduction">
                <h1><?php echo $employee_rec[$num]['empname']; ?></h1>
                <p>年次：<?php echo $employee_rec[$num]['empyear']; ?></p>
                <p>職種：<?php echo $employee_rec[$num]['empjob']; ?></p>
                <p>経歴：<?php echo $employee_rec[$num]['empcareer']; ?></p>
                <p>趣味：<?php echo $employee_rec[$num]['emphobby']; ?></p>
                <p>コメント：<?php echo $employee_rec[$num]['empcomment']; ?></p><br>
            </div>
            <a href="./reservation.php">面談予約はこちら</a><br><br>
        </div>
        <div class="works_modal_close">✖</div>
    </div>
</div>
<!-- モーダルウインドウここまで -->
<?php } ?>
<?php } ?>
</div>


<p class="section_title">社員一覧</p>
<!-- ループで取得した社員情報を全て表示 -->
<div class="employee">
<?php for ($num = 0; $num < count($employee); $num++) { ?>

<!-- リストの名前部分をモーダル表示のボタンに -->
<div class="works_modal_open" data-modal-open="modal-<?php echo $num; ?>">
    <h2><?php echo $employee[$num]['empname']; ?></h2>
    <img src="./images/<?php echo $employee[$num]['empimg_id']; ?>">
    <p>年次：<?php echo $employee[$num]['empyear']; ?></p>
    <p>職種：<?php echo $employee[$num]['emptag2']; ?></p>
    <!-- <p>経歴：<?php //echo $employee[$num]['empcareer']; ?></p> -->
</div>

<!-- モーダルウインドウここから -->
<div class="works_modal_wrapper" data-modal="modal-<?php echo $num; ?>">
    <div class="works_modal_mask"></div>
    <div class="works_modal_window">
        <div class="works_modal_content">
            <img src="./images/<?php echo $employee[$num]['empimg_id']; ?>">
            <div class="introduction">
                <h1><?php echo $employee[$num]['empname']; ?></h1>
                <p>年次：<?php echo $employee[$num]['empyear']; ?></p>
                <p>職種：<?php echo $employee[$num]['empjob']; ?></p>
                <p>経歴：<?php echo $employee[$num]['empcareer']; ?></p>
                <p>趣味：<?php echo $employee[$num]['emphobby']; ?></p>
                <p>コメント：<?php echo $employee[$num]['empcomment']; ?></p><br>
            </div>
            <a href="./reservation.php">面談予約はこちら</a><br><br>
        </div>
        <div class="works_modal_close">✖</div>
    </div>
</div>
<!-- モーダルウインドウここまで -->

<?php } ?>
</div>

<script src="./js/modal.js"></script>
</main>
</body>
</html>