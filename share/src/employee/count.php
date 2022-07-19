<!-- 未完成 -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>内々定者面談歴一覧</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/rsv_table.css">
    <link rel="stylesheet" href="../../css/popup_emp.css">
    <link rel="stylesheet" href="../../css/empmypage.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

include('../../conf/config.php');

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}


// SESSIONが切れてないか確認
if (!empty($_SESSION['empid'])) {
    $empid = $_SESSION['empid'];
    // 社員リスト取得
    $sql = "SELECT * FROM emp_table WHERE empid = :empid";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $employee = $stmt->fetch();

    // 予約情報取得
    $sql = "SELECT * FROM rsvdb WHERE (empid = :empid AND ((rsvdate >= :today) AND (flag = 1)) OR (empid = :empid AND (rsvdate >= :2daysAfter) AND (flag = 0))) ORDER BY rsvdate, rsvtime";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->bindValue(':today', date('Y-m-d'));
    $stmt->bindValue(':2daysAfter', date('Y-m-d', strtotime('+2day')));
    $stmt->execute();
    $rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 学生情報取得
$sql = "SELECT * FROM users_table";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stuInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <header>
        <div class="header_container">
            <div class="logo">
                <img src="../../images/ntt-east_white.png" id="logo">
            </div>
            <div class="navbtn">
                <nav>
                    <ul class="header_nav">
                        <li><a href="./empmypage.php">MY PAGE</a></li>
                        <li><a href="./emplogout.php">LOGOUT</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <?php if (!empty($_SESSION['empid'])) { ?>
        <main>
            <div class="top">
                <h1><?php echo $employee['empname']; ?> さん</h1>
                <div class="link">
                    <a href="./reset_pass_form.php" class="link_top">パスワード再設定</a>
                </div>
            </div>

            <h2>面談履歴</h2>
            <table>
                <tr>
                    <td>
                        社員名
                    </td>
                    <td>
                        面談回数
                    </td>
                </tr>
                <tr>
                    <td>
                        hogeさん
                    </td>
                    <td>
                        xx回
                    </td>
                </tr>
            </table>

        </main>
    <?php } else { ?>
        <main>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./emplogin_form.php" class="login">ログインページへ</a>
            </div>
        </main>
    <?php } ?>
</body>

</html>