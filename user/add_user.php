<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>はじめてのphp</title>
</head>

<body>
    <h1>ユーザー登録!</h1>
    <form method = "post" action = "check_add_user.php">
      <p>ユーザー名を入力してください</p>
      <input type="text" name="user-name" style="width:200px">
      <p>パスワードを入力してください</p>
      <input type="password" name="password" style="width:100px">
      <p>再度パスワードを入力してください。</p>
      <input type="password" name="confirm-pass" style="width:100px">
      <br>
      <input type="button" onlclick="history.back()" value="もどる">
      <input type="submit" value="OK">
    </form>
    <?php 
      require_once __DIR__.'/../vendor/autoload.php';
      $dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
      $dotenv->load();

      print "<pre>\n";
      print_r($_SERVER);
      print "</pre>\n";
    ?>
</body>

</html>
