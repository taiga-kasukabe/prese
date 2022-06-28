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
                            <div class="q_text">Q.性別は？</div>
                                <div class="q_content" id="gender">
                                    <input type="radio" name="gender" id="m" value="m" data-q="q1" <?php if (isset($_POST['gender']) && $_POST['gender'] == "m") { echo 'checked'; } ?>><label for="m">男性</label>
                                    <input type="radio" name="gender" id="f" value="f" data-q="q1" <?php if (isset($_POST['gender']) && $_POST['gender'] == "f") { echo 'checked'; } ?>><label for="f">女性</label>
                                </div>
                            <br><br>
                            <input type="button" value="次へ" class="next" data-button="q1">
                        </div>
                        
                        <div id="q2" class="question">
                            <div class="q_text">Q.職種は？</div>
                                <div class="q_content" id="job">
                                    <input type="checkbox" name="job[]" value="nwp" data-q="q2" <?php if (isset($_POST['job']) && in_array("nwp", $_POST['job'])) { echo 'checked'; } ?>>NWP
                                    <input type="checkbox" name="job[]" value="se" data-q="q2" <?php if (isset($_POST['job']) && in_array("se", $_POST['job'])) { echo 'checked'; } ?>>SE
                                    <input type="checkbox" name="job[]" value="service" data-q="q2" <?php if (isset($_POST['job']) && in_array("service", $_POST['job'])) { echo 'checked'; } ?>>サービス開発
                                    <input type="checkbox" name="job[]" value="collab" data-q="q2" <?php if (isset($_POST['job']) && in_array("collab", $_POST['job'])) { echo 'checked'; } ?>>協業ビジネス
                                </div>
                            <br><br>
                            <input type="button" value="前へ" class="prev" data-button="q2">
                            <input type="button" value="次へ" class="next" data-button="q2">
                        </div>

                        <div id="q3" class="question">
                        <div class="q_text">Q.年次は？</div>   
                            <div class="q_content" id="year">     
                                年次：
                                <select name="year_from" size="1">
                                    <option value="">---</option>

                                    <?php
                                    for($i=1; $i <= 10; $i++) {
                                        if($i == $_POST['year_from']) {    
                                            echo '<option value='.$i.' selected>'.$i.'</option>'; 
                                        } else {
                                            echo '<option value='.$i.'>'.$i.'</option>';
                                        }
                                    }
                                    ?>

                                </select>
                                年目～
                                <select name="year_to" size="1">
                                    <option value="">---</option>

                                    <?php
                                    for($i=1; $i <= 10; $i++) { 
                                        if($i == $_POST['year_to']) {    
                                            echo '<option value='.$i.' selected>'.$i.'</option>'; 
                                        } else {
                                            echo '<option value='.$i.'>'.$i.'</option>';
                                        }
                                    }
                                    ?>

                                </select>
                                年目
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