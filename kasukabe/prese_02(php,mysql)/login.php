<?php
session_start();

// define variable
$mail = $_POST['mail'];
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

$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
// if password or mail is mismatch
if (!isset($member['mail']) || !password_verify($_POST['pass'], $member['pass'])) {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="./login_form.php" class="err_msg">戻る</a>';
} else if (password_verify($_POST['pass'], $member['pass'])) {
    //save the user's data in DB on SESSION
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['username'];
    $_SESSION['mail'] = $member['mail'];
    $msg = 'ログインしました。';
    $link = '<a href="./home.php">ホーム</a>';
}
?>

<div class="err_msg"><?php echo $msg; ?></div>
<?php echo $link; ?>