<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/registerFree.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

include('../../conf/config.php');

$weekJa = array("日", "月", "火", "水", "木", "金", "土");

if (!empty($_GET['free'])) {
    for ($i = 0; $i < count($_GET['free']); $i++) {
        list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['free'][$i]);
    }


    //データベース接続
    try {
        $dbh = new PDO($dsn, $db_username, $db_password);
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

    //validation
    $sql = "SELECT * FROM rsvdb WHERE (empid, rsvdate, rsvtime) IN ";
    $arySql1_validation = [];
    //行の繰り返し
    for ($i = 0; $i < count($aryInsert); $i++) {
        $arySql2_validation = [];
        $arySql2_validation[] = ':empid' . $i;
        $arySql2_validation[] = ':rsvdate' . $i;
        $arySql2_validation[] = ':rsvtime' . $i;
        $arySql1_validation[] = '(' . implode(',', $arySql2_validation) . ')';
    }
    $sql .= '(' . implode(',', $arySql1_validation) . ')';

    //bind処理
    $stmt = $dbh->prepare($sql);
    foreach ($aryInsert as $key1_validation => $val1_validation) {
        $stmt->bindValue(':empid' . $key1_validation, $val1_validation['empid']);
        $stmt->bindValue(':rsvdate' . $key1_validation, $val1_validation['rsvdate']);
        $stmt->bindValue(':rsvtime' . $key1_validation, $val1_validation['rsvtime']);
    }
    $stmt->execute();
    $validation = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 重複日程がなければ登録
    if (empty($validation)) {
        // 登録動作
        $sql = "INSERT INTO rsvdb (" . implode(',', $aryColumn) . ") VALUES ";
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
    }
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
        <div class="container">
            <?php if (empty($validation) && !empty($_GET['free']) && !empty($_SESSION['eid'])) { ?>
                <h1>COMPLETE</h1>
                <div class="btn">
                    <form action="./registerFree_form.php" method="get">
                        <input type="hidden" name="week" value="0">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <button type="submit" id="register">追加で登録する</button>
                    </form>
                    <form action="./empmypage.php" method="get">
                        <input type="hidden" name="week" value="0">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <button id="backHome" onclick="location.href='./empmypage.php'">ホームへ戻る</button>
                    </form>
                </div>
            <?php } else { ?>
                <h1>ERROR</h1>
                <div class="text">
                    予期せぬエラーが発生しました。
                </div>
                <div class="btn">
                    <form action="./registerFree_form.php" method="GET">
                        <input type="hidden" name="week" value="0">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <button type="submit" id="register">再登録する</button>
                    </form>
                    <form action="./empmypage.php" method="GET">
                        <input type="hidden" name="week" value="0">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <button id="backHome" onclick="location.href='./empmypage.php'">ホームへ戻る</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </main>
</body>