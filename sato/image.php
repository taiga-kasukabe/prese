<?php

$empid = 1;

//データベース情報の読み込み
include('./conf/db_conf.php');

//データベース接続
try{
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $msg = $e -> getMessage();
}

$sql = "SELECT * FROM emp_table WHERE empid = :empid";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':empid', $empid);
$stmt->execute();
$image = $stmt->fetch();

?>

<h1>画像表示</h1>
<img src="imges/<?php echo $image['empimg_id']; ?>" width="300" height="300">
<a href="upload_form.php">画像アップロード</a>