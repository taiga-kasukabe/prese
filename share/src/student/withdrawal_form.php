<!--退会フォーム-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>退会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/withdrawal_form.css">
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

    <?php 
    session_start();

    // SESSIONが切れてないか確認
    if (!empty($_SESSION['id'])) { ?>
        <main>
            <div class="container">
                <h2>退会する場合はこちらのボタンをクリック</h2>
                <div class="btn_list">
                    <button onclick='location.href="./mypage.php"' id="page_back">戻る</button>
                    <button type="button" id="btn">退会</button>
                </div>
                <script type="text/javascript">
                    let btn = document.getElementById('btn');
                    btn.addEventListener('click', function() {
                        let result = window.confirm('本当に退会しますか？');

                        if (result) {
                            window.location.href = "./withdrawal.php";
                        } else {
                            alert("キャンセルしました");
                        }
                    });
                </script>
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
    <script type="text/javascript" src="../../js/browserBack.js"></script>
</body>