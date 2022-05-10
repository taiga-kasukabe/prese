<!--簡易診断-->
<link rel="stylesheet" href="./css/mouseover.css">
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>簡易診断</title>
</head>

<?php

session_start();
//データベース情報の読み込み
include('./conf/config.php');
$employee = array();
$temp = 0;

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
} catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
}

//empDB接続
$sql_emp = "SELECT * FROM emp_table";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!empty($_POST)) {
    // バリデーションチェック
    if ($_POST['year_mi'] > $_POST['year_mx']) {
        $err_msg['empyear'] = "正しい範囲を選択してください";
    }

    if (empty($_POST['job'])) {
        $err_msg['empjob'] = "どれか一つを選択してください";
    }

    if(!isset($err_msg)) {
        $gender = $_POST['gender'];
        $job = $_POST['job'];
        $year_mi = $_POST['year_mi'];
        $year_mx = $_POST['year_mx'];

        // 複数選択で配列で受け取ったjobを文字列として結合
        $job_str = "'".implode("','", $job)."'";

        $sql_emp = "SELECT * FROM emp_table WHERE ((emptag2 IN ($job_str)) OR (emptag3 IN ($job_str))) AND (emptag1 = :gender) AND (empyear >= :year_mi AND empyear <= :year_mx)";
        $stmt = $pdo->prepare($sql_emp);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':year_mi', $year_mi);
        $stmt->bindValue(':year_mx', $year_mx);
        $stmt->execute();
        $employee = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<h1>社員検索<h1>
<form action="" method="POST">
    <div id="gender">性別：
        <input type="radio" name="gen" value="男性" required>男性
        <input type="radio" name="gen" value="女性" required>女性
    </div>

    <div id="jobs">職種：
        <input type="checkbox" name="job[]" value="SE" >SE
        <input type="checkbox" name="job[]" value="NWP" >NWP
        <input type="checkbox" name="job[]" value="サービス開発" >サービス開発
    </div>

<p>
    <div id="year">年次：
        <select name="year_mi" size="1">
            <option value="">---</option>
            <?php
            for($i=1; $i <= 10; $i++) {
                if($i == $_POST['year_mi']) {    
                    echo '<option value='.$i.' selected>'.$i.'</option>'; 
                } else {
                    echo '<option value='.$i.'>'.$i.'</option>';
                } }
            ?>
        </select>
        年目～
        <select name="year_mx" size="1">
            <option value="">---</option>
            <?php
            for($i=1; $i <= 10; $i++) { 
                if($i == $_POST['year_mx']) {    
                    echo '<option value='.$i.' selected>'.$i.'</option>'; 
                } else {
                    echo '<option value='.$i.'>'.$i.'</option>';
                }}
            ?>
        </select>
        年目
    </div>
<input type="submit" value="検索">
</p>

<h2>社員リスト</h2>

<div>
    <?php if (empty($employee)) {
        echo "<h3>該当する社員はいませんでした．</h3>";
    } ?>
    <?php for ($n = 0; $n < count($employee); $n++) { ?>
        <div class="mouseoverParent">
            <p><?php echo $employee[$n]['empname']; ?></p>
            <img src="./images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
            <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
            <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
            <p>職種：<?php echo $employee[$n]['empcareer']; ?></p><br><br>
            <div class="mouseoverChild">
                <?php echo $employee[$n]['empname']; ?>
                <img src="./images/<?php echo $employee[$n]['empimg_id']; ?>" alt="社員画像" height="300">
                <p>年次：<?php echo $employee[$n]['empyear']; ?>年目</p>
                <p>役職：<?php echo $employee[$n]['empjob']; ?></p>
                <p>職種：<?php echo $employee[$n]['empcareer']; ?></p>
                <p>趣味：<?php echo $employee[$n]['emphobby']; ?></p>
            </div>
        </div>
        <br><br>
    <?php } ?>
</div>