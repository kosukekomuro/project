<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Taskal</title>
</head>

<body>
  <header>
    <h1>Taskal へようこそ!</h1>
  </header>
  <main>
    <form id="login_form" name="login_form" action="" method="POST">
      <label for="user_id">ユーザーID</label>
      <input type="text" id="user_id" name="user_id" placeholder="ユーザーID">
      <br>
      <label for="user_password">パスワード</label>
      <input type="passeord" id="user_password" name="user_password" placeholder="パスワード">
      <br>
      <input type="submit" id="login_button" name="login_button" value="ログイン">
    </form>
  </main>
    <a href = "/project/user/add_user.php">
      新規登録
    </a>
    <div>
      <?php
        require_once __DIR__.'/vendor/autoload.php';
        // echo dirname(__DIR__);
        $dotenv = Dotenv\Dotenv::create(__DIR__);
        $dotenv->load();
        print_r(getenv('CLEARDB_DATABASE_URL'));
        // print "<pre>\n";
        // print_r($_SERVER);
        // print "</pre>\n";
        // $dotenv->load();
        // echo $_ENV['CLEARDB_DATABASE_URL'];    // http://hoge.example.com
      ?>
    </div>
</body>

</html>
