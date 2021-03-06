<!DOCTYPE html>
<html lang="ja">

<!-- ヘッダ情報 -->

<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://necolas.github.io/normalize.css">
    <link rel="stylesheet" href="../../css/student/register_form.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Noto+Sans+JP:wght@300&family=Shippori+Mincho&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="bg">
            <img src="../../images/ntt-east_white.png" id="logo">
        </div>
        </script>
    </header>

    <main>
        <div class="container">
            <p>SIGN UP</p>
            <form action="./validation.php" method="POST">
                <div class="err_msg">
                    <?php
                    session_start();
                    // エラーメッセージが空じゃないの時（バリデーションチェックが問題なかった時）以下の処理を行う
                    if (!empty($_SESSION['err'])) {
                        foreach ($_SESSION['err'] as $value) {
                            echo $value . "<br>"; //hタグ内の改行はbr
                        }
                    }
                    ?>
                </div>

                <?php
                if (!empty($_SESSION['user'])) {
                    include("../../conf/variable_session.php");

                    session_destroy();
                }
                ?>

                <div>
                    <label>姓名</label>
                    <input type="text" name="username" value="<?php if (!empty($username)) {
                                                                    echo $username;
                                                                } ?>" required>
                </div>

                <div>
                    <label>姓名（カナ）</label>
                    <input type="text" name="username_kana" value="<?php if (!empty($username_kana)) {
                                                                        echo $username_kana;
                                                                    } ?>" required>
                </div>

                <div>
                    <label>メールアドレス</label>
                    <input type="text" name="mail" value="<?php if (!empty($mail)) {
                                                                echo $mail;
                                                            } ?>" required>
                </div>

                <div>
                    <label>メールアドレス（再入力）</label>
                    <input type="text" name="mail_confirm" value="<?php if (!empty($mail_confirm)) {
                                                                        echo $mail_confirm;
                                                                    } ?>" required>
                </div>

                <div>
                    <label>電話番号</label>
                    <input type="text" name="tel" placeholder="ハイフンなし半角" value="<?php if (!empty($tel)) {
                                                                echo $tel;
                                                            } ?>" required>
                </div>

                <div>
                    <label>学校名</label>
                    <input type="text" name="school" value="<?php if (!empty($school)) {
                                                                echo $school;
                                                            } ?>" required>
                </div>

                <div>
                    <label>学部（研究科）</label>
                    <input type="text" name="department1" value="<?php if (!empty($department1)) {
                                                                        echo $department1;
                                                                    } ?>" required>
                </div>

                <div>
                    <label>学科（専攻）</label>
                    <input type="text" name="department2" value="<?php if (!empty($department2)) {
                                                                        echo $department2;
                                                                    } ?>" required>
                </div>

                <div>
                    <!-- プルダウン？が良さそう。選ぶやつ。 -->
                    <label>学年</label>
                    <input type="text" name="student_year" value="<?php if (!empty($student_year)) {
                                                                        echo $student_year;
                                                                    } ?>" required>
                </div>

                <div>
                    <label>ID</label>
                    <input type="text" name="id" placeholder="半角英数字4文字以上" value="<?php if (!empty($id)) {
                                                                                        echo $id;
                                                                                    } ?>" required>
                </div>

                <div>
                    <label>パスワード</label>
                    <input type="password" name="password" placeholder="半角英数字8文字以上" value="" required>
                </div>

                <div>
                    <label>パスワード（再入力）</label>
                    <input type="password" name="password_confirm" placeholder="半角英数字8文字以上" value="" required>
                </div>

                <button type="submit" id="submit">確認</button>

                <div class="terms">
                    <a href="./terms/tos.php" target="_blank" rel="noopener noreferrer">会員規約</a>
                </div>

            </form>
        </div>
    </main>
</body>

</html>