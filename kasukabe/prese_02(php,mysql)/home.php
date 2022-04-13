<link rel="stylesheet" href="./style.css">

<?php
session_start();

// take over session from login.php
if (isset($_SESSION['name']) and isset($_SESSION['mail'])) {
    $username = $_SESSION['name'];
    $mail = $_SESSION['mail'];
}

// if logged in
if (isset($_SESSION['id'])) {
    $msg = 'こんにちは' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さん';
    $msg_mail = 'あなたのメールアドレスは' . htmlspecialchars($mail, \ENT_QUOTES, 'UTF-8') . 'です';
    $link = '<a href="logout.php">ログアウト</a>';
} else { //if not logged in
    $msg = 'ログインしていません';
    $link = '<a href="login.php">ログイン</a>';
}
?>

<div class="err_msg">
    <?php
    echo $msg;
    if(isset($mail)){
        echo $mail;
    }
    ?>
</div>
<?php echo $link; ?>