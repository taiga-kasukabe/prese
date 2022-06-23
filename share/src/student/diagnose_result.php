<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>簡易診断結果</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/popup.css">
    <link rel="stylesheet" href="../../css/diagnose_result.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php

session_start();

//データベース情報の読み込み
// include('../../conf/config.php');
$dsn = "mysql:charset=UTF8;dbname=preempdb;host=localhost";
$db_username = "root";
$db_password = "root";

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

// $id = $_SESSION['id'];

if(!empty($_POST)) {
    // 診断で入力した情報
    $academichistory = $_POST['academichistory'];
    $industry = $_POST['industry'];
    $skill = $_POST['skill'];
    
    // 複数選択で配列で受け取った変数を文字列として結合
    $academichistory_str = "'^(?=.*".implode(").*$|^(?=.*", $academichistory).").*$'";
    $industry_str = "'^(?=.*".implode(").*$|^(?=.*", $industry).").*$'";
    $skill_str = "'^(?=.*".implode(").*$|^(?=.*", $skill).").*$'";

    // $sql = "UPDATE users_table SET academichistory = :academichistory, industry = :industry, skill = :skill WHERE id=:id";
    // $stmt = $dbh -> prepare($sql);
    // $stmt -> bindValue(':academichistory', $academichistory_str);
    // $stmt -> bindValue(':industry', $industry_str);
    // $stmt -> bindValue(':skill', $skill_str);
    // $stmt -> bindValue(':id', $id);
    // $stmt -> execute();

    // データベース検索
    // （1）emptag2かemptag3に選択されたjobが含まれている（2）emptag1の性別と一致（3）年次が選択された範囲内
    $sql_emp = "SELECT * FROM emp_table WHERE (empacademichistory REGEXP ($academichistory_str)) AND (empindustry REGEXP ($industry_str)) AND (empskill REGEXP ($skill_str))";
    $stmt = $dbh->prepare($sql_emp);
    // $stmt->bindValue(':academichistory', $academichistory_str);
    // $stmt->bindValue(':industry', $industry_str);
    // $stmt->bindValue(':skill', $skill_str);
    var_dump($sql_emp);
    $stmt->execute();
    $employee_rec = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
            <a href="./home.php" id="home">ホーム</a>
        </div>
    </header>

    <main>
        <?php //if (!empty($_SESSION['id'])) { ?>
            <div id="result_area" class="result is_open">
                <p class="text">あなたにおすすめの社員はこちら！</p>

                <!-- ループで取得した社員情報を全て表示 -->
                <?php if(!empty($_POST)) {
                    if(empty($employee_rec)) { 
                        echo "該当する社員はいませんでした．";
                    } else { ?>
                        <p class="section_title">RECOMMEND</p>
                        <div class="list">
                            <?php for ($num = 0; $num < count($employee_rec); $num++) { ?>

                                <!-- リストをモーダル表示のボタンに -->
                                <div class="works_modal_open" data-modal-open="rec-modal-<?php echo $num; ?>">
                                    <div class="emp_img" style="background-image: url(../../images/<?php echo $employee_rec[$num]['empimg_id']; ?>);background-size:cover;">
                                    </div>
                                    <div class="arrow">→</div>
                                    <div class="emp_data">
                                        <h2><?php echo $employee_rec[$num]['empname']; ?></h2>
                                        <p><span class="mgr_20">年次：<?php echo $employee_rec[$num]['empyear']; ?></span>職種：<?php echo $employee_rec[$num]['emptag2']; ?></p>
                                    </div>
                                </div>

                                <!-- モーダルウインドウここから -->
                                <div class="works_modal_wrapper" data-modal="rec-modal-<?php echo $num; ?>">
                                    <div class="works_modal_mask"></div>
                                    <div class="works_modal_window">
                                        <div class="works_modal_content">
                                            <img src="../../images/<?php echo $employee_rec[$num]['empimg_id']; ?>">
                                            <div class="introduction">
                                                <h1><?php echo $employee_rec[$num]['empname']; ?></h1>
                                                <p>年次：<?php echo $employee_rec[$num]['empyear']; ?></p>
                                                <p>職種：<?php echo $employee_rec[$num]['empjob']; ?></p>
                                                <p>経歴：<?php echo $employee_rec[$num]['empcareer']; ?></p>
                                                <p>趣味：<?php echo $employee_rec[$num]['emphobby']; ?></p>
                                                <p>コメント：<?php echo $employee_rec[$num]['empcomment']; ?></p>
                                            </div>
                                            <a href="./reservation_form.php?empid=<?= $employee_rec[$num]['empid'] ?>week=0"><span class="resv_txt">面談予約はこちら</span></a>
                                        </div>
                                        <div class="works_modal_close">✖</div>
                                    </div>
                                </div>
                                <!-- モーダルウインドウここまで -->
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="btn_list">
                <a href="./diagnose.php" class="white">もう一度診断する</a>
                <a href="./home.php" class="blue">ホームへ戻る</a>
            </div>
        <?php //} else { ?>
            <!-- <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div> -->
        <?php //} ?>
    </main>
<script src="../../js/modal.js"></script>
</body>
<html>