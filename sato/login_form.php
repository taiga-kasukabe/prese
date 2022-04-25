<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>ログインページ</title>
</head>

<h1>ログインページ</h1>

<form action="login.php" method="POST">
<div>
    <label>ログインID：</label>
    <input type="text" name="id" required>
</div>
<div>
    <label>パスワード：</label>
    <input type="text" name="password" required>
</div>
<input type="submit" value="ログイン">
</form>