<!-- 未完成 -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>内々定者マイページ</title>
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/popup_emp.css">
</head>

<?php
session_start();

include('../conf/config.php');
if (empty($_GET['week'])) {
    $week = 0;
} else {
    $week = $_GET['week'];
}
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

// 予約情報取得
$sql = "SELECT * FROM rsvdb WHERE empid = :empid ORDER BY rsvdate, rsvtime";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 学生情報取得
$sql = "SELECT * FROM users_table";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stuInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<PRE>";
var_dump($stuInfo);
echo "</PRE>";
?>

<body>
    <h1><?php echo $employee['empname']; ?>さんの予約確認ページ</h1>
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
                <div class="works_modal_open" data-modal-open="modal-<?php echo $i; ?>">
                    <input type="button" value="予約確認">
                </div>
                </td>
            </tr>

            <!-- モーダルウインドウここから -->
            <div class="works_modal_wrapper" data-modal="modal-<?php echo $i; ?>">
                <div class="works_modal_mask"></div>
                <div class="works_modal_window">
                    <div class="works_modal_content">
                        <p>学生情報</p>
                        <p>名前：
                            <?php for($j = 0; $j < count($stuInfo); $j++)  {
                                if($rsvInfo[$i]['stuid'] == $stuInfo[$j]['id']){
                                    
                                }
                            }            ?></p>
                        <p>相談内容：<?php echo $rsvInfo[$i]['comment']; ?></p>
                    </div>
                    <div class="works_modal_close">✖</div>
                </div>
            </div>
            <!-- モーダルウインドウここまで -->

        <?php } ?>
    </table>

    <form action="./registerFree_form.php" method="get">
        <input type="hidden" name="week" value="0">
        <input type="submit" value="追加">
    </form>

    <form action="./editFree_form.php" method="get">
        <input type="hidden" name="week" value="0">
        <input type="submit" value="削除">
    </form>

    <script src="../js/modal.js"></script>
</body>

</html>