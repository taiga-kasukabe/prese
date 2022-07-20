<!--リセット用メアド入力画面-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再設定</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/student/reset_email_form.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

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
            <h2>・登録したメールアドレスを入力してください</h2>
            <div class="err_msg">
                <?php
                session_start();

                // エラーメッセージが空じゃないの時（バリデーションチェックが問題なかった時）以下の処理を行う
                if (!empty($_SESSION['err'])) {
                    echo $_SESSION['err'];
                }
                ?>
            </div>
            <form action="./reset_vali_email.php" method="post" class="form_log">
                <div>
                    <label>メールアドレス</label>
                    <input type="text" name="mail" value=""  required>
                </div>
                <button type="submit">確認</button>
            </form>
        </div>
    </main>
</body>