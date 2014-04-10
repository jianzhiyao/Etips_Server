<?php
//该文件用于返回某个账号所得到的评论，包括帖子的评论还有评论的评论
	require_once "Database.class.php";
	require_once "status.class.php";
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	//判断是否同时拿到了topic_id和article_id
	$response;
	if(isset($_REQUEST['author'])&&isset($_REQUEST['op']))
	{
		$author=$_REQUEST['author'];
		$op=$_REQUEST['op'];
		switch($op)
		{
			case "check":{
				$sql="select * from ".Database::$database_user_table." where id='$author'";
				$res=mysql_query($sql);
				$row=mysql_fetch_assoc($res);
				//var_dump($row['tips']);
				echo json_encode(array('status'=>200,'response'=>array($row['tips'])));
			};break;
			case 'clear':{
				$sql="update ".Database::$database_user_table." set tips='0' where id='$author'";
				$res=mysql_query($sql) or die();
				echo json_encode(array('status'=>200,'response'=>array()));
			};break;
		}
	}
	else
	{
		echo json_encode(array('status'=>210,'response'=>array(NULL)));
	}
?>