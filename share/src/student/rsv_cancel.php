<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>登録取り消し</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/rsv_cancel.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

if (!empty($_SESSION['id'])) {
    include("../../conf/config.php");
    try {
        $dbh = new PDO($dsn, $db_username, $db_password);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
    }

    $empid = $_POST['empid'];
    $rsvdate = $_POST['rsvdate'];
    $rsvtime = $_POST['rsvtime'];

    $id = $_SESSION['id'];
    $sql =  "UPDATE rsvdb SET stuid = '' ,comment = '' , flag = 0 WHERE stuid = :stuid AND empid = :empid AND rsvdate = :rsvdate AND rsvtime = :rsvtime";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':stuid', $id);
    $stmt->bindValue(':empid', $empid);
    $stmt->bindValue(':rsvdate', $rsvdate);
    $stmt->bindValue(':rsvtime', $rsvtime);
    $stmt->execute();
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
            <div class="container">
                <h1>予約をキャンセルしました</h1>
                <a href="./mypage.php" class="login">マイページへ</a>
            </div>
        <?php } else { ?>
            <div class="container">
                <p>セッションが切れました</p>
                <p>再ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        <?php } ?>
    </main>
</body>