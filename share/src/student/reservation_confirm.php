<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>予約確認</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/student/reservation_confirm.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

if (!empty($_SESSION['id'])) {
    // 変数定義
    include('../../conf/config.php');
    $comment = $_POST['comment'];
    $weekJa = array("日", "月", "火", "水", "木", "金", "土");
    list($empid, $time, $reservation_date, $weekNum) = explode(":", $_POST['free']);


    //データベース接続
    try {
        $dbh = new PDO($dsn, $db_username, $db_password);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
    }

    // 社員リスト取得
    $sql = "SELECT * FROM emp_table WHERE empid = :empid";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $employee = $stmt->fetch();
}
?>

<body>
    <header>
        <div class="header_container">
            <div class="logo">
                <img src="../../images/ntt-east_white.png" id="logo">
            </div>
        </div>
    </header>

    <main>
        <?php if (!empty($_SESSION['id'])) { ?>
            <!-- 社員情報 -->
            <div class="profile">
                <div class="emp_img">
                    <img src="../../images/<?php echo $employee['empimg_id']; ?>" alt="社員画像">
                </div>
                <div class="introduction">
                    <h2><?php echo $employee['empname']; ?></h2>
                    <p><i class="fa-solid fa-location-dot"></i><?php echo $employee['empplace']; ?>&emsp;&emsp;<i class="fa-solid fa-graduation-cap"></i><?php echo $employee['empuniv'] . "&nbsp;&nbsp;", $employee['empfac'] . "&nbsp;&nbsp;", $employee['empdept']; ?></p>
                    <div class="data_line">
                        <div class="data_tag">
                            <p>ゼミ・研究内容</p>
                        </div>
                        <div class="data_text">
                            <p><?php echo $employee['empresearch']; ?></p>
                        </div>
                    </div>
                    <div class="data_line">
                        <div class="data_tag">
                            <p>見ていた業界</p>
                        </div>
                        <div class="data_text">
                            <p><?php echo $employee['empindustry']; ?></p>
                        </div>
                    </div>
                    <div class="data_line">
                        <div class="data_tag">
                            <p>就活サポートスキル</p>
                        </div>
                        <div class="data_text">
                            <p><?php echo $employee['empskill']; ?></p>
                        </div>
                    </div>
                    <div class="data_line">
                        <div class="data_tag">
                            <p>趣味</p>
                        </div>
                        <div class="data_text">
                            <p><?php echo $employee['emphobby']; ?></p>
                        </div>
                    </div>
                    <div class="data_line">
                        <div class="data_tag">
                            <p>アピールポイント</p>
                        </div>
                        <div class="data_text">
                            <p><?php echo $employee['empapeal']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rsv_list">
                <h2>予約内容</h2>
                <div class="rsv_content">
                    <div class="rsv_text">
                        <!-- <p><span class="tag"><i class="fa-solid fa-user"></i>面談相手</span>&nbsp;&nbsp;<?php echo $employee['empname']; ?></p> -->
                        <!-- <?php //$rsvtime = $stuid[$n]['rsvdate'] 
                                ?> -->
                        <p><span class="tag"><i class="fa-solid fa-clock"></i>予約日時</span>&nbsp;&nbsp;<?php echo date('m/d', strtotime($reservation_date)) . '(' . $weekJa[$weekNum] . ')'; ?>&nbsp;&nbsp;&nbsp;<?php echo substr_replace($time, ':', 2, 0); ?></p>
                        <div class="comment">
                            <p class="comment_tag"><span class="tag"><i class="fa-solid fa-pen"></i>相談内容</span></p>
                            <p class="comment_data"><?php if (!empty($comment)) {
                                                        echo $comment;
                                                    } else {
                                                        echo "特になし";
                                                    } ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn">
                <form action="./reservation_form.php" method="GET">
                    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
                    <input type="hidden" name="week" value="0">
                    <button type="submit" id="page_back">戻る</button>
                </form>

                <form action="./reservation.php" method="GET">
                    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
                    <input type="hidden" name="time" value="<?php echo $time; ?>">
                    <input type="hidden" name="date" value="<?php echo $reservation_date ?>">
                    <input type="hidden" name="weekNum" value="<?php echo $weekNum; ?>">
                    <input type="hidden" name="comment" value="<?php echo $comment; ?>">
                    <button type="submit" id="reserve">予約</button>
                </form>
            </div>
        <?php } else { ?>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        <?php } ?>
    </main>
    <!-- for jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/browserBack.js"></script>
</body>