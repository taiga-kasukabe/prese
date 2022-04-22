<?php
function connectDB(){
    include("./db_conf.php");

    // エラー対処
    try {
        // DBに接続
        $dbh = new PDO($dsn, $db_username, $db_password);
    } catch (PDOException $e) {
        // エラーログ出力
        $err_msg['db_error'] = $e->getMessage();
    }
}