<?php
  //セッションの確認 
  session_start();
  // セッションの合言葉を変える命令。
  session_regenerate_id(true);

  if(isset($_SESSION['login'])==false){
    print 'ログインしていません。<br>';
    print '<a href="../../">ログイン画面へ</a>';
    exit();
  }else{
    print $_SESSION['user_name'];
    print "さん,こんにちは。";
    print '<br>';
  }

  try{
    // ローカル環境の場合、読み込む
    //環境変数のよみこみ
    if(getenv('SERVER_NAME') == "localhost"){
      require_once '/opt/lampp/htdocs/project/vendor/autoload.php';
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
    $sql = 'SELECT task_name, id FROM tasks WHERE user_id = ?';
    $stmt = $dbn->prepare($sql);

    $data[] = $_SESSION['user_id'];
    
    // stmtには検索したデータの一覧が代入うされている
    $stmt->execute($data);
    
    // データベースから切断する。
    $dbn = null;
    
  }catch(Exception $e){
    print 'ただいま障害により大変ご迷惑をおかけしています。';
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
  <a href="../../controllers/logout.php">ログアウト</a>
  <br>
  タスク一覧
  <br>
  <?php
    while(true){
      //$stmtからレコードを一つずつ取り出す。
      // 実行するごとに次のレコードを取り出す。
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if($rec == false){
        break;
      }
      print $rec['task_name'];
      print '<form method="post" action="../../models/tasks/delete_task.php">';
      print '<input type="hidden" name="task_id" value=';
      print $rec['id'];
      print '>';
      print '<input type="submit" value="削除">';
      print '</form>';
      print '<br>';
    }
  ?>
  <form id="add_task_form" name="add_task_form" action="add_task.php" method="POST">
    <label for="task_name">タスク追加</label>
    <input type="text" id="task_name" name="task_name" placeholder="タスク入力">
    <input type="submit" value="作成">
  </form>
</body>

</html>
