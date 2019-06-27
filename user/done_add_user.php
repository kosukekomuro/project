<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
  <?php

    try{
      $user_name = $_POST['user_name'];
      $user_pass = $_POST['password'];

      $user_name = htmlspecialchars($user_name, ENT_NOQUOTES, 'UTF-8');
      $user_pass = htmlspecialchars($user_pass, ENT_NOQUOTES, 'UTF-8');

      // データベースに接続
      $dsn = 'mysql:dbname=heroku_3eeeee4567fdbd1;host=us-cdbr-iron-east-02.cleardb.net;charset=utf8';
      $user = 'b34326d2a64349';
      $passwoed = 'a19be61d';
      $dbn = new PDO($dsn, $user, $passwoed);
      $dbn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      //SQLの発行
      $sql = 'INSERT INTO users(name, password, created_at, updated_at) VALUES (?,?,?,?)';
      $stmt = $dbn->prepare($sql);

      $data[] = $user_name;
      $data[] = $user_pass;
      $data[] = date("Y/m/d H:i:s");
      $data[] = date("Y/m/d H:i:s");
      print_r($data);

      $stmt->execute($data);

      // データベースから切断する。
      $dbn = null;

      print $user_name;
      print 'さんを追加しました。<br>';

    }catch(Exception $e){
      // SQLのエラーは通常表示されないが、以下のようにすることで表示することができる
      // var_dump($pdo->errorInfo()); //PDOを使っているとき
      var_dump($stmt->errorInfo()); //PDOを使っているとき
      echo mysql_error(); //mysql関数を使っているとき
      
      print 'ただいま障害により大変ご迷惑をおかけしております';
      
      // 強制終了
      // exit();
    }
  ?>

  <a href="user_list.php">もどる</a>
</body>

</html>
