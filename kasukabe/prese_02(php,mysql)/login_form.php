<link rel="stylesheet" href="./style.css">

<h1>ログインページ</h1>
<form action="./login.php" method="post">
    <div>
        <label>メールアドレス：</label>
        <input type="text" name="mail" required>
    </div>
    <div>
        <label>パスワード：</label>
        <input type="password" name="pass" required>
    </div>
    <input type="submit" value="ログイン"><br>
    <p>未登録の方は<a href="./index.php">こちら</a></p>
</form>