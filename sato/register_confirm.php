<?php

session_start();

include("./conf/variable_session.php");

?>

<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>登録情報確認</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="./css/register_form.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">   
</head>

<body>
<header>
    <div class="bg">
        <img src="images/ntt-east_white.png" id="logo">
    </div>
    </script>
</header>

<main>
<div class="container">
    <p>CONFIRM</p>

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

    <a href="./mail_confirm.php">登録</a>
    <a href="./register_form.php">修正</a>
</div>
</main>
</body>

</html>