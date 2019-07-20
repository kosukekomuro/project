<!DOCTYPE html>
<html>

<head>
  <?php include ('../common/heads/head2.html'); ?>
</head>

<body>
  <div class="container-feild main-background taskal-container">
    <header class="index-header">
        <img src="../../assets/image/main-logo.png">
    </header>
    <main class="sign-up">
      <h1 class="sign-ip__title">ユーザー登録</h1>
      <form method = "post" action = "check_add_user.php" class="sign-up-form" name="sign_up_form">
        <input type="text" name="user_name" placeholder="ユーザー名" class="sign-up-form__name">
        <input type="password" name="user_password" placeholder="パスワード" class="sign-up-form__password">
        <input type="password" name="user_confirm_password" placeholder="再確認パスワード" class="sign-up-form__confirm-password">
        <div class = "sign-up-form__btn">
          <input type="submit" value="登録" class="sign-up-form__btn--blue">
          <button type="button" onclick="history.back()" class="sign-up-form__btn--blue">戻る</button>
      </div>
      </form>
    </main>
  </div>  
</body>

</html>
