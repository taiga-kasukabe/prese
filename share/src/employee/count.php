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
    // 当該社員リスト取得
    $sql = "SELECT * FROM emp_table WHERE empid = :empid";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':empid', $empid);
    $stmt->execute();
    $employee = $stmt->fetch();

    // 全社員リスト取得
    $sql = "SELECT empid, empname FROM emp_table";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $empAll = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 予約情報取得
    $sql = "SELECT * FROM rsvdb WHERE ((rsvdate < :today) AND (flag = 1)) ";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':today', date('Y-m-d'));
    $stmt->execute();
    $rsvInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ーー予約回数計算ーー
    // 配列用意
    for ($j = 0; $j < count($empAll); $j++) {
        $empAll[$j] += array('cnt' => 0);
    }
    // 予約回数計算
    for ($j = 0; $j < count($rsvInfo); $j++) {
        for ($k = 0; $k < count($empAll); $k++) {
            if ($rsvInfo[$j]['empid'] == $empAll[$k]['empid']) {
                $empAll[$k]['cnt']++;
            }
        }
    }
    // 最大面談予約回数計算
    $max = 0;
    for ($i = 0; $i < count($empAll); $i++) {
        if ($empAll[$i]['cnt'] > $max) {
            $max = $empAll[$i]['cnt'];
        }
    }
}
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

            <h2>各社員累計面談回数</h2>
            <table>
                <tr>
                    <td>
                        社員名
                    </td>
                    <td>
                        累計面談回数
                    </td>
                </tr>
                <?php for ($i = 0; $i < count($empAll); $i++) {
                    if ($_SESSION['empid'] == $empAll[$i]['empid']) { //自分を緑色
                        echo '<tr style="color:#009f8c">
                            <td>' . $empAll[$i]['empname'] . 'さん</td>
                            <td>' . $empAll[$i]['cnt'] . '</td>
                        </tr>';
                    } elseif ($max == $empAll[$i]['cnt']) { //最大回数を赤色
                        echo '<tr style="color:#c7243a">
                            <td><img src="../../images/crown.png" style="width: 30px;">' . $empAll[$i]['empname'] . 'さん</td>
                            <td>' . $empAll[$i]['cnt'] . '</td>
                        </tr>';
                    } else {
                        echo '<tr>
                            <td>' . $empAll[$i]['empname'] . 'さん</td>
                            <td>' . $empAll[$i]['cnt'] . '</td>
                        </tr>';
                    }
                } ?>
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