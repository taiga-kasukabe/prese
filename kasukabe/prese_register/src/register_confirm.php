<?php
session_start();
include("../conf/variable_session.php");
?>

<h1>入力確認確認</h1>
<label for=""> 姓名：<?php echo $username; ?></label><br>
<label for="">姓名（カナ）：<?php echo $username_kana; ?></label><br>
<label for="">メールアドレス：<?php echo $mail; ?></label><br>
<label for="">電話：<?php echo $tel; ?></label><br>
<label for="">学校名：<?php echo $school; ?></label><br>
<label for="">学部（研究科）：<?php echo $department1; ?></label><br>
<label for="">学科：<?php echo $department2; ?></label><br>
<label for="">学年：<?php echo $student_year; ?></label><br>
<label for="">ID：<?php echo $id; ?></label><br>
<label for="">パスワード：<?php echo str_repeat("*", mb_strlen($password_row, "UTF8")); ?></label><br>
<p><a href="./register.php">登録</a></p>
<p><a href="./register_form.php">修正</a></p>