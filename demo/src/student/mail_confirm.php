<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">
    <!-- ページのタイトルをtestに設定 -->
    <title>登録完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/mail_confirm.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php

// セッションを開始する
session_start();

// セッション情報の引継ぎ
include("../../conf/variable_session.php");

//データベース情報
include('../../conf/config.php');

//データベース接続
try {
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

// insert(id)被り確認
$sql_id = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_id);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

if (empty($member)) {
    // insert実行(被りがなければ)
    $sql = "INSERT INTO users_table(username, username_kana, mail, mail_confirm, tel, school, department1, department2, student_year, id, password, password_confirm) VALUES (:username, :username_kana, :mail, :mail_confirm, :tel, :school, :department1, :department2, :student_year, :id, :password, :password_confirm)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':username_kana', $username_kana);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':mail_confirm', $mail_confirm);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':school', $school);
    $stmt->bindValue(':department1', $department1);
    $stmt->bindValue(':department2', $department2);
    $stmt->bindValue(':student_year', $student_year);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':password_confirm', $password_confirm);
    $stmt->execute();
}

//メール送信
include("./send_mail.php");

$msg = 'FINISH!';
$link = '<a href="./login_form.php">　ログイン　＞</a>';

?>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
        </script>
    </header>
    <?php if (empty($member)) { ?>
        <main>
            <div class="container">
                <h1><?php echo $msg; ?></h1>
                <div class="register_id">
                    登録ID名：<?php echo $id; ?>
                </div>
                <div class="text">
                    先ほど登録完了メールを送りました。<br>
                    ご確認ください。
                </div>
                <?php echo $link; ?>
            </div>
        </main>
    <?php } else { ?>
        <main>
            <div class="container">
                <h2>登録できませんでした</h2>
                <div class="text">
                    <p>IDに重複がございました。</p>
                    <p>申し訳ございませんが、改めて登録してください。</p>
                </div>
                <a href="./register_form.php">再登録する</a>
            </div>
        </main>
    <?php } ?>
    <script src="../../js/browserBack.js"></script>
</body>

</html>