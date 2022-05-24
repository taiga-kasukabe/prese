<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録取り消し</title>
</head>
<?php
session_start();
include("./conf/config.php");
try {
    //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    //エラー処理
    } catch (Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }

$id = $_SESSION['id'];    

$sql =  "UPDATE rsvdb SET stuid = NULL ,comment = NULL , flag = 0 WHERE stuid = '$id' AND empid in (SELECT empid FROM users_table WHERE empname = )";
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue(':id', $id);
$stmt -> execute();

?>