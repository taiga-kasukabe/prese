<h1>新規会員登録</h1>

<!-- エラーメッセージ出力 -->
<h3>
    <font color="#c7243a">
        <?php
        session_start();
        if (!empty($_SESSION['err'])) {
            foreach ($_SESSION['err'] as $value) {
                echo $value . "<br>"; //hタグ内の改行はbr
            }
        }
        if (!empty($_SESSION['user'])) {
            $username = $_SESSION['user']['username'];
            $username_kana = $_SESSION['user']['username_kana'];
            $mail = $_SESSION['user']['mail'];
            $mail_confirm = $_SESSION['user']['mail_confirm'];
            $tel = $_SESSION['user']['tel'];
            $school = $_SESSION['user']['school'];
            $department1 = $_SESSION['user']['department1'];
            $department2 = $_SESSION['user']['department2'];
            $student_year = $_SESSION['user']['student_year'];
            $id = $_SESSION['user']['id'];
        }
        session_destroy();
        ?>
    </font>
</h3>

<!-- 実行プログラムはvalidation.php -->
<form action="./validation.php" method="post">
    <div>
        <label>姓名：</label>
        <input type="text" name="username" value="<?php if (!empty($username)) {echo $username;} ?>" required>
    </div>
    <div>
        <label>姓名（カナ）：</label>
        <input type="text" name="username_kana" value="<?php if (!empty($username)) {echo $username_kana;} ?>" required>
    </div>
    <div>
        <label>メールアドレス：</label>
        <input type="text" name="mail" value="<?php if(!empty($mail)){echo $mail;} ?>" required>
    </div>
    <div>
        <label>メールアドレス（確認）：</label>
        <input type="text" name="mail_confirm" value="<?php if(!empty($mail_confirm)){echo $mail_confirm;} ?>"required>
    </div>
    <div>
        <label>電話：</label>
        <input type="tel" name="tel" value="<?php if(!empty($tel)){echo $tel;} ?>" required>
    </div>
    <div>
        <label>学校名：</label>
        <input type="text" name="school" value="<?php if(!empty($school)){echo $school;} ?>" required>
    </div>
    <div>
        <label>学部（研究科）：</label>
        <input type="text" name="department1" value="<?php if(!empty($department1)){echo $department1;} ?>" required>
    </div>
    <div>
        <label>学科：</label>
        <input type="text" name="department2" value="<?php if(!empty($department2)){echo $department2;} ?>" required>
    </div>
    <div>
        <label>学年：</label>
        <input type="text" name="student_year" value="<?php if(!empty($student_year)){echo $student_year;} ?>" required>
    </div>
    <div>
        <label>ID：</label>
        <input type="text" name="id" value="<?php if(!empty($id)){echo $id;} ?>" required>
    </div>
    <div>
        <label>パスワード：</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>パスワード（確認）：</label>
        <input type="password" name="password_confirm" required>
    </div>
    <!-- 登録ボタン -->

    <input type="submit" value="確認">
    <p>既に登録済みの方は<a href="./login_form.php">こちら</a></p>
    <p><a href="./terms/terms_service.php">利用規約</a></p>
    <p><a href="./terms/terms_privacy.php">プライバシー規約</a></p>
</form>