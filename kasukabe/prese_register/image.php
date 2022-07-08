<?php
include("./conf/db_conf.php");
$id = 3150;

// エラー対処
try {
    // DBに接続
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    // エラーログ出力
    $err_msg['db_error'] = $e->getMessage();
}

$sql = "SELECT * FROM empDB WHERE empid = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$image = $stmt->fetch();
?>

<h1>画像表示</h1>
<img src="./forImg/images/<?php echo $image['empimg_id']; ?>" alt="社員画像">