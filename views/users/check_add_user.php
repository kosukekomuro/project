<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
  <?php
    require_once('../../common/common.php');

    // 特殊文字をHTMLエンティティに変換する。
    $_POST=sanitize($_POST);

    // 前の画面からの変数受け取り
    $user_name = $_POST['user-name'];
    $user_pass = $_POST['password'];
    $user_confirm_pass = $_POST['confirm-pass'];
    $check_flag = true;

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
      print '<input type="hidden" name="user_name" value = "'.$user_name.'">';
      print '<input type="hidden" name="password" value = "'.$user_pass.'">';
      print '<br>';
      print '<input type="button" onclick="history.back()" value="もどる">';
      print '<input type="submit" value="OK">';
      print '</form>';
    }
  ?>
</body>

</html>
