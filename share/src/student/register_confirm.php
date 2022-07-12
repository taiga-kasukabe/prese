<?php

session_start();

include("../../conf/variable_session.php");

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
    <link rel="stylesheet" href="../../css/register_confirm.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
        </script>
    </header>

    <main>
        <div class="container">
            <p>CONFIRM</p>

            <div class="item">
                <span class="label"> 姓名</span><span class="data"><?php echo $username; ?></span>
            </div>

            <div class="item">
                <span class="label">姓名（カナ）</span><span class="data"><?php echo $username_kana; ?></span>
            </div>

            <div class="item">
                <span class="label">メールアドレス</span><span class="data"><?php echo $mail; ?></span>
            </div>

            <div class="item">
                <span class="label">電話</span><span class="data"><?php echo $tel; ?></span>
            </div>

            <div class="item">
                <span class="label">学校名</span><span class="data"><?php echo $school; ?></span>
            </div>

            <div class="item">
                <span class="label">学部（研究科）</span><span class="data"><?php echo $department1; ?></span>
            </div>

            <div class="item">
                <span class="label">学科</span><span class="data"><?php echo $department2; ?></span>
            </div>

            <div class="item">
                <span class="label">学年</span><span class="data"><?php echo $student_year; ?></span>
            </div>

            <div class="item">
                <span class="label">ID</span><span class="data"><?php echo $id; ?></span>
            </div>

            <div class="item">
                <span class="label">パスワード</span><span class="data"><?php echo str_repeat("*", mb_strlen($password_row, "UTF8")); ?></span>
            </div>

            <div class="link">
                <a href="./register_form.php" id="edit">修正</a>
                <a href="./mail_confirm.php" id="register">登録</a>
            </div>
        </div>
    </main>
</body>

</html>