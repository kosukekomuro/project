<!DOCTYPE html>
<html>

<head>
    <?php include ('views/common/heads/head1.html'); ?>
</head>

<body>
  <div class="container-feild main-background taskal-container">
    <header class="index-header">
      <img src="assets/image/main-logo.png">
    </header>
    <main class="login">
      <form id="login_form" class="login-form" name="login_form" action="views/users/check_login.php" method="POST">
        <input type="text" id="user_name" class="login-form__name" name="user_name" placeholder="ユーザー名">
        <input type="password" id="user_password" class="login-form__password" name="user_password" placeholder="パスワード">
        <input type="submit" id="login_button" class="login-form__login-btn" name="login_button" value="ログイン">
        <a class="login-form__signup-btn" href ="/project/views/users/add_user.php">
          <span>新規登録</span>
        </a>
      </form>
    </main>
  </div>
</body>

</html>
