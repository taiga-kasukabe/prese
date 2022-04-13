<h1>新規会員登録</h1>

<!-- 実行プログラムはregister.php -->
<form action="register.php" method="post">
    <div>
        <label>姓名：</label>
        <!-- 入力必須 -->
        <input type="text" name="username" required>
    </div>
    <div>
        <label>姓名（カナ）：</label>
        <!-- 入力必須 -->
        <input type="text" name="username_kana" required>
    </div>
    <div>
        <label>メールアドレス：</label>
        <!-- 入力必須 -->
        <input type="text" name="mail" required>
    </div>
    <div>
        <label>メールアドレス（確認）：</label>
        <!-- 入力必須 -->
        <input type="text" name="mail_confirm" required>
    </div>
    <div>
        <label>電話：</label>
        <!-- 入力必須 -->
        <input type="tel" name="tel" required>
    </div>
    <div>
        <label>学校名：</label>
        <!-- 入力必須 -->
        <input type="text" name="school" required>
    </div>
    <div>
        <label>学部（研究科）：</label>
        <!-- 入力必須 -->
        <input type="text" name="department1" required>
    </div>
    <div>
        <label>学科：</label>
        <!-- 入力必須 -->
        <input type="text" name="department2" required>
    </div>
    <div>
        <label>学年：</label>
        <!-- 入力必須 -->
        <input type="text" name="student_year" required>
    </div>
    <div>
        <label>ID：</label>
        <!-- 入力必須 -->
        <input type="text" name="id" required>
    </div>
    <div>
        <label>パスワード：</label>
        <!-- 入力必須 -->
        <input type="password" name="password" required>
    </div>
    <div>
        <label>パスワード（確認）：</label>
        <!-- 入力必須 -->
        <input type="password" name="password_confirm" required>
    </div>
    <!-- 登録ボタン -->
    <input type="submit" value="確認">
    <p>既に登録済みの方は<a href="./login_form.php">こちら</a></p>
    <p><a href="./terms/terms_service.php">利用規約</a></p>
    <p><a href="./terms/terms_privacy.php">プライバシー規約</a></p>
</form>