

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
<form action="./validation.php" method="POST">

<?php
session_start();

// エラーメッセージが空の時（バリデーションチェックが問題なかった時）以下の処理を行う
if(!empty($_SESSION['err'])){
    foreach ($_SESSION['err'] as $value) {
        echo $value . "<br>"; //hタグ内の改行はbr
    }
}

if(!empty($_SESSION['user'])){
    include("./conf/variable_session.php");

session_destroy();

}
?>

    <div>
        <label>姓名</label>
        <input type="text" name="username" value="<?php if(!empty($username)){echo $username;} ?>" required>
    </div>

    <div>
        <label>姓名（カナ）</label>
        <input type="text" name="username_kana" value="<?php if(!empty($username_kana)){echo $username_kana;} ?>" required>
    </div>

    <div>
        <label>メールアドレス</label>
        <input type="text" name="mail" value="<?php if(!empty($mail)){echo $mail;} ?>" required>
    </div>

    <div>
        <label>メールアドレス（再入力）</label>
        <input type="text" name="mail_confirm" value="<?php if(!empty($mail_confirm)){echo $mail_confirm;} ?>" required>
    </div>

    <div>
        <label>電話番号</label>
        <input type="text" name="tel" value="<?php if(!empty($tel)){echo $tel;} ?>" required>
    </div>

    <div>
        <label>学校名</label>
        <input type="text" name="school" value="<?php if(!empty($school)){echo $school;} ?>" required>
    </div>

    <div>
        <label>学部（研究科）</label>
        <input type="text" name="department1" value="<?php if(!empty($department1)){echo $department1;} ?>" required>
    </div>

    <div>
        <label>学科（専攻）</label>
        <input type="text" name="department2" value="<?php if(!empty($department2)){echo $department2;} ?>" required>
    </div>

    <div>
        <!-- プルダウン？が良さそう。選ぶやつ。 -->
        <label>学年</label>
        <input type="text" name="student_year" value="<?php if(!empty($student_year)){echo $student_year;} ?>" required>
    </div>

    <div>
        <label>ID</label>
        <input type="text" name="id" value="<?php if(!empty($id)){echo $id;} ?>" required>
    </div>

    <div>
        <label>パスワード</label>
        <input type="password" name="password" value="" required>
    </div>

    <div>
        <label>パスワード（再入力）</label>
        <input type="password" name="password_confirm" value="" required>
    </div>

    <p><a href="./terms/tos.php">利用規約</a></p>
    <p><a href="./terms/privacypolicy.php">プライバシー規約</a></p>

    <input type="submit" value="確認">
</body>

</html>