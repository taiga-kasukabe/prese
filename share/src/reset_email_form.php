<!--リセット用メアド入力画面-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再登録画面</title>
</head>

<h1>パスワードを再登録します。</h1>
<h2>登録したメールアドレスを入力してください</h2>
<h3>
<form action="reset_email.php" method="post" class="form_log">
    <!--<div>
        <label>ログインID：</label>
        <input type="text" name="id" required>
    </div>-->
    <div>
        <label>メールアドレス：</label>
        <input type="text" name="mail" value=""  required>
    </div>
</h3>
<input type="submit" value="確認">