<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>登録情報確認</title>
</head>

<body>
<h1>登録情報確認</h1>
<form action="register.php" method="POST">

<div>
        <label>姓名</label>
        <?php echo $_POST['username']; ?><br>
    </div>

    <div>
        <label>姓名（カナ）</label>
        <?php echo $_POST['username_kana']; ?><br>
    </div>

    <div>
        <label>メールアドレス</label>
        <?php echo $_POST['mail']; ?><br>
    </div>

    <div>
        <label>メールアドレス（再入力）</label>
        <?php echo $_POST['mail_confirm']; ?><br>
    </div>

    <div>
        <label>電話番号</label>
        <?php echo $_POST['tel']; ?><br>
    </div>

    <div>
        <label>学校名</label>
        <?php echo $_POST['school']; ?><br>
    </div>

    <div>
        <label>学部（研究科）</label>
        <?php echo $_POST['depertment1']; ?><br>
    </div>

    <div>
        <label>学科（専攻）</label>
        <?php echo $_POST['depertment2']; ?><br>
    </div>

    <div>
        <!-- プルダウン？が良さそう。選ぶやつ。 -->
        <label>学年</label>
        <?php echo $_POST['student_year']; ?><br>
    </div>

    <div>
        <label>ID</label>
        <?php echo $_POST['id']; ?><br>
    </div>

    <div>
        <label>パスワード</label>
        <?php echo $_POST['pass']; ?><br>
    </div>

    <div>
        <label>パスワード（再入力）</label>
        <?php echo $_POST['pass_confirm']; ?><br>
    </div>

    <input type="submit" value="登録">
    <p><a href="signup.php">修正する</a></p>

</form>

</body>

</html>