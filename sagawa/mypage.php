<!--マイページ-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
</head>

<?php
session_start();
//データベース情報の読み込み
include('./conf/config.php');
$employee = array();
$temp = 0;

//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
} catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
}

$id = $_SESSION['id'];

//users_table接続
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $pdo -> prepare($sql_user);
$stmt -> bindValue(':id', $id);
$stmt -> execute();
$member = $stmt -> fetch();

//rsvdb接続
$sql_rsv = "SELECT * FROM rsvdb";
$stmt = $pdo->prepare($sql_rsv);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_rsv = "SELECT * FROM rsvdb WHERE stuid = '$id'";
$stmt = $pdo->prepare($sql_rsv);
$stmt->execute();
$stuid = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!isset($stuid)){
    echo 'NO';
    exit;
}

//empDB接続
$sql_emp = "SELECT * FROM emp_table WHERE empid in (SELECT empid FROM rsvdb )";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>マイページ<h1>
<body>
<font size="2">
<div>    
    <h2>予約確認<h2> 
        <p><?php echo $member['username']; ?> さんの予約状況</p><br>
        <div>
            <?php for ($n = 0; $n < count($stuid); $n++) { ?>
                <p>面談相手：<?php echo $employee[$n]['empname']; ?></p>
                <p>予約日：　<?php echo $stuid[$n]['rsvdate']; ?></p>
                <p>予約時間：<?php echo $stuid[$n]['rsvtime']; ?></p>
                <p>相談内容：<?php echo $stuid[$n]['comment']; ?></p>
                <!--<button onclick="location.href='./rsv_cancel.php'">予約取消</button>-->
                
                <button type="button" id="btn" value = "[$n]">予約取消</button>
                </script>
                <br><br>
            <?php } ?>
            <script type="text/javascript">
                let btn = document.getElementById('btn');
 
                btn.addEventListener('click', function() {
                let result = window.confirm('予約取り消しますか？');
 
                if (result) {
                    window.location.href = "./rsv_cancel.php";

                } else {
                    alert("取り消しをやめる");
                }
                });
            </script>
        </div>
</div>
</font>
</body>
<p><a href="./reset_pass_form.php">パスワード再登録はこちら</a></p>
<p><a href="./home.php">TOPへ</a></p>