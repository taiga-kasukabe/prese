<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>面談予約</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/reservation_form.css">
    <link rel="stylesheet" href="../../css/table_student.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

if (!empty($_SESSION['id'])) {
    // 変数定義
    include('../../conf/config.php');
    $empid = $_GET['empid'];
    $week = $_GET['week'];
    $weekJa = array("日", "月", "火", "水", "木", "金", "土");

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
            <a href="./home.php" id="home">ホーム</a>
        </div>
    </header>

    <main>
        <?php if (!empty($_SESSION['id'])) { ?>
            <div class="profile">
                <div class="emp_img">
                    <img src="../../images/<?php echo $employee['empimg_id']; ?>" alt="社員画像">
                </div>
                <div class="introduction">
                    <h2><?php echo $employee['empname']; ?></h2>
                    <p>年次：<?php echo $employee['empyear']; ?>年目</p>
                    <p>役職：<?php echo $employee['empjob']; ?></p>
                    <p>職種：<?php echo $employee['empcareer']; ?></p>
                    <p>趣味：<?php echo $employee['emphobby']; ?></p>
                    <p>コメント：<?php echo $employee['empcomment']; ?></p><br>
                </div>
            </div>

            <div class="container">
                <h2 class="choose_comment"><i class="fa-solid fa-circle-arrow-down"></i>表から予約したい日程を選択してください</h2>
                <div class="table">
                    <!-- 表示週の変更ボタン -->
                    <div class="move_btn">
                        <?php
                        if ($week > 0) {
                            echo '<a href="./reservation_form.php?empid=' . $empid . '&week=' . $week - 1 . '#tab_rsv" class="prev">前の1週間</a>';
                        } else {
                            echo '<a tabindex="-1" class="prev disabled_link">前の1週間</a>';
                        }
                        echo '<a href="./reservation_form.php?empid=' . $empid . '&week=' . $week + 1 .  '#tab_rsv" class="next">次の1週間</a>';
                        ?>
                    </div>

                    <!-- 予約表 -->
                    <form action="./reservation_confirm.php" method="POST" id="reservation">
                        <table id="tab_rsv">
                            <tr>
                                <!-- 日程表示 -->
                                <th></th>
                                <?php for ($i = 2 + $week * 7; $i <= 7 * ($week + 1) + 1; $i++)
                                    print '<th class="date">' . date('m/d', strtotime($i . 'day')) . '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($i . 'day'))))] . ')</th>';
                                ?>
                            </tr>
                            <?php
                            for ($time = 1000; $time <= 1600; $time += 100) {
                                if ($time == 1200) {
                                    continue;
                                }
                                echo '<tr>
                            <th class="time">' . substr_replace($time, ':', 2, 0) . '〜</th>';
                                for ($i = 2 + $week * 7; $i <= 7 * ($week + 1) + 1; $i++) {
                                    $cnt = 0;
                                    // 未予約日程を表示
                                    for ($j = 0; $j < count($unrsvInfo); $j++) {
                                        if ($unrsvInfo[$j]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($unrsvInfo[$j]['rsvtime'])) == $time) {
                                            print '<td>
                                    <label><input type="radio" id="checkbox" name="free" value="' . $empid . ':' .  $time . ':' . date('Y-m-d', strtotime($i . 'day')) . ':' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '" required>
                                    <span></span></label></td>';
                                            // print '<td><a href="./reservation_comment.php?empid=' . $empid . '&time=' . $time . '&date=' . date('Y-m-d', strtotime($i . 'day')) . '&weekJa=' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '">◉</a></td>';

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
                        <div class="usage_guide">
                            <p>□：予約可能&nbsp;&nbsp;&nbsp;&nbsp;x：他の学生が予約済み&nbsp;&nbsp;&nbsp;&nbsp;-：予定が空いていません</p>
                        </div>
                        <div class="topic">
                            <label>相談内容</label>
                            <textarea name="comment" placeholder="こんなこと書いてね的な文章"></textarea>
                        </div>
                    </form>
                    <div class="btn">
                        <button onclick="location.href='./home.php'">戻る</button>
                        <button type="submit" id="submit_btn" form="reservation">予約確認画面へ</button>
                    </div>
                </div>
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
    <script src="../../js/schedule_disabled.js"></script>
</body>