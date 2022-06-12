<!--マイページ-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../css/mypage.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();
//データベース情報の読み込み
include('../conf/config.php');
$employee = array();
$temp = 0;

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}


$id = $_SESSION['id'];

//users_table接続
// ログインしている学生のデータ取得
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_user);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

//rsvdb接続
// rsvdbのデータを全て取得
$sql_rsv = "SELECT * FROM rsvdb";
$stmt = $dbh->prepare($sql_rsv);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// rsvdbのうちログインしている学生の予約データのみ取得
$sql_rsv = "SELECT * FROM rsvdb WHERE stuid = '$id'";
$stmt = $dbh->prepare($sql_rsv);
$stmt->execute();
$stuid = $stmt->fetchAll(PDO::FETCH_ASSOC);

//empDB接続
// rsvdbのうちログインしている学生が予約しているデータのempidを取得し，
// それと一致するempidのデータをemp_tableから取得する
$sql_emp = "SELECT * FROM emp_table WHERE empid in (SELECT empid FROM rsvdb WHERE stuid = '$id')";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

//ename
// emp_tableの情報をすべて取得する
$sql_emp = "SELECT * FROM emp_table";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$ename = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
    <header>
        <div class="bg">
            <img src="../images/ntt-east_white.png" id="logo">
            <a href="./home.php" id="home">ホーム</a>
        </div>
    </header>

    <main>

        <body>
            <div class="top">
                <h1><?php echo $member['username']; ?> さん</h1>
                <div class="link">
                    <a href="./reset_pass_form.php">パスワード再登録はこちら</a>
                    <a href="./withdrawal_form.php">退会はこちら</a>
                </div>
            </div>
            <div class="rsv_list">
                <h2>予約内容</h2>
                <?php for ($n = 0; $n < count($stuid); $n++) { ?>
                    <div class="rsv_content">
                        <div class="rsv_text">
                            <?php for ($i = 0; $i < count($ename); $i++) {
                                if ($stuid[$n]['empid'] == $ename[$i]['empid']) { ?>
                                    <p><span class="tag"><i class="fa-solid fa-user"></i>面談相手</span>&nbsp;&nbsp;<?php echo $ename[$i]['empname']; ?></p>
                            <?php }
                            } ?>
                            <!-- ここの日程表示を自分で変える -->

                            <?php $rsvtime = $stuid[$n]['rsvdate'] ?>
                            <p><span class="tag"><i class="fa-solid fa-clock"></i>予約日時</span>&nbsp;&nbsp;<?php echo $stuid[$n]['rsvdate']; ?>&nbsp;&nbsp;&nbsp;<?php echo $stuid[$n]['rsvtime']; ?></p>
                            <div class="comment">
                                <p class="comment_tag"><span class="tag"><i class="fa-solid fa-pen"></i>相談内容</span>&nbsp;&nbsp;</p>
                                <p class="comment_data"><?php echo $stuid[$n]['comment']; ?></p>
                            </div>
                        </div>

                        <?php if ($rsvtime <= date('Y-m-d', strtotime("+2day"))) : ?>
                            <p>予約日2日前以降は予約の取り消しは出来ません。</p>
                            <p>これ以降は直接連絡をお取りください。</p>
                        <?php else : ?>
                            <div class="delete_btn">
                                <form action="./rsv_cancel.php" method="post" onSubmit="return check()">
                                    <button type="submit" class="delete">取消</button>
                                    <input type="hidden" name="empid" value="<?= $stuid[$n]['empid'] ?>">
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php } ?>
                <script type="text/javascript">
                    function check() {
                        let result = window.confirm('予約取り消しますか？');
                        if (result) {
                            return ture;
                        } else {
                            alert("取り消しをやめる");
                            return false;
                        }
                    };
                </script>
            </div>
        </body>