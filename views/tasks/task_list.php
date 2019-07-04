<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  //セッションの確認 
  check_session();

  try{
    // データベースへの接続
    $dbn = connection_to_db();

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
  <?php include ('../common/heads/head2.html'); ?>
</head>
<body>
  <div class="container-feild main-background taskal-container">
    <header class="main-header">
    </header>
    <main class="task-main">
      <h3 class="task-main__title">
        タスク一覧
      </h3>
      <?php
        print '<div class="task-main__task-list">';
        while(true){
          //$stmtからレコードを一つずつ取り出す。
          // 実行するごとに次のレコードを取り出す。
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);

          if($rec == false){
            break;
          }
          print '<form class="one-task" method="post" action="../../models/tasks/delete_task.php">';
          print '<span>'; 
          print $rec['task_name'];
          print '</span>'; 
          print '<input type="hidden" name="task_id" value=';
          print $rec['id'];
          print '>';
          print '<input type="submit" value="完了">';
          print '</form>';
        }
        print '</div>';
      ?>
      <form id="add_task_form" class="task-main__add-task-form" name="add_task_form" action="add_task.php" method="POST">
        <label for="task_name">タスク追加</label>
        <input type="text" id="task_name" name="task_name" placeholder="タスク入力">
        <input type="submit" value="作成">
      </form>
    </main>
    <footer class="main-footer">
      <a class="btn btn-primary" href="../../controllers/logout.php">ログアウト</a>
    </footer>
  </div>
</body>

</html>
