<?php
session_start();

include('../../conf/db_conf.php');
$weekJa = array("日", "月", "火", "水", "木", "金", "土");
for ($i = 0; $i < count($_GET['editFree']); $i++) {
    list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['editFree'][$i]);
    // timeフォーマット
    $time[$i] = substr_replace($time[$i], ':', 2, 0) . ":00";
}

// DBconnection
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

$sql = "SELECT id FROM rsvDB WHERE ";

$arySql1 = array();
for ($i = 0; $i < count($_GET['editFree']); $i++) {
    $arySql1[$i] = '(empid = :empid' . $i . ' AND rsvdate = :rsvdate' . $i . ' AND rsvtime = :rsvtime' . $i . ')';
}
$sql .= implode(' OR ', $arySql1);

//bind処理
$stmt = $dbh->prepare($sql);
for ($i = 0; $i < count($_GET['editFree']); $i++) {
    $stmt->bindValue(':empid' . $i, $empid[$i]);
    $stmt->bindValue(':rsvdate' . $i, date('Y') . '-' . str_replace('/', '-', $date[$i]));
    $stmt->bindValue(':rsvtime' . $i, $time[$i]);
}

$stmt->execute();
$deldata = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($deldata); $i++) {
    $delid[$i] = $deldata[$i]['id'];
}
$sql = "DELETE FROM rsvDB WHERE id IN (" . implode(',', $delid) . ")";
$stmt = $dbh->prepare($sql);
$stmt->execute();
?>

<h1>削除しました</h1>
<form action="./editFree_form.php" method="get">
    <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
    <input type="hidden" name="week" value="0">
    <input type="submit" value="追加で削除">
</form>
<form action="./registerFree_confirm.php" method="GET">
    <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
    <input type="hidden" name="week" value="0">
    <input type="submit" value="空き日程を登録">
</form>