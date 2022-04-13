<?php

//use session
session_start();

// regular expression for email
// if there is no "<>", error occur
$pattern = "</^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$/>";

//initialize variable
$email = '';
$password = '';
$err_msg = array();
$data = array(
  'email' => 'taiga.kasukabe@gmail.com',
  'password' => 'taiga'
);

// judge POST
if (!empty($_POST)) {
  // 各データを変数に格納
  $email = $_POST['email'];
  $password = $_POST['password'];

  // checking email validation
  // checking empty
  if ($email === '') {
    $err_msg['email'] = '入力してください';
  }
  // checking length
  if (strlen($email) > 255) {
    $err_msg['email'] = '255文字以下で入力してください';
  }
  // checking regular expression
  if (!preg_match($pattern, $email)) {
    $err_msg['email'] = 'メルアド形式を入力してください';
  }

  // checking password validation
  // checking empty
  if ($password === '') {
    $err_msg['password'] = '入力してください';
  }
  // checking length
  else if (strlen($password) > 255 || strlen($password) < 5) {
    $err_msg['password'] = '６文字以上２５５文字以内で入力してください';
  }
  // checking regular expression
  else if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
    $err_msg['password'] = '半角英数字で入力してください';
  }
}

// if validation is OK
if (empty($err_msg)) {
  if (($data['password'] === $password) and ($data['email'] === $email)) {
    // insert email into SESSION
    $_SESSION['email'] = $email;
    //go to my page
    header('Location: ./mypage.php');
    exit;
  } else {
    $err_msg['email'] = 'emailが違います';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="./style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in </title>
</head>

<body>
  <h1>ログイン画面</h1>
  <form action="" method="post">
    <div class="err_msg">
      <?php
      if (!empty($err_msg['email']))
        echo $err_msg['email'];
      ?>
    </div>
    <label for=""><span>メールアドレス</span>
      <input type="text" name="email" id=""><br>
    </label>
    <div class="err_msg">
      <?php
      if (!empty($err_msg['password']))
        echo $err_msg['password'];
      ?>
    </div>
    <label for=""><span>パスワード</span>
      <input type="text" name="password" id=""><br>
    </label>
    <input type="submit" value="送信">
  </form>
</body>

</html>