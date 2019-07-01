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

      // ローカル環境の場合、読み込む
      //環境変数のよみこみ
      if(getenv('SERVER_NAME') == "localhost"){
        require_once '/opt/lampp/htdocs/project/vendor/autoload.php';
        // $dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
        $dotenv = Dotenv\Dotenv::create('/opt/lampp/htdocs/project');
        $dotenv->load();
      }

      $db['db_name'] = getenv('DATABASE_NAME');
      $db['db_host'] = getenv('DATABASE_HOST');
      $db['db_user'] = getenv('DATABASE_USER');
      $db['db_pass'] = getenv('DATABASE_PASS');

      // データベースに接続
      $dsn = "mysql:dbname=$db[db_name];host=$db[db_host];charset=utf8";
      $dbn = new PDO($dsn, $db['db_user'], $db['db_pass']);
      $dbn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //SQLの発行
      $sql = 'INSERT INTO users(name, password, created_at, updated_at) VALUES (?,?,?,?)';
      $stmt = $dbn->prepare($sql);

      $data[] = $user_name;
      $data[] = $user_pass;
      $data[] = date("Y/m/d H:i:s");
      $data[] = date("Y/m/d H:i:s");

      $stmt->execute($data);

      // データベースから切断する。
      $dbn = null;

      print $user_name;
      print 'さんを追加しました。<br>';

    }catch(Exception $e){
      // SQLのエラーは通常表示されないが、以下のようにすることで表示することができる
      // var_dump($pdo->errorInfo()); //PDOを使っているとき
      // var_dump($stmt->errorInfo()); //PDOを使っているとき
      echo mysql_error(); //mysql関数を使っているとき
      
      print 'ただいま障害により大変ご迷惑をおかけしております';
    }
  ?>

  <a href="user_list.php">もどる</a>
</body>

</html>
