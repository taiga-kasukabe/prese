<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/emplogout.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();

// delete all session variable
$_SESSION = array();

// delete session cookie
if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
}

// delete data of session
session_destroy();
?>

<body>
<header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
    </header>

    <main>
        <div class="container">
            <h1>ログアウトしました</h1>
            <h2>またのご利用をお待ちしております</h2>
            <a href="./emplogin_form.php" class="login">ログインページへ</a>
        </div>
    </main>
</body>

</html>