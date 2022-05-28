<?php
session_start();

include('../conf/db_conf.php');
$weekJa = array("日", "月", "火", "水", "木", "金", "土");
for ($i = 0; $i < count($_GET['free']); $i++) {
    list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['free'][$i]);
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

// 複数行挿入
$aryInsert = [];
for ($i = 0; $i < count($_GET['free']); $i++) {
    $aryInsert[] = [
        'id' => NULL,
        'stuid' => '',
        'empid' => $empid[$i],
        'rsvdate' => date('Y') . '-' . str_replace('/', '-', $date[$i]),
        'rsvtime' => substr_replace($time[$i], ':', 2, 0) . ':00',
        'comment' => '',
        'flag' => '0'
    ];
}
// array_keyで配列インデックスキーを取得
$aryColumn = array_keys($aryInsert[0]);

$sql = "INSERT INTO rsvDB (" . implode(',', $aryColumn) . ") VALUES ";
$arySql1 = [];
//行の繰り返し
foreach ($aryInsert as $key1 => $val1) {
    $arySql2 = [];
    //列（カラム）の繰り返し
    foreach ($val1 as $key2 => $val2) {
        $arySql2[] = ':' . $key2 . $key1;
    }
    $arySql1[] = '(' . implode(',', $arySql2) . ')';
}

$sql .= implode(',', $arySql1);

//bind処理
$stmt = $dbh->prepare($sql);
foreach ($aryInsert as $key1 => $val1) {
    foreach ($val1 as $key2 => $val2) {
        $stmt->bindValue(':' . $key2 . $key1, $val2);
    }
}
$stmt->execute();
?>

<h1>登録しました</h1>
<form action="./registerFree_form.php" method="get">
    <input type="hidden" name="week" value="0">
    <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
    <input type="submit" value="追加登録">
</form>