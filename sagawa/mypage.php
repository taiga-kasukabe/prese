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
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_rsv = "SELECT * FROM rsvdb WHERE stuid = '$id'";
$stmt = $pdo->prepare($sql_rsv);
$stmt->execute();
$stuid = $stmt->fetchAll(PDO::FETCH_ASSOC);

//empDB接続
$sql_emp = "SELECT * FROM emp_table WHERE empid in (SELECT empid FROM rsvdb WHERE stuid = '$id')";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

//ename
$sql_emp = "SELECT * FROM emp_table";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$ename = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>マイページ<h1>
<body>
<font size="2">
<div>    
    <h2>予約確認<h2> 
        <p><?php echo $member['username']; ?> さんの予約状況</p><br>
        <div>
            <?php for ($n = 0; $n < count($stuid); $n++) { ?>
                
                <?php for($i = 0; $i < count($ename); $i++) { 
                        if($stuid[$n]['empid'] == $ename[$i]['empid']){ ?>
                           <p>面談相手：<?php echo $ename[$i]['empname']; ?></p>
                    <?php } } ?>
                <?php $rsvtime=$stuid[$n]['rsvdate']?>
                    
                <p>予約日：　<?php echo $stuid[$n]['rsvdate']; ?></p>
                <p>予約時間：<?php echo $stuid[$n]['rsvtime']; ?></p>
                <p>相談内容：<?php echo $stuid[$n]['comment']; ?></p>

                <?php if($rsvtime <= date('Y-m-d',strtotime("+2day"))):?>
                    <p>予約日2日前以降は予約の取り消しは出来ません。</p>
                    <p>これ以降は直接連絡をお取りください。</p>
                <?php else:?>
                <form action="./rsv_cancel.php" method="post" onSubmit = "return check()">
                <input type="submit" value="取消">
                <input type="hidden" name="empid" value="<?=$stuid[$n]['empid']?>">
                </form>
                
                <?php endif; ?>

                </script>
                <br><br>
            <?php } ?>
            <script type="text/javascript">
                function check() {
                let result = window.confirm('予約取り消しますか？');
                if (result) {
                    return ture;
                } else {
                    alert("取り消しをやめる");
                    return false;
                }
                };
            </script>
        </div>
</div>
</font>
</body>
<p><a href="./reset_pass_form.php">パスワード再登録はこちら</a></p>
<p><a href="./withdrawal_form.php">退会はこちら</a></p>
<p><a href="./home.php">HOMEへ</a></p>