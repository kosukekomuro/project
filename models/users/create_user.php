<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  $_POST=sanitize($_POST);

    try{
      $user_name = $_POST['user_name'];
      $user_pass = $_POST['user_password'];

      // $user_name = htmlspecialchars($user_name, ENT_NOQUOTES, 'UTF-8');
      // $user_pass = htmlspecialchars($user_pass, ENT_NOQUOTES, 'UTF-8');

      // データベースに接続
      $dbn = connection_to_db();

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

      // セッションの開始
		  // sessionがない場合は、自動で合言葉を決める
      session_start();
      $_SESSION['login']=1;
      $_SESSION['user_name']= $rec['name'];
      $_SESSION['user_id']= $rec['id'];
  
      // 遷移先の画面指定
      header('Location: ../../views/tasks/task_list.php');

    }catch(Exception $e){
      // SQLのエラーは通常表示されないが、以下のようにすることで表示することができる
      // var_dump($pdo->errorInfo()); //PDOを使っているとき
      // var_dump($stmt->errorInfo()); //PDOを使っているとき
      echo mysql_error(); //mysql関数を使っているとき
      
      print 'ただいま障害により大変ご迷惑をおかけしております';
    }
  ?>
