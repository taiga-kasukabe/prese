<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>予約完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/reservation.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

if (!empty($_SESSION['id'])) {

    // 変数定義
    include('../../conf/config.php');
    $empid = $_GET['empid'];
    $time =  substr_replace($_GET['time'], ':', 2, 0) . ':00';
    $reservation_date =  $_GET['date'];
    $weekNum = $_GET['weekNum'];
    $weekJa = array("日", "月", "火", "水", "木", "金", "土");
    $comment = $_GET['comment'];

    //データベース接続
    try {
        $dbh = new PDO($dsn, $db_username, $db_password);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
    }


    // 該当予約情報取得
    $sql = "SELECT * FROM rsvdb WHERE empid = :empid AND rsvdate = :rsvdate AND rsvtime = :rsvtime";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->bindValue(':rsvdate', $reservation_date);
    $stmt->bindValue(':rsvtime', $time);
    $stmt->execute();
    $unrsvInfo = $stmt->fetch();

    // 予約動作
    if ($unrsvInfo['flag'] != 1 || !empty($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $sql = "UPDATE rsvdb SET stuid = :stuid, comment = :comment, flag = 1 WHERE rsvDB. id=:id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':stuid', $id);
        $stmt->bindValue(':comment', $comment);
        $stmt->bindValue(':id', $unrsvInfo['id']);
        $stmt->execute();
    }
}?>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
            <a href="./home.php" id="home">ホーム</a>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (!empty($unrsvInfo) && $unrsvInfo['flag'] != 1 && !empty($_SESSION['id'])) { ?>
                <h1>予約が完了しました</h1>
                <div class="comment">
                    <p>内々定者から１日以内にご登録のメールアドレスに連絡します。</p>
                </div>
                <div class="btn">
                    <button onclick="location.href='./mypage.php'">予約確認（マイページへ）</button>
                    <button onclick="location.href='./home.php'">ホームへ</button>
                </div>
            <?php } elseif (!empty($_SESSION['id'])) { ?>
                <h1>予期せぬエラーが発生しました</h1>
                <div class="comment">
                    <p>・同時に他の方が予約したかもしれません</p>
                    <p>・内々定者の方に予定が入ったかもしれません</p>
                    <p>・ブラウザの戻るボタンを押したかもしれません</p>
                </div>
                <div class="btn">
                    <button onclick="location.href='./mypage.php'">予約確認（マイページへ）</button>
                    <button onclick="location.href='./home.php'">ホームへ</button>
                </div>
            <?php } else { ?>
            <div class="container">
               <p>セッションが切れました</p>
              <p>ログインしてください</p>
               <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
            <?php } ?>
        </div>
    </main>
    <script type="text/javascript" src="../../js/browserBack.js"></script>
</body>