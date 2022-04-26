<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>画像アップロード</title>
</head>

<body>
<h1>画像アップロード</h1>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <div>
        <label>社員id：</label>
        <input type="text" name="empid" value="" required>
    </div>
    <p>アップロード画像</p>
    <input type="file" name="image">
    <button><input type="submit" name="upload" value="送信"></button>
</form>
</body>
</html>