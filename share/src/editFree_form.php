<link rel="stylesheet" href="../css/table.css">
<?php
session_start();

// 変数定義
include('../conf/config.php');
$empid = $_SESSION['eid'];
$week = $_GET['week'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

//DB接続
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
  }

// 社員リスト取得
$sql = "SELECT * FROM emp_table WHERE empid = :empid";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$employee = $stmt->fetch();

// 未予約情報取得
$sql = "SELECT * FROM rsvdb WHERE empid = :empid AND flag = 0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$unrsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 予約済み情報取得
$sql = "SELECT * FROM rsvdb WHERE empid = :empid AND flag = 1";
$stmt = $pdo->prepare($sql);
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