<link rel="stylesheet" href="css/table.css">

<?php
session_start();

// 変数定義
include('../conf/db_conf.php');
$empid = $_GET['empid'];
$week = $_GET['week'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

//DB接続
try {
    $options = array(
        // SQL実行失敗時には例外をスローしてくれる
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // カラム名をキーとする連想配列で取得する．これが一番ポピュラーな設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    $dbh = new PDO($dsn, $db_username, $db_password, $options);
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
$sql = "SELECT * FROM rsvDB WHERE empid = :empid AND flag = 0";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$unrsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 予約済み情報取得
$sql = "SELECT * FROM rsvDB WHERE empid = :empid AND flag = 1";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- 表示画面 -->
<h1>予約画面</h1>
<h2><?php echo $employee['empname']; ?></h2>
<img src="./images/<?php echo $employee['empimg_id']; ?>" alt="社員画像" height="300">
<p>年次：<?php echo $employee['empyear']; ?>年目</p>
<p>役職：<?php echo $employee['empjob']; ?></p>
<p>職種：<?php echo $employee['empcareer']; ?></p>
<p>趣味：<?php echo $employee['emphobby']; ?></p>

<h2>表から予約したい日程を選択してください</h2>

<!-- 表示週の変更ボタン -->
<?php
if ($week > 0) {
    echo '<a href="./reservation_form.php?empid=' . $empid . '&week=' . $week - 1 . '">前の1週間</a></br>';
} else {
    echo '<del>前の1週間</del></br>';
}
echo '<a href="./reservation_form.php?empid=' . $empid . '&week=' . $week + 1 .  '">次の1週間</a>';
?>

<!-- 予約表 -->
<form action="./reservation_confirm.php" method="POST">
    <table>
        <tr>
            <!-- 日程表示 -->
            <th></th>
            <?php for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++)
                print '<th>' . date('m/d', strtotime($i . 'day')) . '(' . $weekJa[date('w', strtotime(date('Y-m-d', strtotime($i . 'day'))))] . ')</th>';
            ?>
        </tr>
        <?php
        for ($time = 1000; $time <= 1600; $time += 100) {
            if ($time == 1200) {
                continue;
            }
            echo '<tr>
        <th>' . substr_replace($time, ':', 2, 0) . '〜</th>';
            for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) {
                $cnt = 0;
                // 未予約日程を表示
                for ($j = 0; $j < count($unrsvInfo); $j++) {
                    if ($unrsvInfo[$j]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($unrsvInfo[$j]['rsvtime'])) == $time) {
                        print '<td>
                <input type="radio" name="free" value="' . $empid . ':' .  $time . ':' . date('Y-m-d', strtotime($i . 'day')) . ':' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '" required>
                </td>';
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
    </table><br>
    相談内容：
    <input type="text" name="comment"><br><br>
    <input type="submit" value="予約確認画面へ">
</form>

<p>⚪︎：予約可能</p>
<p>x：他の学生が予約済み</p>
<p>-：予定が空いていません</p><br>

<input type="button" onclick="location.href='./home.php'" value="戻る">

<!-- for jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="./js/script.js"></script>