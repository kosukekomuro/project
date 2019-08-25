<?php

// ユーザー認証API
/**
 * 結果をjsonで返却する
 *
 * @param  array resultArray 返却値
 * @return string jsonで表現されたレスポンス
 * @author komuro
 **/
function returnJson($resultArray){
  // array_key_exists - 指定したキーまたは添字が配列にあるかどうかを調べる 存在する場合、trueを返す。

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
 * @param string user_email(user_name)
 * @param string user_password
 * @return array
 *          object  result 結果ノード
 *            int code 結果コード
 * 
 *          object user_info  ユーザ情報(処理成功次にのみ返却)
 *            user_id         ユーザID
 *            user_name       ユーザー名
 *
 * @author komuro
 **/
//---------------------------------------------------------

// 共通の関数読み込み;
require_once('../../../common/common.php');
require_once('../../../models/users/users.php');

$_REQUEST=sanitize($_REQUEST);

//  値の取得（リクエストの受付）
$user_name = $_REQUEST['user_name'];

// ユーザー散財チェック
$user_register_confirm_result = user_registration_confirmation($user_name);


// //  ユーザリストの初期化
// $user_list = [];
//  返却値の初期化
$result = [];

// 認証時のカウントが1以上の場合, （重複）エラー
if($user_register_confirm_result['count'] >= 1){
  $result =[
    'result' => [
      'code' => 3
    ]
  ];

  //  JSONでレスポンスを返す
  returnJson($result);
}

$result =[
  'result' => [
    'code' => $user_register_confirm_result['code'],
  ],
  'user_info' => [
    'user_name' => $user_name,
    'request' => $_REQUEST,
    'post' => $_POST,
    'get' => $_GET,
    'stmt' => $user_register_confirm_result['stmt'],
    'count' => $user_register_confirm_result['count'],
    'error' => $user_register_confirm_result['error_message']
  ]
];

//  JSONでレスポンスを返す
returnJson($result);
//---------------------------------------------------------
