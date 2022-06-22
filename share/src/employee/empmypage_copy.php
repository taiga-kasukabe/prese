<!-- 未完成 -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>内々定者マイページ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/rsv_table.css">
    <link rel="stylesheet" href="../../css/popup_emp.css">
    <link rel="stylesheet" href="../../css/empmypage.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

include('../../conf/config.php');
if (empty($_GET['week'])) {
    $week = 0;
} else {
    $week = $_GET['week'];
}
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}


// SESSIONが切れてないか確認
if (!empty($_SESSION['eid'])) {
    $empid = $_SESSION['eid'];
    // 社員リスト取得
    $sql = "SELECT * FROM emp_table WHERE empid = :empid";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $employee = $stmt->fetch();

    // 予約情報取得
    $sql = "SELECT * FROM rsvdb WHERE (empid = :empid AND ((rsvdate >= :today) AND (flag = 1)) OR ((rsvdate >= :2daysAfter) AND (flag = 0))) ORDER BY rsvdate, rsvtime";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->bindValue(':today', date('Y-m-d'));
    $stmt->bindValue(':2daysAfter', date('Y-m-d',strtotime('+2day')));
    $stmt->execute();
    $rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 学生情報取得
$sql = "SELECT * FROM users_table";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stuInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
    </header>

    <?php if (!empty($_SESSION['eid'])) { ?>
        <main>
            <h1><?php echo $employee['empname']; ?> さん</h1>
            <h2><i class="fa-solid fa-clipboard-list"></i>予約可能日程一覧</h2>
            <?php if (!empty($rsvInfo)) { ?>
                <table>
                    <tr>
                        <th>日付</th>
                        <th>時間</th>
                        <th>予約状況</th>
                        <th>確認</th>
                    </tr>
                    <?php for ($i = 0; $i < count($rsvInfo); $i++) { ?>
                        <tr>
                            <?php print '<td>' . date('m/d', strtotime($rsvInfo[$i]['rsvdate'])) . '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($rsvInfo[$i]['rsvtime']))))] . ')' . '</td><td>' . date('H:i', strtotime($rsvInfo[$i]['rsvtime'])) . '〜' . date('H:i', strtotime($rsvInfo[$i]['rsvtime'] . " +1 hours")) . '</td><td>';
                            if ($rsvInfo[$i]['flag'] == 1) {
                                print '予約済み';
                            } else {
                                print '空き';
                            }
                            print '</td><td>'; ?>
                            <?php if ($rsvInfo[$i]['flag'] == 1) { ?>
                                <div class="works_modal_open" data-modal-open="modal-<?php echo $i; ?>">
                                    <button class="rsv_check">予約確認</button>
                                </div>
                            <?php } ?>
                            </td>
                        </tr>

                        <!-- モーダルウインドウここから -->
                        <div class="works_modal_wrapper" data-modal="modal-<?php echo $i; ?>">
                            <div class="works_modal_mask"></div>
                            <div class="works_modal_window">
                                <div class="works_modal_content">
                                    <p>学生情報</p>
                                    <p>名前：
                                        <?php for ($j = 0; $j < count($stuInfo); $j++) {
                                            if ($rsvInfo[$i]['stuid'] == $stuInfo[$j]['id']) {
                                                echo $stuInfo[$j]['username'];
                                                $num = $j;
                                            }
                                        } ?>さん</p>
                                    <p>大学情報：<?php echo $stuInfo[$num]['school'] . ' ' . $stuInfo[$num]['department1'] . ' ' . $stuInfo[$num]['department2'] . ' ' . $stuInfo[$num]['student_year']; ?></p>
                                    <p>相談内容：<?php echo $rsvInfo[$i]['comment']; ?></p>
                                    <p>メールアドレス：<span class="copy-text" data-mail="mail-<?php echo $i ?>" ><?php  echo $stuInfo[$num]['mail']; ?></span></p>
                                    <button class="copy-btn" data-mail-copy="mail-<?php echo $i ?>">メールアドレスをコピー</button>
                                </div>
                                <div class="works_modal_close">✖</div>
                            </div>
                        </div>
                        <!-- モーダルウインドウここまで -->
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p class="noRsvComment">現在登録している予約可能日程はありません</p>
            <?php } ?>

            <div class="btn_list">
                <form action="./registerFree_form.php" method="get">
                    <input type="hidden" name="week" value="0">
                    <button type="submit" class="schedule">追加</button>
                </form>
                <form action="./editFree_form.php" method="get">
                    <input type="hidden" name="week" value="0">
                    <button type="submit" class="schedule">削除</button>
                </form>
            </div>
            <script>
                
            </script>
        </main>
    <?php } else { ?>
        <main>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./emplogin_form.php" class="login">ログインページへ</a>
            </div>
        </main>
    <?php } ?>
    <script src="../../js/modal.js"></script>
    <script src="../../js/mailCopy.js"></script>
</body>

</html>