<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>簡易診断</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/diagnose.css">
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
        <?php session_start(); ?>
        <?php if (!empty($_SESSION['id'])) { ?>
            <h1>簡易診断</h1>
            <p>面談相手におすすめの社員を診断します！</p>
            <br>
            <div id="main">
                <div id="question_area">
                    <form method="POST" action="diagnose_result.php">

                        <div id="q1" class="question is_open">
                            <div class="q_text">Q.学部生？院生？</div>
                                <div class="q_content" id="academichistory">
                                    <input type="checkbox" name="academichistory[]" value="学部" data-q="q1" <?php if (isset($_POST['academichistory']) && in_array("学部", $_POST['academichistory'])) { echo 'checked'; } ?>>学部
                                    <input type="checkbox" name="academichistory[]" value="院" data-q="q1" <?php if (isset($_POST['academichistory']) && in_array("院", $_POST['academichistory'])) { echo 'checked'; } ?>>院
                                </div>
                            <br><br>
                            <input type="button" value="次へ" class="next" data-button="q1">
                        </div>
                        
                        <div id="q2" class="question">
                            <div class="q_text">Q.見ていた業界は？</div>
                                <div class="q_content" id="industry">
                                    <input type="checkbox" name="industry[]" value="通信" data-q="q2" <?php if (isset($_POST['industry']) && in_array("通信", $_POST['industry'])) { echo 'checked'; } ?>>通信
                                    <input type="checkbox" name="industry[]" value="SIer" data-q="q2" <?php if (isset($_POST['industry']) && in_array("SIer", $_POST['industry'])) { echo 'checked'; } ?>>SIer
                                    <input type="checkbox" name="industry[]" value="インフラ" data-q="q2" <?php if (isset($_POST['industry']) && in_array("インフラ", $_POST['industry'])) { echo 'checked'; } ?>>インフラ
                                    <input type="checkbox" name="industry[]" value="金融" data-q="q2" <?php if (isset($_POST['industry']) && in_array("金融", $_POST['industry'])) { echo 'checked'; } ?>>金融
                                </div>
                            <br><br>
                            <input type="button" value="前へ" class="prev" data-button="q2">
                            <input type="button" value="次へ" class="next" data-button="q2">
                        </div>

                        <div id="q3" class="question">
                        <div class="q_text">Q.就活サポートスキルは？</div>
                                <div class="q_content" id="skill">
                                    <input type="checkbox" name="skill[]" value="ES添削" data-q="q3" <?php if (isset($_POST['skill']) && in_array("ES添削", $_POST['skill'])) { echo 'checked'; } ?>>ES添削
                                    <input type="checkbox" name="skill[]" value="面接練習" data-q="q3" <?php if (isset($_POST['skill']) && in_array("面接練習", $_POST['skill'])) { echo 'checked'; } ?>>面接練習
                                    <input type="checkbox" name="skill[]" value="メンタルフォロー" data-q="q3" <?php if (isset($_POST['skill']) && in_array("メンタルフォロー", $_POST['skill'])) { echo 'checked'; } ?>>メンタルフォロー
                                    <input type="checkbox" name="skill[]" value="SPI対策" data-q="q3" <?php if (isset($_POST['skill']) && in_array("SPI対策", $_POST['skill'])) { echo 'checked'; } ?>>SPI対策
                                </div>
                            <br><br>
                            <input type="button" value="前へ" class="prev" data-button="q3">
                            <input type="submit" value="診断する">
                        </div>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <p>セッションが切れました</p>
                <p>ログインしてください</p>
                <a href="./login_form.php" class="login">ログインページへ</a>
            </div>
        <?php } ?>
    </main>
    <script src="../../js/diagnose.js"></script>
</body>
</html>