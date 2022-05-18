<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>簡易診断</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>

<?php

session_start();

//データベース情報の読み込み
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

$id = $_SESSION['id'];

if(!empty($_POST)) {
    // 診断で入力した情報
    $gender = $_POST['gender'];
    $job = $_POST['job'];
    $year_from = $_POST['year_from'];
    $year_to = $_POST['year_to'];
    
    // 複数選択で配列で受け取ったjobを文字列として結合
     $job_str = "'".implode("','", $job)."'";

    $sql = "UPDATE users_table SET gender = :gender, job_str = :job_str, year_from = :year_from, year_to = :year_to WHERE id=:id";
    $stmt = $dbh -> prepare($sql);
    $stmt -> bindValue(':gender', $gender);
    $stmt -> bindValue(':job_str', $job_str);
    $stmt -> bindValue(':year_from', $year_from);
    $stmt -> bindValue(':year_to', $year_to);
    $stmt -> bindValue(':id', $id);
    $stmt -> execute();

    // データベース検索
    // （1）emptag2かemptag3に選択されたjobが含まれている（2）emptag1の性別と一致（3）年次が選択された範囲内
    $sql_emp = "SELECT * FROM emp_table WHERE ((emptag2 IN ($job_str)) OR (emptag3 IN ($job_str))) AND (emptag1 = :gender) AND (empyear >= :year_from AND empyear <= :year_to)";
    $stmt = $dbh->prepare($sql_emp);
    $stmt->bindValue(':gender', $gender);
     // $stmt->bindValue(':job_str', $job_str);
    $stmt->bindValue(':year_from', $year_from);
    $stmt->bindValue(':year_to', $year_to);
    $stmt->execute();
    $employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>

<body>
<h1>簡易診断</h1>
<div id="result_area" class="result is_open">
    <p>あなたにおすすめの社員はこちら</p>

    <!-- ループで取得した社員情報を全て表示 -->
    <?php if(!empty($_POST)) {
        if(empty($employee)) { 
            echo "該当する社員はいませんでした．";
        } else { ?>
            <?php for ($num = 0; $num < count($employee); $num++) { ?>

            <!-- リストの名前部分をモーダル表示のボタンに -->
            <div class="works_modal_open" data-modal-open="modal-<?php echo $num; ?>">
                <h2><?php echo $employee[$num]['empname']; ?></h2>
                <img src="./images/<?php echo $employee[$num]['empimg_id']; ?>" width="200">
                <p>年次：<?php echo $employee[$num]['empyear']; ?></p>
                <p>職種：<?php echo $employee[$num]['empjob']; ?></p>
                <p>経歴：<?php echo $employee[$num]['empcareer']; ?></p>
            </div>

            <br><br><br>

            <!-- モーダルウインドウここから -->
            <div class="works_modal_wrapper" data-modal="modal-<?php echo $num; ?>">
                <div class="works_modal_mask"></div>
                <div class="works_modal_window">
                    <div class="works_modal_content">
                        <h1><?php echo $employee[$num]['empname']; ?></h1>
                        <img src="./images/<?php echo $employee[$num]['empimg_id']; ?>" width="150">
                        <p>年次：<?php echo $employee[$num]['empyear']; ?></p>
                        <p>職種：<?php echo $employee[$num]['empjob']; ?></p>
                        <p>経歴：<?php echo $employee[$num]['empcareer']; ?></p>
                        <p>趣味：<?php echo $employee[$num]['emphobby']; ?></p>
                        <p>コメント：<?php echo $employee[$num]['empcomment']; ?></p><br>
                        <a href="./reservation.php">面談予約はこちら</a><br><br>
                    </div>
                    <div class="works_modal_close">✖</div>
                </div>
            </div>
            <!-- モーダルウインドウここまで -->

            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>

<a href="home.php">ホームへ</a><br>
<a href="diagnose.php">もう一度診断する</a>
<script src="js/script.js"></script>
</body>
<html>