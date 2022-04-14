<!--新規会員登録-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>
</head>

<body>
<h1>新規会員登録</h1>
<form action="register.php" method="post" class="form_log"> 
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
        <label>メールアドレス（再入力）：</label>
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
        <input type="password" name="password"  required>
    </div>
    <div>
        <label>パスワード（再入力）：</label>
        <input type="password" name="password_confirm" required>
    </div>

    <input type="submit" value="確認">
    <p>既に登録済みの方は<a href="./login.php">こちら</a></p>
    <p><a href="./terms/terms_service.php">利用規約</a></p>
    <p><a href="./terms/terms_privacy.php">プライバシー規約</a></p>
</form>    
</body>
</html>