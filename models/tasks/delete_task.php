<?php

  //セッションの確認 
  session_start();
  // セッションの合言葉を変える命令。
  session_regenerate_id(true);

  if(isset($_SESSION['login'])==false){
    print 'ログインしていません。<br>';
    print '<a href="../../">ログイン画面へ</a>';
    exit();
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
    $sql = 'DELETE FROM tasks WHERE id = ?';
    $stmt = $dbn->prepare($sql);

    $data[] = $_POST['task_id'];
    
    // stmtには検索したデータの一覧が代入されている
    $stmt->execute($data);
    
    // データベースから切断する。
    $dbn = null;

    // 遷移先を指定
    header('Location: ../../views/tasks/task_list.php');
    
  }catch(Exception $e){
    print 'ただいま障害により大変ご迷惑をおかけしています。';
    exit();
  }

?>
