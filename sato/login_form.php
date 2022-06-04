<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>ログインページ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="./css/login_form.css">
</head>

<?php
if(!empty($_SESSION['err_msg'])){
    echo $_SESSION['err_msg'];
}
?>

<body>
<div class="container">
    <p>Welcome</p>
    <form action="login.php" method="POST">
        <div class="form">
            <input type="text" name="id" placeholder="ID" required>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <input type="submit" value="ログイン">
    </form>
</div>
</body>