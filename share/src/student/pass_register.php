<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>再設定完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/pass_register.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>


<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
            <a href="./home.php" id="home">ホーム</a>
        </div>
        </script>
    </header>

    <?php
        session_start();

        // SESSIONが切れてないか確認
        if (!empty($_SESSION['id'])) {

        //変数定義
        include("../../conf/vari_session_pass.php");
        include("../../conf/config.php");

        //データベースへ接続、テーブルがない場合は作成
        try {
            $dbh = new PDO($dsn, $db_username, $db_password);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
        }

        $sql =  "UPDATE users_table SET password = :password ,password_confirm = :password_confirm WHERE id=:id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':password_confirm', $password_confirm);
        $stmt->bindValue(':id', $id);
        //$params = array(':password' => $password, ':password_confirm' => $password_confirm);
        $stmt->execute();
    ?>

    <main>
        <div class="top">
            <h1>パスワード再設定</h1>
        </div>
        <div class="container">
            <h2>再設定が完了しました</h2>
            <p class="login_link">こちらのリンクからログインしてください</p>
            <a href="./login_form.php">ログインページへ</a>
        </div>
    </main>
    <?php } else { ?>
        <main>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        </main>
    <?php } ?>
</body>
</html>