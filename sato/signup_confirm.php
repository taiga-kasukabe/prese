<?php
//変数定義
//各種入力情報，正規表現，エラーメッセージ配列
include("./conf/variable.php");
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
        <label>姓名</label>
        <?php echo $_POST['username']; ?><br>
    </div>

    <div>
        <label>姓名（カナ）</label>
        <?php echo $_POST['username_kana']; ?><br>
    </div>

    <div>
        <label>メールアドレス</label>
        <?php echo $_POST['mail']; ?><br>
    </div>

    <div>
        <label>メールアドレス（再入力）</label>
        <?php echo $_POST['mail_confirm']; ?><br>
    </div>

    <div>
        <label>電話番号</label>
        <?php echo $_POST['tel']; ?><br>
    </div>

    <div>
        <label>学校名</label>
        <?php echo $_POST['school']; ?><br>
    </div>

    <div>
        <label>学部（研究科）</label>
        <?php echo $_POST['department1']; ?><br>
    </div>

    <div>
        <label>学科（専攻）</label>
        <?php echo $_POST['department2']; ?><br>
    </div>

    <div>
        <!-- プルダウン？が良さそう。選ぶやつ。 -->
        <label>学年</label>
        <?php echo $_POST['student_year']; ?><br>
    </div>

    <div>
        <label>ID</label>
        <?php echo $_POST['id']; ?><br>
    </div>

    <div>
        <label>パスワード</label>
        <?php echo $_POST['password']; ?><br>
    </div>

    <div>
        <label>パスワード（再入力）</label>
        <?php echo $_POST['password_confirm']; ?><br>
    </div>

    <input type="submit" value="登録">
    <p><a href="signup.php">修正する</a></p>

    <!-- 受け渡し方法検討する．hiddenとcookieとsessionどれがいいか -->
    <input type="hidden" name="username" value="<?php echo $username ?>">
    <input type="hidden" name="username_kana" value="<?php echo $username_kana ?>">
    <input type="hidden" name="mail" value="<?php echo $mail ?>">
    <input type="hidden" name="mail_confirm" value="<?php echo $mail_confirm ?>">
    <input type="hidden" name="tel" value="<?php echo $tel ?>">
    <input type="hidden" name="school" value="<?php echo $school ?>">
    <input type="hidden" name="department1" value="<?php echo $department1 ?>">
    <input type="hidden" name="department2" value="<?php echo $department2 ?>">
    <input type="hidden" name="student_year" value="<?php echo $student_year ?>">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <input type="hidden" name="password" value="<?php echo $password ?>">
    <input type="hidden" name="password_confirm" value="<?php echo $password_confirm ?>">

</form>

</body>

</html>