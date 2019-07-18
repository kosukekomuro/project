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
      <button type="button" onclick="history.back()">戻る</button>
      <input type="submit" value="OK">
    </form>
</body>

</html>
