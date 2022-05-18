<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再登録</title>
</head>
<?php

session_start();
//データベース情報の読み込み
include('./conf/config.php');
//データベースへ接続、テーブルがない場合は作成
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
} catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
}

//$id = $_SESSION['id'];

//users_table接続
//$sql_user = "SELECT * FROM users_table WHERE id = :id";
//$stmt = $pdo -> prepare($sql_user);
//$stmt -> bindValue(':id', $id);
//$stmt -> execute();
//$member = $stmt -> fetch();
?>

<h1>パスワード再登録画面</h1>
<form action="reset_vali_pass.php" method="post" class="form_log"> 
<!--<p>こんにちは、<?php echo $member['username']; ?> さん</p>-->
<div>
    <div>
        <label>ログインID：</label>
        <input type="text" name="id" required>
    </div>
        <label>パスワード：</label>
        <input type="password" name="password"  required>＊８文字以上の半角英数字
    </div>
    <div>
        <label>パスワード（再入力）：</label>
        <input type="password" name="password_confirm" required>＊８文字以上の半角英数字
    </div>

<div>
<input type="submit" value="登録">