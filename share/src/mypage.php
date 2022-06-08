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
include('../conf/config.php');
$employee = array();
$temp = 0;

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}


$id = $_SESSION['id'];

//users_table接続
// ログインしている学生のデータ取得
$sql_user = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh -> prepare($sql_user);
$stmt -> bindValue(':id', $id);
$stmt -> execute();
$member = $stmt -> fetch();

//rsvdb接続
// rsvdbのデータを全て取得
$sql_rsv = "SELECT * FROM rsvdb";
$stmt = $dbh->prepare($sql_rsv);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// rsvdbのうちログインしている学生の予約データのみ取得
$sql_rsv = "SELECT * FROM rsvdb WHERE stuid = '$id'";
$stmt = $dbh->prepare($sql_rsv);
$stmt->execute();
$stuid = $stmt->fetchAll(PDO::FETCH_ASSOC);

//empDB接続
// rsvdbのうちログインしている学生が予約しているデータのempidを取得し，
// それと一致するempidのデータをemp_tableから取得する
$sql_emp = "SELECT * FROM emp_table WHERE empid in (SELECT empid FROM rsvdb WHERE stuid = '$id')";
$stmt = $dbh->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);

//ename
// emp_tableの情報をすべて取得する
$sql_emp = "SELECT * FROM emp_table";
$stmt = $dbh->prepare($sql_emp);
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
                <p>予約日：　<?php echo $stuid[$n]['rsvdate']; ?></p>
                <p>予約時間：<?php echo $stuid[$n]['rsvtime']; ?></p>
                <p>相談内容：<?php echo $stuid[$n]['comment']; ?></p>
                <form action="./rsv_cancel.php" method="post" onSubmit = "return check()">
                <input type="submit" value="取消">
                <input type="hidden" name="empid" value="<?=$stuid[$n]['empid']?>">
                </form>
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