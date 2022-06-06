<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <meta charset="UTF-8">     
    <title>ログイン</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="./css/emplogin_form.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">   
</head>

<h1>社員ログインページ</h1>
<form action="./emplogin.php" method="post">
    <div>
        <label>ログインID：</label>
        <input type="text" name="eid" required>
    </div>
    <div>
        <label>パスワード：</label>
        <input type="password" name="epass" required>
    </div>
    <input type="submit" value="ログイン"><br>
</form>