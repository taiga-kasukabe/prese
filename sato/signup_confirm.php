<?php
//変数定義
//各種入力情報，正規表現，エラーメッセージ配列
include("./conf/variable.php");

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
$password = $_SESSION['user']['password'];
$password_confirm = $_SESSION['user']['password_confirm'];
$password_row = $_SESSION['user']['password_row'];
$password_confirm_row = $_SESSION['user']['password_confirm_row'];

?>

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
    <p><a href="./signup.php">修正</a></p>

</form>

</body>

</html>