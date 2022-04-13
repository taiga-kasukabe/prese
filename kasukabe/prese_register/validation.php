<?php
session_start();

// 変数定義
include("./conf/variable.php");
// DB定義
include("./conf/db_conf.php");

// エラー対処
try {
    // DBに接続
    $dbh = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    // エラーログ出力
    $err_msg['db_error'] = $e->getMessage();
}


// Email正規表現
if (!preg_match($mail_pattern, $mail)) {
    $err_msg['mail_expression'] = '正しいメールアドレスを入力してください';
}

// DBに接続
$sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
$stmt = $dbh->prepare($sql_mail); // spl文を準備
$stmt->bindValue(':mail', $mail); // :mailに$mailを代入
$stmt->execute(); // sql文実行
$member = $stmt->fetch(); // sql文の結果をfetch
// DBにEmailが重複していないか確認
if (isset($member)) {
    $err_msg['mail_duplicate'] = 'このメールアドレスは既に登録されています';
}

// Email(再)が一致するか
if ($mail != $mail_confirm) {
    $err_msg['mail_confirm'] = 'メールアドレス(再入力)が一致しません';
}

// telが0から始まり10or11文字か
if (!preg_match($tel_pattern, $tel) || strlen($tel) != 10 || strlen($tel) != 11) {
    $err_msg['tel_confirm'] = '正しい電話番号を入力してください';
}

// DBに接続
$sql_id = "SELECT * FROM users_table WHERE id = :id";
$stmt = $dbh->prepare($sql_id);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();
// idが4文字以上半角英数字か
if (!preg_match("/^[a-zA-Z0-9]+$/", $id) || strlen($id) < 4) {
    $err_msg['id_confirm'] = 'idは4文字以上の半角英数字を入力してください';
} elseif (isset($member)) {
    $err_msg['id_duplicate'] = 'このIDは既に登録されています';
}

// パスワードの文字数を確認
if (strlen($password) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $password)) {
    $err_msg['pass_length'] = '8文字以上の半角英数字を入力してください';
}

?>

<!--メッセージの出力-->
<div class="err_msg">
    <?php 
    foreach($err_msg)
    echo $msg; ?>
</div>

<?php echo $link; ?>