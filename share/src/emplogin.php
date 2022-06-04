<?php

session_start();

$eid = $_POST['eid'];
include('../conf/config.php');

//DB内でPOSTされたメールアドレスを検索
try {
  //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //エラー処理
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

$sql = "SELECT * FROM emplogin WHERE eid = :eid";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':eid', $eid);
$stmt->execute();
$member = $stmt->fetch();
 
if (!isset($member['eid']) || $_POST['epass'] != $member['epassword']) {
    $msg = 'idもしくはパスワードが間違っています。';
    $link = '<a href="./emplogin_form.php" class="err_msg">戻る</a>';
}   
else if (($_POST['epass'] = $member['epassword'])) {
    //save the user's data in DB on SESSION
    $_SESSION['eid'] = $member['eid'];
    $msg = 'ログインしました。';
    $link = '<a href="./registerFree_form.php?week=0">ホームへ</a>';
}
?>

<div class="err_msg"><?php echo $msg; ?></div>
<?php echo $link; ?>
