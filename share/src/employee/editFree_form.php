<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>空き日程削除</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/editFree_form.css">
    <link rel="stylesheet" href="../../css/table.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

// 変数定義
include('../../conf/config.php');
$week = $_GET['week'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

if (!empty($_SESSION['eid'])) {
    $empid = $_SESSION['eid'];
    // 社員リスト取得
    $sql = "SELECT * FROM emp_table WHERE empid = :empid";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $employee = $stmt->fetch();

    // 未予約情報取得
    $sql = "SELECT * FROM rsvdb WHERE empid = :empid AND flag = 0";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $unrsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 予約済み情報取得
    $sql = "SELECT * FROM rsvdb WHERE empid = :empid AND flag = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
        </script>
    </header>

    <main>
        <?php if (!empty($_SESSION['eid'])) { ?>
            <h1><?php echo $employee['empname']; ?> さん</h1>
            <div class="container">
                <h2><i class="fa-regular fa-calendar-xmark"></i>空き日程の削除</h2>

                <div class="table">
                    <!-- 表示週の変更ボタン -->
                    <div class="move_btn">
                        <?php
                        if ($week > 0) {
                            echo '<a href="./editFree_form.php?empid=' . $empid . '&week=' . $week - 1 . '#tab_free" class="prev">前の1週間</a>';
                        } else {
                            echo '<a tabindex="-1" class="prev disabled_link">前の1週間</del></br>';
                        }
                        echo '<a href="./editFree_form.php?empid=' . $empid . '&week=' . $week + 1 .  '#tab_free" class="next">次の1週間</a>';
                        ?>
                    </div>

                    <!-- 予約表 -->
                    <form action="./editFree_confirm.php" method="get">
                        <table id="tab_free">
                            <tr>
                                <!-- 日程表示 -->
                                <th id="none"></th>
                                <?php for ($i = $week * 7 + 2; $i < 7 * ($week + 1) + 2; $i++)
                                    print '<th class="date">' . date('m/d', strtotime($i . 'day')) . '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($i . 'day'))))] . ')</th>';
                                ?>
                            </tr>
                            <?php
                            for ($time = 1000; $time <= 1600; $time += 100) {
                                if ($time == 1200) {
                                    continue;
                                }
                                echo '<tr>
                <th class="time">' . substr_replace($time, ':', 2, 0) . '</th>';
                                for ($i = $week * 7 + 2; $i < 7 * ($week + 1) + 2; $i++) {
                                    $cnt = 0;
                                    // 未予約日程を表示
                                    for ($j = 0; $j < count($unrsvInfo); $j++) {
                                        if ($unrsvInfo[$j]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($unrsvInfo[$j]['rsvtime'])) == $time) {
                                            print '<td>
                                <label><input type="checkbox" name="editFree[]" id="checkbox" value="' . $empid . ':' .  $time . ':' . date('m/d', strtotime($i . 'day')) . ':' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '">
                                <span></span></label></td>';
                                            $cnt++;
                                        }
                                    }

                                    // 予約済み日程を表示
                                    for ($k = 0; $k < count($rsvInfo); $k++) {
                                        if ($rsvInfo[$k]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($rsvInfo[$k]['rsvtime'])) == $time) {
                                            print '<td>x</td>';
                                            $cnt++;
                                        }
                                    }
                                    if ($cnt > 0) {
                                        continue;
                                    }
                                    print '<td>-</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <p>x：既に予約が入ってしまいました</p>
                        <p>-：空き日程として登録されていません</p>
                        <button type="submit" class="register" id="submit_btn">確認する</button>
                    </form>

                    <form action="./empmypage.php" method="get">
                        <input type="hidden" name="empid" value="<?php echo $empid; ?>">
                        <input type="hidden" name="week" value="0">
                        <button type="submit" class="backHome">予約一覧に戻る ＞</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./emplogin_form.php" class="login">ログインページへ</a>
            </div>
        <?php } ?>
    </main>
    <script src="../../js/schedule_disabled.js"></script>
    <script src="../../js/browserBack.js"></script>
</body>