<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>簡易診断</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
    <link rel="stylesheet" href="./css/diagnose.css">
</head>


<body>
    <h1>簡易診断</h1>
    <p>面談相手におすすめの社員を診断します！</p>
    <br>
    <div id="main">
        <div id="question_area">
            <form method="POST" action="diagnose_result.php">

                <div id="q1" class="question is_open">
                    Q.性別は？
                    <div id="gender">
                        <input type="radio" name="gender" id="m" value="m" data-q="q1" <?php if (isset($_POST['gender']) && $_POST['gender'] == "m") { echo 'checked'; } ?>><label for="m">男性</label>
                        <input type="radio" name="gender" id="f" value="f" data-q="q1" <?php if (isset($_POST['gender']) && $_POST['gender'] == "f") { echo 'checked'; } ?>><label for="f">女性</label>
                    </div>
                    <input type="button" value="次へ" class="next" data-button="q1">
                </div>
                
                <div id="q2" class="question">
                    Q.職種は？
                    <div id="job">
                        <input type="checkbox" name="job[]" value="nwp" data-q="q2" <?php if (isset($_POST['job']) && in_array("nwp", $_POST['job'])) { echo 'checked'; } ?>>NWP
                        <input type="checkbox" name="job[]" value="se" data-q="q2" <?php if (isset($_POST['job']) && in_array("se", $_POST['job'])) { echo 'checked'; } ?>>SE
                        <input type="checkbox" name="job[]" value="service" data-q="q2" <?php if (isset($_POST['job']) && in_array("service", $_POST['job'])) { echo 'checked'; } ?>>サービス開発
                        <input type="checkbox" name="job[]" value="collab" data-q="q2" <?php if (isset($_POST['job']) && in_array("collab", $_POST['job'])) { echo 'checked'; } ?>>協業ビジネス
                    </div>
                    <input type="button" value="次へ" class="next" data-button="q2">
                </div>

                <div id="q3" class="question">
                    Q.年次は？
                    <div id="year">年次：
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
                        年目<br>
                    </div>
                    <input type="submit" value="診断する">
                </div>
            </form>
        </div>
    </div>
    <script src="js/diagnose.js"></script>
</body>
</html>