<?php

session_start();

//データベース情報の読み込み
include('../conf/db_conf.php');

//データベース接続
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO($dsn, $db_username, $db_password);
    //エラー処理
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

$sql_id = "SELECT * FROM empDB WHERE empid = :empid";
$stmt = $pdo->prepare($sql_id);
$stmt->bindValue(':empid', $_POST['empid']);
$stmt->execute();
$member = $stmt->fetch();

if (!empty($member)) {

    //ファイル名をユニーク化
    $image = uniqid(mt_rand(), true);
    //アップロードされたファイルの拡張子を取得
    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
    $file = "../src/images/$image";

    $sql = "UPDATE empDB SET empimg_id = :image WHERE empid = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_POST['empid']);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);

    if (!empty($_FILES['image']['name'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../src/images/' . $image);
        if (exif_imagetype($file)) {
            $message = '画像をアップロードしました';
            $stmt->execute();
        } else {
            $message = '画像ファイルではありません';
        }

        $link = '<a href="./upload_form.php">画像登録ページへ</a>';
    }
} else {
    $message = '指定された社員IDは存在しません';
    $link = '<a href="./upload_form.php">画像登録ページへ</a>';
}

?>

<h1><?php echo $message; ?></h1>
<?php echo $link; ?>