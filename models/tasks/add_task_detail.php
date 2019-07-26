<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  //セッションの確認 
  check_session();

  $_POST=sanitize($_POST);
  $task_name= $_POST['detail_task_name'];
  $task_discription = $_POST['task_discription'];
  $task_due_date =($_POST['task_due_date'] != "")? $_POST['task_due_date']: NULL;
  //todo jsで入力チェックを行う
  if($task_name == ''){
    print 'タスク名が空欄です';
  }else{

    try{
      // データベースへの接続
      $dbn = connection_to_db();

      //SQLの発行
      $sql = 'SELECT task_name, id, task_order FROM tasks WHERE user_id = ? ORDER BY task_order DESC LIMIT 1';
      $stmt = $dbn->prepare($sql);
      $data[] = $_SESSION['user_id'];
      
      // sqlの実行
      $stmt->execute($data);

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      $data = array();

      // todo taskの詳細をのちに追加
      $sql='INSERT INTO tasks(task_name, task_discription, user_id, due_date, task_order) VALUES(?, ?, ?, ?, ?)';
      $stmt = $dbn->prepare($sql);

      $data[] = $task_name;
      $data[] = $task_discription;
      $data[] = $_SESSION['user_id'];
      $data[] = $task_due_date;

      if($rec == true){
        $data[] = $rec['task_order'] + 1;
      }else{
        $data[] = 0;
      }

      $stmt->execute($data);
      $dbn = null;

      // 遷移先を指定
      header('Location: ../../views/tasks/task_list.php');

    }catch(Exception $e){
      var_dump($pdo->errorInfo()); //PDOを使っているとき
      var_dump($stmt->errorInfo());
      echo mysql_error(); //mysql関数を使っているとき
      print 'ただいま障害により大変ご迷惑をおかけしております';
    }
  }
?>
