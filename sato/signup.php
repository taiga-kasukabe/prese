<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>新規登録</title>
</head>

<body>
<h1>新規会員登録</h1>
<form action="signup_confirm.php" method="POST">
    <div>
        <label>姓名</label>
        <input type="text" name="username" required>
    </div>

    <div>
        <label>姓名（カナ）</label>
        <input type="text" name="username_kana" required>
    </div>

    <div>
        <label>メールアドレス</label>
        <input type="text" name="mail" required>
    </div>

    <div>
        <label>メールアドレス（再入力）</label>
        <input type="text" name="mail_confirm" required>
    </div>

    <div>
        <label>電話番号</label>
        <input type="text" name="tel" required>
    </div>

    <div>
        <label>学校名</label>
        <input type="text" name="school" required>
    </div>

    <div>
        <label>学部（研究科）</label>
        <input type="text" name="depertment1" required>
    </div>

    <div>
        <label>学科（専攻）</label>
        <input type="text" name="depertment2" required>
    </div>

    <div>
        <!-- プルダウン？が良さそう。選ぶやつ。 -->
        <label>学年</label>
        <input type="text" name="student_year" required>
    </div>

    <div>
        <label>ID</label>
        <input type="text" name="id" required>
    </div>

    <div>
        <label>パスワード</label>
        <input type="password" name="pass" required>
    </div>

    <div>
        <label>パスワード（再入力）</label>
        <input type="password" name="pass_confirm" required>
    </div>

    <input type="submit" value="確認">
</form>
</body>

</html>