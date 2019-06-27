<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
  <?php
    // 前の画面からの変数受け取り
    $user_name = $_POST['user-name'];
    $user_pass = $_POST['password'];
    $user_confirm_pass = $_POST['confirm-pass'];
    $check_flag = true;

    // 特殊文字をHTMLエンティティに変換する。
    $user_name = htmlspecialchars($user_name, ENT_NOQUOTES, 'UTF-8');
    $user_pass = htmlspecialchars($user_pass, ENT_NOQUOTES, 'UTF-8');
    $user_confirm_pass = htmlspecialchars($user_confirm_pass, ENT_NOQUOTES, 'UTF-8');

    //ユーザー名の登録確認
    if($user_name == ''){
      print 'ユーザー名が入力されていません。 <br>';
      $check_flag = false;
    }else{
      print 'ユーザー名：';
      print $user_name;
      print '<br>';
    };

    // パスワードの確認
    if($user_pass == ''){
      print 'パスワードが入力されていません。 <br>';
      $check_flag = false;
    };

    // パスワードの一致確認
    if($user_confirm_pass != $user_pass ){
      print 'パスワードが一致しません <br>';
      $check_flag = false;
    };

    if($check_flag == false){

      print '<form>';
      print '<input type="button" onclick = "history.back()" value="もどる">';
      print '</form>';

    }else{

      $user_pass = md5($user_pass);

      print '<form method="post" action="done_add_user.php">';
      print '<input type="hidden" name="name" value = "'.$user_name.'">';
      print '<input type="hidden" name="pass" value = "'.$user_pass.'">';
      print '<br>';
      print '<input type="button" onclick="history.back()" value="もどる">';
      print '<input type="submit" value="OK">';
      print '</form>';
    }
  ?>
</body>

</html>
