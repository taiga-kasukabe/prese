<link rel="stylesheet" href="./style.css">

<h1>新規会員登録</h1>

<!-- decide address -->
<form action="register.php" method="post">
    <div>
        <label>名前：</label>
        <!-- need to input -->
        <input type="text" name="name" required>
    </div>
    <div>
        <label>メールアドレス：</label>
        <!-- need to input -->
        <input type="text" name="mail" required>
    </div>
    <div>
        <label>パスワード：</label>
        <!-- need to input -->
        <input type="password" name="pass" required>
    </div>
    <!-- submit button -->
    <input type="submit" value="新規登録">
    <p>既に登録済みの方は<a href="./login_form.php">こちら</a></p>
</form>