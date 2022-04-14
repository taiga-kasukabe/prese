<?php
    
// 変数定義
//各種入力情報，正規表現，エラーメッセージ配列
include("./conf/variable.php");

// POST送信が～じゃなかったとき（送信があったとき）以下の処理を実行する
if(!empty($_POST)){

    // バリデーションチェックを行う
    // Email正規表現
    if (!preg_match($mail_pattern, $mail)) {
        $err_msg['mail_expression'] = '正しいメールアドレスを入力してください';
    }

    // Email(再)が一致するか
    if ($mail != $mail_confirm) {
        $err_msg['mail_confirm'] = 'メールアドレス(再入力)が一致しません';
    }

    // telが0から始まり10or11文字か
    if (!preg_match($tel_pattern, $tel) || strlen($tel) != 10 || strlen($tel) != 11) {
        $err_msg['tel_confirm'] = '正しい電話番号を入力してください';
    }

    // パスワードは6文字以上255文字以内か
    if(strlen($password) > 255 || strlen($password) < 5){
        $err_msg['password'] = '6文字以上255文字以内で入力してください';
    }

    // パスワードの文字数を確認
    if (strlen($password) < 8 || !preg_match("/^[a-zA-Z0-9]+$/", $password)) {
        $err_msg['pass_length'] = '8文字以上の半角英数字を入力してください';
    }

    // エラーメッセージが空の時（バリデーションチェックが問題なかった時）以下の処理を行う
    if(empty($err_msg)){

          //マイページへ遷移
          //URLの書き方！！
          header('Location:http://localhost/pre/prese/sato/signup_confirm.php');

    }
}

?>

<!DOCTYPE html> 
<html lang="ja"> 

<!-- ヘッダ情報 -->
<head>
    <!-- 文字コードをUTF-8に設定 -->
    <meta charset="UTF-8">     
    <!-- ページのタイトルをtestに設定 -->
    <title>新規登録</title>
</head>

<body>
<h1>新規会員登録</h1>
<form action="signup_confirm.php" method="POST">
    
    <!-- エラーメッセージを出力するPHPをグループ化しerr_msgという識別名を付ける -->
    <div class="err_msg"> 
        <?php 
            foreach($err_msg as $value)
            echo $value;
            echo "\n";
        ?> 
    </div>

    <div>
        <label>姓名</label>
        <input type="text" name="username" required>
    </div>

    <div>
        <label>姓名（カナ）</label>
        <input type="text" name="username_kana" required>
    </div>

    <div>
        <label>メールアドレス</label>
        <input type="text" name="mail" required>
    </div>

    <div>
        <label>メールアドレス（再入力）</label>
        <input type="text" name="mail_confirm" required>
    </div>

    <div>
        <label>電話番号</label>
        <input type="text" name="tel" required>
    </div>

    <div>
        <label>学校名</label>
        <input type="text" name="school" required>
    </div>

    <div>
        <label>学部（研究科）</label>
        <input type="text" name="department1" required>
    </div>

    <div>
        <label>学科（専攻）</label>
        <input type="text" name="department2" required>
    </div>

    <div>
        <!-- プルダウン？が良さそう。選ぶやつ。 -->
        <label>学年</label>
        <input type="text" name="student_year" required>
    </div>

    <div>
        <label>ID</label>
        <input type="text" name="id" required>
    </div>

    <div>
        <label>パスワード</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>パスワード（再入力）</label>
        <input type="password" name="password_confirm" required>
    </div>

    <input type="submit" value="確認">
</form>
</body>

</html>