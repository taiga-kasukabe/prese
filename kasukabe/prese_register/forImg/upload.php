<?php
include("../conf/db_conf.php");

// エラー対処
try {
    // DBに接続
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    // エラーログ出力
    $err_msg['db_error'] = $e->getMessage();
}

if (isset($_POST['upload'])) {
    $image = uniqid(mt_rand(), true); //ファイル名をユニーク化
    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1); //アップロードされたファイルの拡張子を取得
    $file = "./images/$image";

    $sql = "INSERT INTO images (name) VALUES (:image)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);

    if (!empty($_FILES['image']['name'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image); //imagesディレクトリにファイル保存
        if (exif_imagetype($file)) { //画像ファイルかどうかチェック
            $message = '画像をアップロードしました';
            $stmt->execute();
        } else {
            $message = '画像ファイルではありません';
        }
    }
}
?>
<a href="./upload_form.php">画像をアップロード</a>