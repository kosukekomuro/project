<?php

try{
	$user_name = $_POST['user_name'];
	$user_pass = $_POST['user_password'];

	$user_name = htmlspecialchars($user_name, ENT_NOQUOTES, 'UTF-8');
	$user_pass = htmlspecialchars($user_pass, ENT_NOQUOTES, 'UTF-8');
	$user_pass = md5($user_pass);
	
	// ローカル環境の場合、読み込む
	//環境変数のよみこみ
	if(getenv('SERVER_NAME') == "localhost"){
		require_once '/opt/lampp/htdocs/project/vendor/autoload.php';
		$dotenv = Dotenv\Dotenv::create('/opt/lampp/htdocs/project');
		$dotenv->load();
	}

	$db['db_name'] = getenv('DATABASE_NAME');
	$db['db_host'] = getenv('DATABASE_HOST');
	$db['db_user'] = getenv('DATABASE_USER');
	$db['db_pass'] = getenv('DATABASE_PASS');

	// データベースに接続
	$dsn = "mysql:dbname=$db[db_name];host=$db[db_host];charset=utf8";
	$dbn = new PDO($dsn, $db['db_user'], $db['db_pass']);
	$dbn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//SQLの発行
	$sql = 'SELECT name, id FROM users WHERE name=? AND password=?';
	$stmt = $dbn->prepare($sql);

	$data[] = $user_name;
	$data[] = $user_pass;
	$stmt->execute($data);

	// データベースから切断する。
	$dbn = null;

	// print_r($stmt);
	// print_r($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	// print_r($rec);

	if($rec == false){
		print 'ユーザー名またはパスワードが間違っています';
		print '<a href="/opt/lampp/htdocs/project/index.php">もどる</a>';
	}else{
		// セッションの開始
		// sessionがない場合は、自動で合言葉を決める
		session_start();
		$_SESSION['login']=1;
		$_SESSION['user_name']= $rec['name'];
		$_SESSION['user_id']= $rec['id'];

		// 遷移先の画面指定
		header('Location: ../tasks/task_list.php');
	};

}catch(exception $e){
	var_dump($pdo->errorInfo()); //PDOを使っているとき
	var_dump($stmt->errorInfo()); //PDOを使っているとき
	echo mysql_error(); //mysql関数を使っているとき
	print '障害が発生しました';
	exit('データベース接続失敗。'.$e->getMessage());
};
?>
