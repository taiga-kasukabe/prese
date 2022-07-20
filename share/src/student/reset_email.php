<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再設定</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/student/reset_email.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<?php
session_start();
//データベース情報の読み込み
include('../../conf/config.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}
?>
<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
            <a href="./home.php" id="home">ホーム</a>
        </div>
    </header>

    <main>
        <div class="top">
            <h1>パスワード再設定</h1>
        </div>
        <div class="container">
            <form action="./reset_vali.php" method="post" class="form_log"> 
                <div class="err_msg">
                    <?php
                    // エラーメッセージが空じゃないの時（バリデーションチェックが問題なかった時）以下の処理を行う
                    if (!empty($_SESSION['err'])) {
                        foreach ($_SESSION['err'] as $value) {
                            echo $value . "<br>"; //hタグ内の改行はbr
                        }
                    }
                    ?>
                </div>
                <div>
                    <label>ログインID</label>
                    <input type="text" name="id" required>
                </div>
                <div>
                    <label>新しいパスワード</label>
                    <input type="password" name="password" placeholder="半角英数字8文字以上" required>
                </div>
                <div>
                    <label>新しいパスワード（再入力）</label>
                    <input type="password" name="password_confirm" placeholder="半角英数字8文字以上" required>
                </div>
                <button type="submit">登録</button>
            </form>
        </div>
    </main>
</body>