<?php


session_start();

$id = $_POST['id'];
include('./conf/config.php');

//DB内でPOSTされたメールアドレスを検索
try {
  //インスタンス化（"データベースの種類:host=接続先アドレス, dbname=データベース名,charset=文字エンコード" "ユーザー名", "パスワード", opt)
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  //エラー処理
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

  $sql = "SELECT * FROM users_table WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  $member = $stmt->fetch();
  // if password or mail is mismatch
  if (!isset($member['id']) || !password_verify($_POST['pass'], $member['password'])) {
      $msg = 'メールアドレスもしくはパスワードが間違っています。';
      $link = '<a href="./login_form.php" class="err_msg">戻る</a>';
  } else if (password_verify($_POST['pass'], $member['password'])) {
      //save the user's data in DB on SESSION
      $_SESSION['id'] = $member['id'];
      $msg = 'ログインしました。';
      $link = '<a href="./home.php">ホームへ</a>';
  }
  ?>
  
  <div class="err_msg"><?php echo $msg; ?></div>
  <?php echo $link; ?>