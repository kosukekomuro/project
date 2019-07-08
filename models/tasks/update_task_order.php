<?php
  header("Content-Type: application/json; charset=UTF-8");

  // 共通の関数読み込み;
  require_once('../../common/common.php');

  //Todoセッションの確認を行う？
  // phpのajaxでセッション管理を行うにはどうしたらいいか？
  // check_session();

  // データの受け取り
  $_POST=sanitize($_POST);
  $task_id= $_POST['task_id'];
  $task_order= $_POST['task_order'];

  // tasksテーブルのorder順を変更
  try{

    // データベースへの接続
    $dbn = connection_to_db();

    //SQLの発行
    $sql = 'UPDATE tasks SET task_order = ? WHERE id = ?';
    $stmt = $dbn->prepare($sql);
    $data[] = $task_order;
    $data[] = $task_id;
    // $data[] = $_SESSION['user_id'];
    
    //stmtには検索したデータの一覧が代入されている
    // sqlの実行
    $stmt->execute($data);
  }catch(Exception $e){
    var_dump($pdo->errorInfo()); //PDOを使っているとき
    var_dump($stmt->errorInfo()); //PDOを使っているとき
    echo mysql_error(); //mysql関数を使っているとき
    print 'ただいま障害により大変ご迷惑をおかけしております';
  };

  echo json_encode($_POST); //jsonオブジェクト化。

  exit;
?>
