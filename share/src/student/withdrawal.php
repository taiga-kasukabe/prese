<!--退会-->
<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">
    <!-- ページのタイトルをtestに設定 -->
    <title>ホーム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/student/withdrawal.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header_container">
            <div class="logo">
                <img src="../../images/ntt-east_white.png" id="logo">
            </div>
        </div>
    </header>

    <?php
    session_start();
    //データベース情報の読み込み
    include('../../conf/config.php');
    $employee = array();
    $temp = 0;

    //データベースへ接続、テーブルがない場合は作成
    try {
        $dbh = new PDO($dsn, $db_username, $db_password);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
    }

    if (!empty($_SESSION['id'])) {
        $id = $_SESSION['id'];
        // 当該学生の予約情報を全て未予約に変更
        $sql = "SELECT * FROM rsvdb WHERE stuid = :stuid";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':stuid', $id);
        $stmt->execute();
        $rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $updateID = array();
        if (!empty($rsvInfo)) {
            for ($i = 0; $i < count($rsvInfo); $i++) {
                $updateID[$i] = $rsvInfo[$i]['id'];
            }
            $sql = "UPDATE rsvdb SET stuid='', flag=0, comment='' WHERE id IN (" . implode(',', $updateID) . ")";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
        }

        // 学生アカウントの削除
        $sql =  "DELETE FROM users_table WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        session_destroy();
    ?>

        <main>
            <div class="container"> 
                <h2>退会しました</h2>
                <p>ご利用いただきありがとうございました。</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        </main>
    <?php } else { ?>
        <main>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        </main>
    <?php } ?>
</body>
</html>