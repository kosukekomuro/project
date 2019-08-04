<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  //セッションの確認 
  check_session();

  $_POST=sanitize($_POST);

  $task_id = $_POST['task_id'];
  $task_name= $_POST['update_task_name'];
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
      $sql = 'UPDATE tasks 
       SET task_name = ?, task_discription = ? , due_date = ?
       WHERE id = ? AND user_id = ?';

      $stmt = $dbn->prepare($sql);
      $data[] = $task_name;
      $data[] = $task_discription;
      $data[] = $task_due_date;
      $data[] = $task_id;
      $data[] = $_SESSION['user_id'];
      
      
      // sqlの実行
      $stmt->execute($data);

      // dbの接続を閉じる
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
