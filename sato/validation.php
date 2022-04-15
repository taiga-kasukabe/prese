<?php

session_start();

    //データベース情報
    //あとでわける
    $dsn = "mysql:host=localhost; dbname=presedb; charset=utf8;";
    $username1 = "root";
    $password = "";

    //データベース接続
    try{
        $dbh = new PDO($dsn, $username1, $password);
    } catch (PDOException $e) {
        $msg = $e -> getMessage();
    }
        
    // 変数定義
    //各種入力情報，正規表現，エラーメッセージ配列
    include("./conf/variable.php");

    // バリデーションチェックを行う
    // username_kanaがカナのみか
    if(!preg_match("/^[ァ-ヾ]+$/u", $username_kana)){
        $err_msg['username_kana'] = '姓名(カナ)にはカタカナを入力してください';
    }

    // Email正規表現
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        $err_msg['mail_expression'] = '正しいメールアドレスを入力してください';
    }

    // DBにEmailが重複していないか確認
    $sql_mail = "SELECT * FROM users_table WHERE mail = :mail";
    $stmt = $dbh->prepare($sql_mail); // spl文を準備
    $stmt->bindValue(':mail', $mail); // :mailに$mailを代入
    $stmt->execute(); // sql文実行
    $member = $stmt->fetch(); // sql文の結果をfetch
    if (!empty($member)) {
        $err_msg['mail_duplicate'] = 'このメールアドレスは既に登録されています';
    }

    // Email(再)が一致するか
    if ($mail != $mail_confirm) {
        $err_msg['mail_confirm'] = 'メールアドレス(再入力)が一致しません';
    }

    // telバリデーション
    if (!preg_match($tel_pattern, $tel)) {
        $err_msg['tel_confirm'] = '正しい電話番号を入力してください';
    }

    // tel重複確認
    $sql_tel = "SELECT * FROM users_table WHERE tel = :tel";
    $stmt = $dbh->prepare($sql_tel);
    $stmt->bindValue(':tel', $tel);
    $stmt->execute();
    $member = $stmt->fetch();
    if (!empty($member)){
        $err_msg['tel_duplicate'] = 'この電話番号は既に登録されています';
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
    } elseif (!empty($member)) {
        $err_msg['id_duplicate'] = 'このIDは既に登録されています';
    }

    // パスワード文字数正規表現
    if (strlen($_POST['password']) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
        $err_msg['pass_length'] = 'パスワードは8文字以上の半角英数字を入力してください';
    }

    // パスワード(確認)が一致するか
    if ($_POST['password'] != $_POST['password_confirm']){
        $err_msg['pass_confirm'] = 'パスワード(確認)が一致しません';
    }

    // SESSIONにerr_msgとuser情報を代入して引き継ぐ
    $_SESSION['err'] = array();
    $_SESSION['err'] = $_SESSION['err'] + $err_msg;

    $_SESSION['user'] = array();
    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['username_kana'] = $username_kana;
    $_SESSION['user']['mail'] = $mail;
    $_SESSION['user']['mail_confirm'] = $mail_confirm;
    $_SESSION['user']['tel'] = $tel;
    $_SESSION['user']['school'] = $school;
    $_SESSION['user']['department1'] = $department1;
    $_SESSION['user']['department2'] = $department2;
    $_SESSION['user']['student_year'] = $student_year;
    $_SESSION['user']['id'] = $id;
    $_SESSION['user']['password'] = $password;
    $_SESSION['user']['password_confirm'] = $password_confirm;
    $_SESSION['user']['password_row'] = $_POST['password'];
    $_SESSION['user']['password_confirm_row'] = $_POST["password_confirm"];


    // エラーメッセージが空の時（バリデーションチェックが問題なかった時）以下の処理を行う
    if(empty($_SESSION['err'])){

        //確認ページへ遷移
        //URLの書き方！！
        header('Location:http://localhost/prese/sato/signup_confirm.php');

    } else {
        header('Location:http://localhost/prese/sato/signup.php');
    }

?>
