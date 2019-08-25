<?php
  /**
   * ユーザーの存在チェック
   * @param string name
   * @param string password
   * @return array
   *            int code 結果コード
   *            string error_message
   *
   * @author komuro
   **/
  function authenticate_user($name, $password){

    try{
      // データベースに接続
      $dbn = connection_to_db();

      // SQLの準備
      $sql = 'SELECT id FROM users WHERE name = ? AND  password = ?';
      $stmt = $dbn->prepare($sql);
      $data[] = $name;
      $data[] = $password;

      // stmtには検索したデータの一覧が代入されている
      $stmt->execute($data);
      $count = $stmt->rowCount();

      // データベースから切断する。
      $dbn = null;

    }catch(Exception $e){

      // その他のエラー時の戻り値
      $return_data = [
        'error_message' => $e,
        'code' => 4
      ];

      return $return_data;
    }

    // 正常時の戻り値
    // sqlが正しく稼働した場合、正常反応を返す
    $return_data = [
      'stmt' => $stmt,
      'count' => $count,
      'error_message' => "",
      'code' => 1
    ];

    return $return_data;
  };

  /**
   * ユーザーの重複登録チェック
   * @param string name
   * @param string password
   * @return array
   *            int code 結果コード
   *            string error_message
   *
   * @author komuro
   **/
  function user_registration_confirmation($name){

    try{
      // データベースに接続
      $dbn = connection_to_db();

      // SQLの準備
      $sql = 'SELECT id FROM users WHERE name = ?';
      $stmt = $dbn->prepare($sql);
      $data[] = $name;

      // stmtには検索したデータの一覧が代入されている
      $stmt->execute($data);
      $count = $stmt->rowCount();

      // データベースから切断する。
      $dbn = null;

    }catch(Exception $e){

      // その他のエラー時の戻り値
      $return_data = [
        'error_message' => $e,
        'code' => 4
      ];

      return $return_data;
    }

    // 正常時の戻り値
    // sqlが正しく稼働した場合、正常反応を返す
    $return_data = [
      'stmt' => $stmt,
      'count' => $count,
      'error_message' => "",
      'code' => 1
    ];

    return $return_data;
  };
?>
