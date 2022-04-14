<!--ログイン画面-->
<h1 style="text-align:center;margin-top: 0em;margin-bottom: 1em;" class="h1_log">ログインしてください</h1>
   <form action="login.php" method="post" class="form_log">
     <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br>
     <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br>
     <button type="submit" class="log_button">ログインする</button>
   </form>

<!--新規登録-->
<h1 style="text-align:center;margin-top: 2em;margin-bottom: 1em;" class="h1_log">初めての方はこちら</h1>
<form action="register.php" method="post" class="form_log">
     <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br>
     <!--<input type="text" name="name" class="textbox un" placeholder="名前"><br>-->
     <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br>
     <button type="submit" class="log_button">新規登録する</button>
     <p style="text-align:center;margin-top: 1.5em;">※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
</form>
<p>すでに登録済みの方は<a href="login.php">こちら</a></p>
