<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>削除確認</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/editFree_confirm.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

if (!empty($_GET['editFree'])) {
    for ($i = 0; $i < count($_GET['editFree']); $i++) {
        list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['editFree'][$i]);
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
        <?php if (!empty($_SESSION['eid']) && !empty($_GET['editFree'])) { ?>
            <div class="container">
                <h1>以下の日程を空き日程から削除しますか？</h1>
                <div class="schedule">
                    <?php for ($i = 0; $i < count($_GET['editFree']); $i++) { ?>
                        <p><?php echo $i + 1 . '. ' . $date[$i] . '(' . $weekJa[$weekNum[$i]] . ') ' . substr_replace($time[$i], ':', 2, 0) . '~' . substr_replace($time[$i] + 100, ':', 2, 0); ?></p>
                    <?php } ?>
                </div>

                <div class="btn">
                    <form action="./editFree_form.php" method="get">
                        <input type="hidden" name="empid" value="<?php echo $empid[0]; ?>">
                        <input type="hidden" name="week" value="0">
                        <button type="submit" id="edit">修正</button>
                    </form>

                    <form action="./editFree.php" method="GET">
                        <?php for ($i = 0; $i < count($_GET['editFree']); $i++) { ?>
                            <input type="hidden" name="editFree[]" value="<?php echo $_GET['editFree'][$i]; ?>">
                        <?php } ?>
                        <button type="submit" id="delete">削除</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./emplogin_form.php" class="login">ログインページへ</a>
            </div>
        <?php } ?>
    </main>
</body>