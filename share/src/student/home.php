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
    <link rel="stylesheet" href="../../css/student/popup.css">
    <link rel="stylesheet" href="../../css/student/home.css">
    <link rel="stylesheet" href="../../css/student/loading.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>


<body>
    <div id="loading">
    <div class="spinner"></div>
    </div>

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


        // 社員情報（おすすめ）の取得
        if (!empty($member['academichistory'])) {
            // 前回の診断結果を取得，変数に代入
            $academichistory_str = "'" . $member['academichistory'] . "'";
            $industry_str = "'" . $member['industry'] . "'";
            $skill_str = "'" . $member['skill'] . "'";
            // データベース検索
            $sql_emp = "SELECT * FROM emp_table WHERE (empacademichistory REGEXP ($academichistory_str)) AND (empindustry REGEXP ($industry_str)) AND (empskill REGEXP ($skill_str))";
            $stmt = $dbh->prepare($sql_emp);
            // $stmt->bindValue(':academichistory', $academichistory_str);
            // $stmt->bindValue(':industry', $industry_str);
            // $stmt->bindValue(':skill', $skill_str);
            $stmt->execute();
            $employee_rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    ?>

    <?php if (!empty($_SESSION['id'])) { ?>
        <header>
            <div class="header_container">
                <div class="logo">
                    <img src="../../images/ntt-east_white.png" id="logo">
                </div>
                <div class="navbtn">
                    <nav>
                        <ul class="header_nav">
                            <li><a href="./home.php">HOME</a></li>
                            <li><a href="./mypage.php">MY PAGE</a></li>
                            <li><a href="./logout.php">LOGOUT</a></li>
                        </ul>
                    </nav>
                </div>
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
                <span class="btn_text">おすすめの内々定者を診断する</span>
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
                                <p><?php echo $employee_rec[$num]['empname_eng']; ?></p>
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
                                        <p><i class="fa-solid fa-location-dot"></i><?php echo $employee_rec[$num]['empplace']; ?>&emsp;&emsp;<i class="fa-solid fa-graduation-cap"></i><?php echo $employee_rec[$num]['empuniv'] . "&nbsp;&nbsp;",$employee_rec[$num]['empfac'] . "&nbsp;&nbsp;",$employee_rec[$num]['empdept']; ?></p>
                                        <div class="data_line">
                                            <div class="data_tag">
                                                <p>見ていた業界</p>
                                            </div>
                                            <div class="data_text">
                                                <p><?php echo $employee_rec[$num]['empindustry']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag">
                                                <p>就活サポートスキル</p>
                                            </div>
                                            <div class="data_text">
                                                <p><?php echo $employee[$num]['empskill']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag">
                                                <p>趣味</p>
                                            </div>
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
                                        <p><i class="fa-solid fa-location-dot"></i><?php echo $employee[$num]['empplace']; ?>&emsp;&emsp;<i class="fa-solid fa-graduation-cap"></i><?php echo $employee[$num]['empuniv'] . "&nbsp;&nbsp;",$employee[$num]['empfac'] . "&nbsp;&nbsp;",$employee[$num]['empdept']; ?></p>
                                        <div class="data_line">
                                            <div class="data_tag">
                                                <p>見ていた業界</p>
                                            </div>
                                            <div class="data_text">
                                                <p><?php echo $employee[$num]['empindustry']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag">
                                                <p>就活サポートスキル</p>
                                            </div>
                                            <div class="data_text">
                                                <p><?php echo $employee[$num]['empskill']; ?></p>
                                            </div>
                                        </div>
                                        <div class="data_line">
                                            <div class="data_tag">
                                                <p>趣味</p>
                                            </div>
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
            <div class="header_container">
                <div class="logo">
                    <img src="../../images/ntt-east_white.png" id="logo">
                </div>
                <div class="navbtn">
                    <nav>
                        <ul class="header_nav">
                            <li><a href="./home.php">HOME</a></li>
                            <li><a href="./mypage.php">MY PAGE</a></li>
                            <li><a href="./logout.php">LOGOUT</a></li>
                        </ul>
                    </nav>
                </div>
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
<script type="text/javascript" src="../../js/loading.js"></script>  
</body>

</html>