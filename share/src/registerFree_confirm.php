<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <meta charset="UTF-8">     
    <title>登録確認</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../css/registerFree_confirm.css"> 
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">   
</head>

<?php
session_start();
$weekJa = array("日", "月", "火", "水", "木", "金", "土");

for ($i = 0; $i < count($_GET['free']); $i++) {
    list($empid[$i], $time[$i], $date[$i], $weekNum[$i]) = explode(":", $_GET['free'][$i]);
}
?>

<body>
<header>
    <div class="bg">
        <img src="../images/ntt-east_white.png" id="logo">
    </div>
    </script>
</header>

<main>
    <div class="container">
        <h1>以下の日程を空き日程に登録しますか？</h1>
        <div class="schedule">
            <?php for ($i = 0; $i < count($_GET['free']); $i++) { ?>
                <p><?php echo $i + 1 . '. ' . $date[$i] . '(' . $weekJa[$weekNum[$i]] . ') ' . substr_replace($time[$i], ':', 2, 0) . '~' . substr_replace($time[$i] + 100, ':', 2, 0); ?></p>
            <?php } ?>
        </div>

        <div class="btn">
            <a href="./registerFree_form.php">修正</a>
            <form action="./registerFree.php" method="GET">
                <?php for ($i = 0; $i < count($_GET['free']); $i++) { ?>
                    <input type="hidden" name="free[]" value="<?php echo $_GET['free'][$i]; ?>">
                <?php } ?>
                <button type="submit">登録</button>
            </form>
        </div>
    </div>
</main>
</body>