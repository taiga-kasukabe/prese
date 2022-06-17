<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
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
    <h1>ログアウトしました</h1>
    <h2>またのご利用をお待ちしております</h2>
</body>

</html>