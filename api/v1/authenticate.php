<!-- ユーザー認証API -->

<?php
/**
 * 結果をjsonで返却する
 *
 * @param  array resultArray 返却値
 * @return string jsonで表現されたレスポンス
 * @author kobayashi
 **/
function returnJson($resultArray){
  if(array_key_exists('callback', $_GET)){
    $json = $_GET['callback'] . "(" . json_encode($resultArray) . ");";
  }else{
    $json = json_encode($resultArray);
  }
  header('Content-Type: text/html; charset=utf-8');
  echo  $json;
  exit(0);
}



/**
 * ユーザの一覧をjsonで返す
 *
 * @param string email(user_name)  password
 * @return array
 *          object root
 *            object  result 結果ノード
 *              int code 結果コード
 * 
 *            object user_info  ユーザ情報(処理成功次にのみ返却)
 *              user_id         ユーザID
 *              user_name       ユーザー名
 *              email           メールアドレス
 *
 * @author komuro
 **/
//---------------------------------------------------------
//  処理の開始
//---------------------------------------------------------
//  値の取得（リクエストの受付）
$type = $_REQUEST['user_type'];

//  ユーザリストの初期化
$user_list = [];
//  返却値の初期化
$result = [];

try {
  //  値の検証
  if (empty($type)) {
    throw new Exception("no type...");
  }

  //  ユーザリストの作成
  switch ($type) {
    case 'a':
    case 'admin':
      $user_list = [
        ['name'=>'中居','age'=>18]
      ];
      break;
    case 'o':
    case 'operator':
      $user_list = [
        ['name'=>'木村','age'=>17],
        ['name'=>'森','age'=>16]
      ];
      break;
    case 'g':
    case 'guest':
      $user_list = [
        ['name'=>'香取','age'=>14],
        ['name'=>'草薙','age'=>15],
        ['name'=>'稲垣','age'=>15],
        ['name'=>'岡田','age'=>15],
        ['name'=>'森田','age'=>15],
        ['name'=>'三宅','age'=>15],
        ['name'=>'長野','age'=>15],
        ['name'=>'坂本','age'=>15],
        ['name'=>'井ノ原','age'=>15]
      ];
      break;
    default:
      //  不正な値
      throw new Exception("Invalid value...");
      break;
  }

  //  返却値の作成
  $result = [
    'result' => 'OK',
    'users' => $user_list
  ];
} catch (Exception $e) {
  $result = [
    'result' => 'NG',
    'message' => $e->getMessage()
  ];
}

//  JSONでレスポンスを返す
returnJson($result);
