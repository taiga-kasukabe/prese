<h1>画像アップロード</h1>

<!-- エラーメッセージ出力 -->
<h3>
    <font color="c7243a">
        <?php
        session_start();
        if (!empty($_SESSION['err'])) {
            foreach ($_SESSION['err'] as $value) {
                echo $value . "<br>";
            }
        }
        session_destroy();
        ?>
    </font>
</h3>

<!-- 実行はupload.php -->
<form action="./upload.php" method="post" enctype="multipart/form-data">
    <p>アップロード画像</p>
    <input type="file" name="image">
    <input type="submit" name="upload" value="送信">
</form>
