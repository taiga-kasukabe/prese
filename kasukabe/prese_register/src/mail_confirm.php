<?php
$id = $_SESSION['user']['id'];
?>

<h1>登録しました</h1>
<p>登録ID名：<?php echo $id; ?></p><br>
<p>登録完了しました．<br>先ほど登録完了メールを送りました．<br>ご確認ください</p><br>
<p>こちらのリンクからログインしてください</p>
<a href="./login_form.php">ログインページへ</a>