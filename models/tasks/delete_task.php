<?php
  // 共通の関数読み込み;
  require_once('../../common/common.php');

  //セッションの確認 
  check_session();

  try{
    // データベース接続
    $dbn = connection_to_db();

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
