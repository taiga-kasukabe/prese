<link rel="stylesheet" href="./style.css">

<?php
session_start();
// define variable
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$dsn = "mysql:charset=UTF8;dbname=presedb;host=localhost";
$username = "root";
$password = "root";

// for error
try {
    // PD0 is module for connecting DB
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    // output error message
    $msg = $e->getMessage();
}

// check mail address
$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql); // 'stmt' = statement, 'prepare' is just prepare sql
$stmt->bindValue(':mail', $mail); //substitute $mail for :mail
$stmt->execute(); //execute the sql sentence
$member = $stmt->fetch(); //fetch results about sql sentence
if (!isset($member['mail'])) {
    // if not exist, insert(registration)
    // "isset()" is checking NULL or not
    // var_dump($member['mail']);
    $sql = "INSERT INTO users (username, mail, pass) VALUES (:name, :mail, :pass)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':pass', $pass);
    $stmt->execute();
    $msg = '会員登録が完了しました';
    $link = '<a href="./login_form.php">ログインページ</a>';
} else if ($member['mail'] === $mail) {
    $msg = '同じメールアドレスが存在します．';
    $link = '<a href="./index.php" class="err_msg">戻る</a>';
}
?>

<!--メッセージの出力-->
<div class="err_msg">
    <?php echo $msg; ?>
</div>

<?php echo $link; ?>