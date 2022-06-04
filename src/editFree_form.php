<link rel="stylesheet" href="../css/table.css">
<?php
session_start();

// 変数定義
include('../../conf/db_conf.php');
$empid = $_SESSION['eid'];
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
$sql = "SELECT * FROM empDB WHERE empid = :empid";
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

<h1>こんにちは，<?php echo $employee['empname']; ?>さん</h1>
<h2>空き日程編集画面です<br>削除したい空き日程を登録してください</h2>
<!-- 表示週の変更ボタン -->
<?php
if ($week > 0) {
    echo '<a href="./editFree_form.php?empid=' . $empid . '&week=' . $week - 1 . '">前の1週間</a></br>';
} else {
    echo '<del>前の1週間</del></br>';
}
echo '<a href="./editFree_form.php?empid=' . $empid . '&week=' . $week + 1 .  '">次の1週間</a>';
?>

<!-- 予約表 -->
<form action="./editFree_confirm.php" method="get">
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
        <th>' . substr_replace($time, ':', 2, 0) . '</th>';
            for ($i = 1 + $week * 7; $i <= 7 * ($week + 1); $i++) {
                $cnt = 0;
                // 未予約日程を表示
                for ($j = 0; $j < count($unrsvInfo); $j++) {
                    if ($unrsvInfo[$j]['rsvdate'] == date('Y-m-d', strtotime($i . 'day')) && date('Hi', strtotime($unrsvInfo[$j]['rsvtime'])) == $time) {
                        print '<td>
                        <input type="checkbox" name="editFree[]" value="' . $empid . ':' .  $time . ':' . date('m/d', strtotime($i . 'day')) . ':' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '">
                    </td>';
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
    <input type="submit" value="確認">
</form>
<p>x：既に予約が入ってしまいました<br>-：空き日程として登録されていません</p>

<form action="./registerFree_form.php" method="get">
    <input type="hidden" name="empid" value="<?php echo $empid; ?>">
    <input type="hidden" name="week" value="0">
    <input type="submit" value="空き日程登録へ">
</form>