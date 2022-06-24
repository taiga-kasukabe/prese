<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/emplogin_form.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();
?>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
    </header>

    <main>
        <div class="container">
            <h1>LOGIN</h1>
            <p>for Employees</p>

            <!-- エラーメッセージの表示 -->
            <p><?php
                if(!empty($_SESSION['err_msg'])){
                    echo $_SESSION['err_msg'];
                    
                    session_destroy();
                }
                ?>
            </p>

            <form action="./emplogin.php" method="POST">
                <div class="form">
                    <input type="text" name="empid" placeholder="ID" required>
                    <input type="password" name="emppassword" placeholder="Password" required>
                </div>

                <button type="submit" id="login_btn">Login</button>
            </form>
        </div>
    </main>
</body>

</html>