<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  // //セッションの確認 
  check_session();

  $_POST=sanitize($_POST);
  // print_r($post);
  $task_name= $_POST['task_name'];

  //todo jsで入力チェックを行う
  if($task_name == ''){
    print 'タスク名が空欄です';
  }else{

    try{

      // データベースへの接続
      $dbn = connection_to_db();

      // todo taskの詳細をのちに追加
      $sql='INSERT INTO tasks(task_name, user_id) VALUES(?, ?)';
      $stmt = $dbn->prepare($sql);

      $data[] = $task_name;
      $data[] = $_SESSION['user_id'];

      // var_dump($data);
      // print '<br>';

      $stmt->execute($data);
      $dbn = null;

      // 遷移先を指定
      header('Location: task_list.php');

    }catch(Exception $e){
      // var_dump($pdo->errorInfo()); //PDOを使っているとき
      // var_dump($stmt->errorInfo()); //PDOを使っているとき
      // echo mysql_error(); //mysql関数を使っているとき
      print 'ただいま障害により大変ご迷惑をおかけしております';
    }
  }
?>
