<!DOCTYPE html>
<html>

<head>
    <?php include ($_SERVER['DOCUMENT_ROOT'] .'/project/views/common/heads/head1.html'); ?>

</head>

<body>
  <header>
    <h1 >Taskal へようこそ!</h1>
  </header>
  <main>
    <form id="login_form" name="login_form" action="views/users/check_login.php" method="POST">
      <label for="user_name">ユーザー名</label>
      <input type="text" id="user_name" name="user_name" placeholder="ユーザーID">
      <br>
      <label for="user_password">パスワード</label>
      <input type="passeord" id="user_password" name="user_password" placeholder="パスワード">
      <br>
      <input type="submit" id="login_button" name="login_button" value="ログイン">
    </form>
  </main>
    <a href = "/project/views/users/add_user.php">
      新規登録
    </a>
</body>

</html>
