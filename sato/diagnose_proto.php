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

//データベース情報の読み込み
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

if(!empty($_POST)) {
    // バリデーションチェック
    if ($_POST['year_from'] > $_POST['year_to']) {
        $err_msg['empyear'] = "正しい範囲を選択してください";
    }

    if (empty($_POST['job'])) {
        $err_msg['empjob'] = "どれか一つを選択してください";
    }

    if(!isset($err_msg)) {
        $gender = $_POST['gender'];
        $job = $_POST['job'];
        $year_from = $_POST['year_from'];
        $year_to = $_POST['year_to'];

        $sql_emp = "SELECT * FROM emp_table WHERE emptag1 = :gender AND emptag2 = :job AND (empyear >= :year_from AND empyear <= :year_to)";
        $stmt = $dbh->prepare($sql_emp);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':job', $job);
        $stmt->bindValue(':year_from', $year_from);
        $stmt->bindValue(':year_to', $year_to);
        $stmt->execute();
        $employee = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<body>
<h1>簡易診断</h1>

<form method="POST" action="">
    <div id="gender">
        <input type="radio" name="gender" value="m" required <?php if (isset($_POST['gender']) && $_POST['gender'] == "m") { echo 'checked'; } ?>>男性
        <input type="radio" name="gender" value="f" required <?php if (isset($_POST['gender']) && $_POST['gender'] == "f") { echo 'checked'; } ?>>女性
    </div>
    <div id="job">
        <input type="checkbox" name="job" value="nwp" <?php if (isset($_POST['job']) && $_POST['job'] == "nwp") { echo 'checked'; } ?>>NWP
        <input type="checkbox" name="job" value="se" <?php if (isset($_POST['job']) && $_POST['job'] == "se") { echo 'checked'; } ?>>SE
        <input type="checkbox" name="job" value="service" <?php if (isset($_POST['job']) && $_POST['job'] == "service") { echo 'checked'; } ?>>サービス開発
        <input type="checkbox" name="job" value="collab" <?php if (isset($_POST['job']) && $_POST['job'] == "collab") { echo 'checked'; } ?>>協業ビジネス
    </div>
    <span style="color:#c7243a"><?php if (!empty($err_msg['empjob'])) echo $err_msg['empjob']; ?></span>
    <div id="year">
        <select name="year_from" size="1">
            <option value="">---</option>

            <?php
            for($i=1; $i <= 10; $i++) {
                if($i == $_POST['year_from']) {    
                    echo '<option value='.$i.' selected>'.$i.'</option>'; 
                } else {
                    echo '<option value='.$i.'>'.$i.'</option>';
                }
            }
            ?>

        </select>
        年目～
        <select name="year_to" size="1">
            <option value="">---</option>

            <?php
            for($i=1; $i <= 10; $i++) { 
                if($i == $_POST['year_to']) {    
                    echo '<option value='.$i.' selected>'.$i.'</option>'; 
                } else {
                    echo '<option value='.$i.'>'.$i.'</option>';
                }
            }
            ?>

        </select>
        年目
    </div>
    </select><span style="color: #c7243a;"> <?php if (!empty($err_msg['empyear'])) echo $err_msg['empyear']; ?></span><br>
    <input type="submit" value="検索"><br><br>
</form>


<!-- ループで取得した社員情報を全て表示 -->
<?php if(empty($employee)) { 
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

<script src="./js/script.js"></script>

</body>