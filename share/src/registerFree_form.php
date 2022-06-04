<link rel="stylesheet" href="../css/table.css">

<?php
session_start();

include('../conf/config.php');
$week = $_GET['week'];
$weekJa = array("日", "月", "火", "水", "木", "金", "土");
$empid = $_SESSION['eid'];

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
if (!empty($employee)) {
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
}
?>

<?php if (!empty($employee)) { ?>
    <h1>こんにちは，<?php echo $employee['empname']; ?>さん</h1>
    <h2>空き日程を登録してください</h2>
    <!-- 表示週の変更ボタン -->
    <?php
    if (isset($employee)) {
        if ($week > 0) {
            echo '<a href="./registerFree_form.php?empid=' . $empid . '&week=' . $week - 1 . '">前の1週間</a></br>';
        } else {
            echo '<del>前の1週間</del></br>';
        }
        echo '<a href="./registerFree_form.php?empid=' . $empid . '&week=' . $week + 1 .  '">次の1週間</a>';
    }
    ?>

    <!-- 予約表 -->
    <form action="./registerFree_confirm.php" method="GET">
        <table>
            <tr>
                <th>時間(時)</th>
                <?php for ($i = $week * 7; $i < 7 * ($week + 1); $i++)
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
                for ($i =  $week * 7; $i < 7 * ($week + 1); $i++) {
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
                    print '<td><input type="checkbox" name="free[]" value="' . $empid . ':' .  $time . ':' . date('m/d', strtotime($i . 'day')) . ':' . date('w', strtotime(date('Y-m-d', strtotime($i . 'day')))) . '"></td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <input type="submit" value="空き日程を登録">
    </form>
    <p>-：既に空き日程として登録済み</p>

    <form action="./editFree_form.php" method="get">
        <input type="hidden" name="empid" value="<?php echo $empid; ?>">
        <input type="hidden" name="week" value="<?php echo $week; ?>">
        <input type="submit" value="空き日程の編集へ">
    </form>
<?php } else { ?>
    <h1>存在しない社員IDです</h1>
<?php } ?>
<input type="button" onclick="location.href='./emplogin_form.php'" value="社員変更">