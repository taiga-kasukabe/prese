<?php
session_start();

// delete all SESSION's item
$_SESSION = array();

// destroy session
session_destroy();
?>

<p>ログアウトしました。</p>
<a href="login_form.php">ログインへ</a>