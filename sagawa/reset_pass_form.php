<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再登録</title>
</head>

<h1>パスワード再登録画面</h1>
<form action="reset_vali_pass.php" method="post" class="form_log"> 
<div>
        <label>パスワード：</label>
        <input type="password" name="password"  required>＊８文字以上の半角英数字
    </div>
    <div>
        <label>パスワード（再入力）：</label>
        <input type="password" name="password_confirm" required>＊８文字以上の半角英数字
    </div>

<div>
<input type="submit" value="登録">