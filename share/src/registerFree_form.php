<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>空き日程登録</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../css/registerFree_form.css">
    <link rel="stylesheet" href="../css/table.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

include('../conf/config.php');
$week = $_GET['week'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");
$empid = $_SESSION['eid'];

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
if (!empty($employee)) {
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
            <img src="../images/ntt-east_white.png" id="logo">
        </div>
        </script>
    </header>

    <main>
        <?php if (!empty($employee)) { ?>

            <h1><?php echo $employee['empname']; ?> さん</h1>
            <div class="container">
                <h2><i class="fa-regular fa-calendar-plus"></i>空き日程の登録</h2>

                <div class="table">
                    <!-- 表示週の変更ボタン -->
                    <div class="move_btn">
                        <?php
                        if (isset($employee)) {
                            if ($week > 0) {
                                echo '<a href="./registerFree_form.php?empid=' . $empid . '&week=' . $week - 1 . '" class="prev">前の1週間</a>';
                            } else {
                                echo '<a tabindex="-1" class="prev disabled_link">前の1週間</a>';
                            }
                            echo '<a href="./registerFree_form.php?empid=' . $empid . '&week=' . $week + 1 .  '" class="next">次の1週間</a>';
                        }
                        ?>
                    </div>

                    <!-- 予約表 -->
                    <form action="./registerFree_confirm.php" method="GET">
                        <table>
                            <tr>
                                <th id="none"></th>
                                <?php for ($i = $week * 7+2; $i < 7 * ($week + 1)+2; $i++)
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
                                for ($i =  $week * 7+2; $i < 7 * ($week + 1)+2; $i++) {
                                    $cnt = 0;
                                    // 未予約日程を表示
                                    for ($j = 0; $j < count($unrsvInfo); $j++) {
                                        if ($unrsvInfo[$j]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($unrsvInfo[$j]['rsvtime'])) == $time) {
                                            print '<td>-</td>';
                                            $cnt++;
                                        }
                                    }
                                    // 予約済み日程を表示
                                    for ($k = 0; $k < count($rsvInfo); $k++) {
                                        if ($rsvInfo[$k]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($rsvInfo[$k]['rsvtime'])) == $time) {
                                            print '<td>-</td>';
                                            $cnt++;
                                        }
                                    }
                                    if ($cnt > 0) {
                                        continue;
                                    }
                                    // checkboxで実装
                                    print '<td><label><input type="checkbox" name="free[]" id="checkbox" value="' . $empid . ':' .  $time . ':' . date('m/d', strtotime($i . 'day')) . ':' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '"><span></span></label></td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </table>
                        <p>-：既に空き日程として登録済み</p>
                        <button type="submit" class="register" id="submit_btn">確認する</button>
                    </form>
                </div>


                <form action="./empmypage.php" method="get">
                    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
                    <input type="hidden" name="week" value="<?php echo $week; ?>">
                    <button type="submit" class="backHome">予約一覧に戻る ＞</button>
                </form>
            </div>
        <?php } else { ?>
            <h1>存在しない社員IDです</h1>
        <?php } ?>
        <!-- <input type="button" onclick="location.href='./emplogin_form.php'" value="社員変更"> -->
    </main>
    <script src="../js/schedule_disabled.js"></script>
</body>