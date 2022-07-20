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
    <link rel="stylesheet" href="../../css/student/diagnose.css">
    <script src="https://kit.fontawesome.com/2d726a91d3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="header_container">
            <div class="logo">
                <img src="../../images/ntt-east_white.png" id="logo">
            </div>
            <div class="navbtn">
                <nav>
                    <ul class="header_nav">
                        <li><a href="./home.php">HOME</a></li>
                        <li><a href="./mypage.php">MY PAGE</a></li>
                        <li><a href="./logout.php">LOGOUT</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <?php session_start(); ?>
        <?php if (!empty($_SESSION['id'])) { ?>
            <div class="top">
                <h1>おすすめ内定者診断</h1>
                <!-- <p>あなたの面談相手におすすめの内々定者を診断します！</p> -->
            </div>

            <div id="main">
                <div id="question_area">
                    <form method="POST" action="diagnose_result.php">

                        <div id="q1" class="question is_open">
                            <div class="q_text">Q.希望する内定者はどっち？</div>
                                <div class="q_content" id="academichistory">
                                    <input type="checkbox" name="academichistory[]" value="学部" data-q="q1" <?php if (isset($_POST['academichistory']) && in_array("学部", $_POST['academichistory'])) { echo 'checked'; } ?> id="q11"><label for="q11">学部</label>
                                    <input type="checkbox" name="academichistory[]" value="院" data-q="q1" <?php if (isset($_POST['academichistory']) && in_array("院", $_POST['academichistory'])) { echo 'checked'; } ?> id="q12"><label for="q12">院</label>
                                </div>
                            <br><br>
                            <input type="button" value="次へ" class="next" data-button="q1">
                        </div>
                        
                        <div id="q2" class="question">
                            <div class="q_text">Q.どんな業界を見ていた内々定者？</div>
                                <div class="q_content" id="industry">
                                    <input type="checkbox" name="industry[]" value="通信" data-q="q2" <?php if (isset($_POST['industry']) && in_array("通信", $_POST['industry'])) { echo 'checked'; } ?> id="q21"><label for="q21">通信</label>
                                    <input type="checkbox" name="industry[]" value="SIer" data-q="q2" <?php if (isset($_POST['industry']) && in_array("SIer", $_POST['industry'])) { echo 'checked'; } ?> id="q22"><label for="q22">SIer</label>
                                    <input type="checkbox" name="industry[]" value="メーカー" data-q="q2" <?php if (isset($_POST['industry']) && in_array("メーカー", $_POST['industry'])) { echo 'checked'; } ?> id="q23"><label for="q23">メーカー</label>
                                    <input type="checkbox" name="industry[]" value="インフラ" data-q="q2" <?php if (isset($_POST['industry']) && in_array("インフラ", $_POST['industry'])) { echo 'checked'; } ?> id="q24"><label for="q24">インフラ</label>
                                    <input type="checkbox" name="industry[]" value="セキュリティ" data-q="q2" <?php if (isset($_POST['industry']) && in_array("セキュリティ", $_POST['industry'])) { echo 'checked'; } ?> id="q25"><label for="q25">セキュリティ</label>
                                    <input type="checkbox" name="industry[]" value="金融" data-q="q2" <?php if (isset($_POST['industry']) && in_array("金融", $_POST['industry'])) { echo 'checked'; } ?> id="q26"><label for="q26">金融</label>
                                    <input type="checkbox" name="industry[]" value="国家公務員" data-q="q2" <?php if (isset($_POST['industry']) && in_array("国家公務員", $_POST['industry'])) { echo 'checked'; } ?> id="q27"><label for="q27">国家公務員</label>
                                    <input type="checkbox" name="industry[]" value="エネルギー" data-q="q2" <?php if (isset($_POST['industry']) && in_array("エネルギー", $_POST['industry'])) { echo 'checked'; } ?> id="q28"><label for="q28">エネルギー</label>
                                    <input type="checkbox" name="industry[]" value="自動車" data-q="q2" <?php if (isset($_POST['industry']) && in_array("自動車", $_POST['industry'])) { echo 'checked'; } ?> id="q29"><label for="q29">自動車</label>
                                </div>
                            <br><br>
                            <input type="button" value="前へ" class="prev" data-button="q2">
                            <input type="button" value="次へ" class="next" data-button="q2">
                        </div>

                        <div id="q3" class="question">
                        <div class="q_text">Q.求める就活サポートスキルは？</div>
                                <div class="q_content" id="skill">
                                    <input type="checkbox" name="skill[]" value="ES添削" data-q="q3" <?php if (isset($_POST['skill']) && in_array("ES添削", $_POST['skill'])) { echo 'checked'; } ?> id="q31"><label for="q31">ES添削</label>
                                    <input type="checkbox" name="skill[]" value="面接練習" data-q="q3" <?php if (isset($_POST['skill']) && in_array("面接練習", $_POST['skill'])) { echo 'checked'; } ?> id="q32"><label for="q32">面接練習</label>
                                    <input type="checkbox" name="skill[]" value="メンタルフォロー" data-q="q3" <?php if (isset($_POST['skill']) && in_array("メンタルフォロー", $_POST['skill'])) { echo 'checked'; } ?> id="q33"><label for="q33">メンタルフォロー</label>
                                    <input type="checkbox" name="skill[]" value="SPI対策" data-q="q3" <?php if (isset($_POST['skill']) && in_array("SPI対策", $_POST['skill'])) { echo 'checked'; } ?> id="q34"><label for="q34">SPI対策</label>
                                    <input type="checkbox" name="skill[]" value="業界研究" data-q="q3" <?php if (isset($_POST['skill']) && in_array("業界研究", $_POST['skill'])) { echo 'checked'; } ?> id="q35"><label for="q35">業界研究</label>
                                    <input type="checkbox" name="skill[]" value="GD対策" data-q="q3" <?php if (isset($_POST['skill']) && in_array("GD対策", $_POST['skill'])) { echo 'checked'; } ?> id="q36"><label for="q36">GD対策</label>
                                    <input type="checkbox" name="skill[]" value="OB/OG訪問" data-q="q3" <?php if (isset($_POST['skill']) && in_array("OB/OG訪問", $_POST['skill'])) { echo 'checked'; } ?> id="q37"><label for="q37">OB/OG訪問</label>
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