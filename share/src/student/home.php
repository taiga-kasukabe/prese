<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">
    <!-- ページのタイトルをtestに設定 -->
    <title>ホーム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/popup.css">
    <link rel="stylesheet" href="../../css/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

//データベース情報の読み込み
include('../../conf/config.php');


//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];

    //ユーザー情報の取得
    $sql_user = "SELECT * FROM users_table WHERE id = :id";
    $stmt = $dbh->prepare($sql_user);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $member = $stmt->fetch();

    //社員情報（全体）の取得
    $sql_emp = "SELECT * FROM emp_table";
    $stmt = $dbh->prepare($sql_emp);
    $stmt->execute();
    $employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 前回の診断結果を取得，変数に代入
    $academichistory = $member['academichistory'];
    $industry = $member['industry'];
    $skill = $member['skill'];    

    // 社員情報（おすすめ）の取得
    // if (!empty($gender)) {
    //     // （1）emptag2かemptag3に選択されたjobが含まれている（2）emptag1の性別と一致（3）年次が選択された範囲内
    //     $sql_emp = "SELECT * FROM emp_table WHERE ((emptag2 IN ($job_str)) OR (emptag3 IN ($job_str))) AND (emptag1 = :gender) AND (empyear >= :year_from AND empyear <= :year_to)";
    //     $stmt = $dbh->prepare($sql_emp);
    //     $stmt->bindValue(':gender', $gender);
    //     $stmt->bindValue(':year_from', $year_from);
    //     $stmt->bindValue(':year_to', $year_to);
    //     $stmt->execute();
    //     $employee_rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}
?>

<body>
    <?php if (!empty($_SESSION['id'])) { ?>
        <header>
            <div class="bg">
                <a href="./mypage.php" id="mypage">マイページ</a>
                <img src="../../images/ntt-east_white.png" id="logo">
            </div>
            <script>
                window.addEventListener("scroll", function() {
                    // ヘッダーを変数の中に格納する
                    const header = document.querySelector("header");
                    // 100px以上スクロールしたらヘッダーに「scroll-nav」クラスをつける
                    header.classList.toggle("scroll-nav", window.scrollY > 100);
                });
            </script>
        </header>

        <div class="headImg">
            <p>MEETING</p>
            <img src="../../images/hito.jpg">
        </div>

        <main>
            <!-- 簡易診断へのリンク -->
            <br>
            <a href="./diagnose.php" class="btn">
                <span class="btn_text">おすすめの社員を診断する</span>
            </a>

            <!-- おすすめの社員の表示 -->
            <?php if (!empty($employee_rec)) { ?>
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
                                <p><?php echo $employee[$num]['empname_eng']; ?></p>
                            </div>
                        </div>

                        <!-- モーダルウインドウここから -->
                        <div class="works_modal_wrapper" data-modal="rec-modal-<?php echo $num; ?>">
                            <div class="works_modal_mask"></div>
                            <div class="works_modal_window">
                                <div class="works_modal_content">
                                <div class="empimg_modal">
                                        <img src="../../images/<?php echo $employee_rec[$num]['empimg_id']; ?>">
                                    </div>
                                    <div class="introduction">
                                        <h1><?php echo $employee_rec[$num]['empname']; ?></h1>
                                        <div class="data_line">
                                            <div class="data_tag"><p>所属：</p></div>
                                            <div class="data_text">
                                                <p><?php echo $employee_rec[$num]['empuniv'] . "&nbsp;&nbsp;", $employee_rec[$num]['empfac']. "&nbsp;&nbsp;", $employee_rec[$num]['empdept']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag"><p>見ていた業界：</p></div>
                                            <div class="data_text">
                                                <p><?php echo $employee_rec[$num]['empindustry']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag"><p>趣味：</p></div>
                                            <div class="data_text">
                                                <p><?php echo $employee_rec[$num]['emphobby']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="./reservation_form.php?empid=<?= $employee_rec[$num]['empid'] ?>&week=0"><span class="resv_txt">面談予約はこちら</span></a>
                                <div class="works_modal_close">✖</div>
                            </div>
                        </div>
                        <!-- モーダルウインドウここまで -->
                    <?php } ?>
                <?php } ?>
                </div>


                <p class="section_title">EMPLOYEE LIST</p>
                <!-- ループで取得した社員情報を全て表示 -->
                <div class="list">
                    <?php for ($num = 0; $num < count($employee); $num++) { ?>

                        <!-- リストの名前部分をモーダル表示のボタンに -->
                        <div class="works_modal_open" data-modal-open="modal-<?php echo $num; ?>">
                            <div class="emp_img" style="background-image: url(../../images/<?php echo $employee[$num]['empimg_id']; ?>);background-size:cover;">
                            </div>
                            <div class="arrow">→</div>
                            <div class="emp_data">
                                <h2><?php echo $employee[$num]['empname']; ?></h2>
                                <p><?php echo $employee[$num]['empname_eng']; ?></p>
                            </div>
                        </div>

                        <!-- モーダルウインドウここから -->
                        <div class="works_modal_wrapper" data-modal="modal-<?php echo $num; ?>">
                            <div class="works_modal_mask"></div>
                            <div class="works_modal_window">
                                <div class="works_modal_content">
                                    <div class="empimg_modal">
                                        <img src="../../images/<?php echo $employee[$num]['empimg_id']; ?>">
                                    </div>
                                    <div class="introduction">
                                        <h1><?php echo $employee[$num]['empname']; ?></h1>
                                        <div class="data_line">
                                            <div class="data_tag"><p>所属：</p></div>
                                            <div class="data_text">
                                                <p><?php echo $employee[$num]['empuniv'] . "&nbsp;&nbsp;", $employee[$num]['empfac']. "&nbsp;&nbsp;", $employee[$num]['empdept']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag"><p>見ていた業界：</p></div>
                                            <div class="data_text">
                                                <p><?php echo $employee[$num]['empindustry']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag"><p>趣味：</p></div>
                                            <div class="data_text">
                                                <p><?php echo $employee[$num]['emphobby']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="./reservation_form.php?empid=<?= $employee[$num]['empid'] ?>&week=0"><span class="resv_txt">面談予約はこちら</span></a>
                                <div class="works_modal_close">✖</div>
                            </div>
                        </div>
                        <!-- モーダルウインドウここまで -->

                    <?php } ?>
                </div>

                <script src="../../js/modal.js"></script>
        </main>
    <?php } else { ?>
        <header class="blue_header">
            <div class="bg">
                <a href="./mypage.php" id="mypage">マイページ</a>
                <img src="../../images/ntt-east_white.png" id="logo">
            </div>
        </header>

        <main class="session">
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        </main>
    <?php } ?>
</body>

</html>