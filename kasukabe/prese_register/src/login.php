<?php
session_start();

// define variable
$id = $_POST['id'];
include('../conf/db_conf.php');

// for error
try {
    // PD0 is module for connecting DB
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    // output error message
    $msg = $e->getMessage();
}

$sql = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();
// if password or mail is mismatch
if (!isset($member['id']) || !password_verify($_POST['pass'], $member['password'])) {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="./login_form.php" class="err_msg">戻る</a>';
} else if (password_verify($_POST['pass'], $member['password'])) {
    //save the user's data in DB on SESSION
    $_SESSION['id'] = $member['id'];
    $msg = 'ログインしました。';
    $link = '<a href="./home.php">ホームへ</a>';
}
?>

<div class="err_msg"><?php echo $msg; ?></div>
<?php echo $link; ?>