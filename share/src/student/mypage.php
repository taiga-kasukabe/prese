<!--マイページ-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/student/mypage.css">
    <link rel="stylesheet" href="../../css/student/popup_rsvCancel.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();
//データベース情報の読み込み
include('../../conf/config.php');
$employee = array();
$temp = 0;
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

// SESSIONが切れてないか確認
if (!empty($_SESSION['id'])) {
    $id = $_SESSION['id'];
    //users_table接続
    // ログインしている学生のデータ取得
    $sql_user = "SELECT * FROM users_table WHERE id = :id";
    $stmt = $dbh->prepare($sql_user);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $member = $stmt->fetch();

    //rsvdb接続
    // rsvdbのデータを全て取得
    $sql_rsv = "SELECT * FROM rsvdb";
    $stmt = $dbh->prepare($sql_rsv);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // rsvdbのうちログインしている学生の予約データのみ取得
    $sql_rsv = "SELECT * FROM rsvdb WHERE stuid = '$id' AND rsvdate >= :today ORDER BY rsvdate, rsvtime";
    $stmt = $dbh->prepare($sql_rsv);
    $stmt->bindValue(':today', date('Y-m-d'));
    $stmt->execute();
    $stuid = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //empDB接続
    // rsvdbのうちログインしている学生が予約しているデータのempidを取得し，
    // それと一致するempidのデータをemp_tableから取得する
    $sql_emp = "SELECT * FROM emp_table WHERE empid in (SELECT empid FROM rsvdb WHERE stuid = '$id')";
    $stmt = $dbh->prepare($sql_emp);
    $stmt->execute();
    $employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //ename
    // emp_tableの情報をすべて取得する
    $sql_emp = "SELECT * FROM emp_table";
    $stmt = $dbh->prepare($sql_emp);
    $stmt->execute();
    $ename = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<body>
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
    </header>

    <main>
        <?php if (!empty($_SESSION['id'])) { ?>
            <div class="top">
                <h1><?php echo $member['username']; ?> さん</h1>
                <div class="link">
                    <a href="./reset_pass_form.php" class="link_top">パスワード再設定</a>
                    <a href="./withdrawal_form.php" class="link_top">退会</a>
                </div>
            </div>
            <div class="rsv_list">
                <h2>予約内容</h2>
                <?php if (!empty($stuid)) { ?>
                    <?php for ($n = 0; $n < count($stuid); $n++) { ?>
                        <div class="rsv_content">
                            <div class="rsv_text">
                                <?php for ($i = 0; $i < count($ename); $i++) {
                                    if ($stuid[$n]['empid'] == $ename[$i]['empid']) { ?>
                                        <p><span class="tag"><i class="fa-solid fa-user"></i>面談相手</span>&nbsp;&nbsp;<?php echo $ename[$i]['empname']; ?></p>
                                <?php }
                                } ?>

                                <?php $rsvtime = $stuid[$n]['rsvdate'] ?>
                                <p><span class="tag"><i class="fa-solid fa-clock"></i>予約日時</span>&nbsp;&nbsp;<?php echo date('m/d', strtotime($stuid[$n]['rsvdate'])) . '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($stuid[$n]['rsvdate']))))] . ')'; ?>&nbsp;&nbsp;&nbsp;<?php echo date('H:i', strtotime($stuid[$n]['rsvtime'])) . '〜' . date('H:i', strtotime($stuid[$n]['rsvtime'] . " +1 hours")); ?></p>
                                <div class="comment">
                                    <p class="comment_tag"><span class="tag"><i class="fa-solid fa-pen"></i>相談内容</span>&nbsp;&nbsp;</p>
                                    <p class="comment_data"><?php echo $stuid[$n]['comment']; ?></p>
                                </div>
                            </div>

                            <?php if ($rsvtime <= date('Y-m-d', strtotime("+2day"))) : ?>
                                <div class="not_cancel">
                                    <p>予約日2日前以降は予約の取り消しは出来ません。</p>
                                    <p>これ以降は直接連絡をお取りください。</p>
                                </div>
                            <?php else : ?>
                                <div class="delete_btn works_modal_open" data-modal-open="rsv-cancel-<?php echo $n; ?>">
                                    <button type="submit" class="delete">取消</button>
                                </div>

                                <!-- モーダルウインドウここから -->
                                <div class="works_modal_wrapper" data-modal="rsv-cancel-<?php echo $n; ?>">
                                    <div class="works_modal_mask"></div>
                                    <div class="works_modal_window">
                                        <div class="works_modal_content">
                                            <p>中身</p>
                                            <form action="./rsv_cancel.php" method="post" onSubmit="return check()">
                                                <input type="hidden" name="empid" value="<?= $stuid[$n]['empid'] ?>">
                                                <input type="hidden" name="rsvdate" value="<?= $stuid[$n]['rsvdate'] ?>">
                                                <input type="hidden" name="rsvtime" value="<?= $stuid[$n]['rsvtime'] ?>">
                                                <button type="submit" class="delete">取消</button>
                                            </form>
                                        </div>
                                        <div class="works_modal_close">✖</div>
                                    </div>
                                </div>
                                <!-- モーダルウインドウここまで -->

                            <?php endif; ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="rsv_content">
                        <p>現在予約している面談はありません</p>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        <?php } ?>
    </main>
<script type="text/javascript" src="../../js/loading.js"></script>  
</body>
</html>