<?php
  $task_name= $_POST['task_name'];
  // print_r($_POST);
  $task_name = htmlspecialchars($task_name, ENT_QUOTES, 'UTF-8');

  //todo jsで入力チェックを行う
  if($task_name == ''){
    print 'タスク名が空欄です';
  }else{

    try{

      if(getenv('SERVER_NAME') == "localhost"){
        require_once '/opt/lampp/htdocs/project/vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::create('/opt/lampp/htdocs/project');
        $dotenv->load();
      }

      $db['db_name'] = getenv('DATABASE_NAME');
      $db['db_host'] = getenv('DATABASE_HOST');
      $db['db_user'] = getenv('DATABASE_USER');
      $db['db_pass'] = getenv('DATABASE_PASS');

      var_dump($db);
      print('<br>');

      // データベースに接続
      $dsn = "mysql:dbname=$db[db_name];host=$db[db_host];charset=utf8";
      $dbn = new PDO($dsn, $db['db_user'], $db['db_pass']);
      $dbn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // todo taskの詳細をのちに追加
      $sql='INSERT INTO tasks(task_name, user_id) VALUES(?, ?)';
      $stmt = $dbn->prepare($sql);

      $data[] = $task_name;
      $data[] = 2;

      var_dump($data);
      print '<br>';

      $stmt->execute($data);

      $dbn = null;

    }catch(Exception $e){
      // var_dump($pdo->errorInfo()); //PDOを使っているとき
      // var_dump($stmt->errorInfo()); //PDOを使っているとき
      // echo mysql_error(); //mysql関数を使っているとき
      print 'ただいま障害により大変ご迷惑をおかけしております';
    }
  }
?>
