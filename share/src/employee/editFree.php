<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/editFree.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

include('../../conf/config.php');
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

if (!empty($_GET['editFree'])) {
    for ($i = 0; $i < count($_GET['editFree']); $i++) {
        list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['editFree'][$i]);
        // timeフォーマット
        $time[$i] = substr_replace($time[$i], ':', 2, 0) . ":00";
    }

    $sql = "SELECT id FROM rsvdb WHERE ";

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

    if (!empty($deldata)) {
        for ($i = 0; $i < count($deldata); $i++) {
            $delid[$i] = $deldata[$i]['id'];
        }
        $sql = "DELETE FROM rsvdb WHERE id IN (" . implode(',', $delid) . ")";
        $stmt = $dbh->prepare($sql);
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
        <?php if (!empty($_GET['editFree']) && !empty($_SESSION['eid'])) { ?>
            <div class="container">
                <h1>COMPLETE</h1>
                <div class="btn">
                    <form action="./editFree_form.php" method="get">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <input type="hidden" name="week" value="0">
                        <button type="submit" id="register">追加で削除する</button>
                    </form>
                    <form action="./empmypage.php" method="get">
                        <input type="hidden" name="week" value="0">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <button id="backHome" onclick="location.href='./empmypage.php'">ホームへ戻る</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <h1>セッションが切れました</h1>
            <h2>再ログインしてください</h2>
            <a href="./emplogin_form.php">ログイン</a>
        <?php } ?>
    </main>
</body>