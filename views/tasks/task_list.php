<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  //セッションの確認 
  check_session();

  try{
    // データベースへの接続
    $dbn = connection_to_db();

    //SQLの発行
    $sql = 'SELECT task_name, id, task_order FROM tasks WHERE user_id = ? ORDER BY task_order';
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
    <div class="detail_task">
      <form id="detail_task_form" class="add-detail-task-form" name="add_detail_task_form" action="../../models/tasks/add_task_detail.php" method="POST">
        <input type="text" id="detail_task_name" name="detail_task_name" placeholder="タスク名" class="add-detail-task-form__task-name" cols="40">
        <textarea id="task_discription" name="task_discription" placeholder="タスク詳細" class="add-detail-task-form__task-discription", cols="40" rows="8"></textarea>
        <input type="datetime-local" id="task_due_date" name="task_due_date" placeholder="期限" class="add-detail-task-form__task-due-date">
        <div class="add-detail-task-form__btn">
          <input type="submit" value="作成" class="add-detail-task-form__btn--blue">
          <input type="button" class="add-detail-task-form__btn--blue add-detail-task-form__cancel-btn" value="キャンセル">
        </div>
      </form>
    </div>
    <div class="update_task">
      <form id="update_task_form" class="update-task-form" name="update_task_form" action="../../models/tasks/update_task.php" method="POST">
        <input type="text" id="update_task_name" name="update_task_name" placeholder="タスク名" class="update-task-form__task-name" cols="40">
        <textarea id="task_discription" name="task_discription" placeholder="タスク詳細" class="update-task-form__task-discription", cols="40" rows="8"></textarea>
        <input type="datetime-local" id="task_due_date" name="task_due_date" placeholder="期限" class="update-task-form__task-due-date">
        <input type="hidden" name="task_id" class="update-task-form__task-id">
        <div class="update-task-form__btn">
          <input type="submit" value="作成" class="update-task-form__btn--blue">
          <input type="button" class="update-task-form__btn--blue update-task-form__cancel-btn" value="キャンセル">
        </div>
      </form>
    </div>
    <header class="main-header">
    </header>
    <main class="task-main">
      <h3 class="task-main__title">
        タスク一覧
      </h3>
      <?php
        print '<ul class="task-main__task-ul">';

        $num = 0;
        while(true){
          //$stmtからレコードを一つずつ取り出す。
          //実行するごとに次のレコードを取り出す。
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);

          if($rec == false){
            break;
          }
          print '<li class="task-list" draggable="true">';
          print '<form class="one-task" method="post" action="../../models/tasks/delete_task.php">';
          print '<span>'; 
          print $rec['task_name'];
          print '</span>'; 
          print "<input type='hidden' class='task_info' name='task_id' value={$rec['id']} task_order = {$rec['task_order']}" ;
          print '>';
          print '<div>';
          print "<input type='button' class='one-task__update-btn' value='変更' task_id = {$rec['id']}> ";
          print '<input type="submit" value="完了">';
          print '</div>';
          print '</form>';
          print '</li>';
          $num += 1;

        }
        print '</ul>';
      ?>
      <form id="add_task_form" class="task-main__add-task-form" name="add_task_form" action="add_task.php" method="POST">
        <label for="task_name">タスク追加</label>
        <input type="text" id="task_name" name="task_name" placeholder="タスク入力" class="task-name">
        <input type="submit" value="作成">
        <input type="button" class="make-task-details" value="詳細作成">
      </form>
      <footer class="main-footer">
        <a class="btn btn-primary" href="../../controllers/logout.php">ログアウト</a>
    </footer>
    </main>
  </div>

  <!-- jsの読み込み -->
  <!-- ページの表示速度を上げるため最後に読み込む -->
  <script type="text/javascript" src="../../assets/js/main.js"></script>
</body>

</html>
