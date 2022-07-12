<!--確認画面-->
<?php
session_start();
include("./conf/variable_session.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録確認</title>
</head>

<body>
<h1>登録情報確認</h1>

<div>
        <label for=""> 姓名：<?php echo $username; ?></label><br>
    </div>

    <div>
        <label for="">姓名（カナ）：<?php echo $username_kana; ?></label><br>
    </div>

    <div>
        <label for="">メールアドレス：<?php echo $mail; ?></label><br>
    </div>

    <div>
        <label for="">電話：<?php echo $tel; ?></label><br>
    </div>

    <div>
        <label for="">学校名：<?php echo $school; ?></label><br>
    </div>

    <div>
        <label for="">学部（研究科）：<?php echo $department1; ?></label><br>
    </div>

    <div>
        <label for="">学科：<?php echo $department2; ?></label><br>
    </div>

    <div>
        <label for="">学年：<?php echo $student_year; ?></label><br>
    </div>

    <div>
        <label for="">ID：<?php echo $id; ?></label><br>
    </div>

    <div>
        <label for="">パスワード：<?php echo str_repeat("*", mb_strlen($password_row, "UTF8")); ?></label><br>
    </div>

    <p><a href="./register.php">登録</a></p>
    <p><a href="./register_form.php">修正</a></p>

</body>
</html>

