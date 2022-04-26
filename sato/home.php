<!DOCTYPE html> 
<html lang="ja"> 

<link rel="stylesheet" href="./css/popup.css">

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>ホーム</title>
</head>

<?php

session_start();

if(!$_SESSION['user']['id']){
    echo 'ログインが必要です';
    exit;
}


//データベース情報の読み込み
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

$id = $_SESSION['id'];

//ユーザー情報の取得
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_user);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();

//社員情報の取得
$sql_emp = "SELECT * FROM emp_table";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body>
<h1>ホーム</h1>

<p>こんにちは、<?php echo $member['username']; ?> さん</p>

<a href="./mypage.php">マイページ</a><br>
<a href="./diagnose.php">簡易診断はこちら</a><br><br>

<?php for ($num = 0; $num < count($employee); $num++) { ?>
    <!-- <label class="open" for="pop-up"> -->
    <h2><?php echo $employee[$num]['empname']; ?></h2>
    <!-- </label>
    <input type="checkbox" id="pop-up">

    <div class="overlay">
        <div class="window">
            <label class="close" for="pop-up">×</label>
            <p class="text">年次：<?php echo $employee[$num]['empyear']; ?></p>
        </div>
    </div> -->

    <img src="./images/<?php echo $employee[$num]['empimg_id']; ?>" width="300">
    <p>年次：<?php echo $employee[$num]['empyear']; ?></p>
    <p>役職：<?php echo $employee[$num]['empjob']; ?></p>
    <p>職歴：<?php echo $employee[$num]['empcareer']; ?></p><br><br><br>
<?php } ?>

<button id="modalOpen" class="button">モーダルを表示</button>
    <div id="easyModal" class="modal">
        <div class="modal-content">
            <div class="modal-body">
            <span class="modalClose">×</span>
                <p>ここにコンテンツが入る</p>
            </div>
        </div>
    </div>


<script>
const buttonOpen = document.getElementById('modalOpen');
const modal = document.getElementById('easyModal');
const buttonClose = document.getElementsByClassName('modalClose')[0];

//ボタンがクリックされた時
buttonOpen.addEventListener('click', modalOpen);
function modalOpen() {
    modal.style.display = 'block';
};

//バツ印がクリックされた時
buttonClose.addEventListener('click', modalClose);
function modalClose() {
    modal.style.display = 'none';
};

//モーダルコンテンツ以外がクリックされた時
addEventListener('click', outsideClose);
function outsideClose(e) {
    if (e.target == modal) {
    modal.style.display = 'none';
    };
};

</script>

