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
$empid = $_POST['empid'];
 

//rsvdb接続
$sql_rsv = "SELECT * FROM rsvdb";
$stmt = $pdo->prepare($sql_rsv);
$stmt->execute();
$rsv = $stmt->fetchAll(PDO::FETCH_ASSOC);
//empDB接続
$sql_emp = "SELECT * FROM emp_table WHERE empid in (SELECT empid FROM rsvdb )";
$stmt = $pdo->prepare($sql_emp);
$stmt->execute();
$employee = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql =  "UPDATE rsvdb SET stuid = NULL ,comment = NULL , flag = 0 WHERE stuid = :id AND empid = :empid";
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue('id', $id);
$stmt -> bindValue('empid', $empid);
$stmt -> execute();


?>
<h1>予約キャンセルしました</h1>
<a href="./mypage.php">マイページへ</a>