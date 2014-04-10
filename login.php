<?php
/*验证登录信息*/
	require_once "Database.class.php";
	require_once "status.class.php";
	$account=$_REQUEST['account'];
	$psw=$_REQUEST['psw'];
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$sql="select * from ".Database::$database_user_table." where account='".$account."'";
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	$status;
	$show;
	if(!preg_match("/(.+)@(\w+)\.([a-zA-Z]{2,})/",$account))
	{
		$st=array('status'=>206);//设置状态的关联数组
		$show['status']=$st['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
	if(!$row)
	{
		//无账号返回205错误
		$status=array('status'=>Status::$status[5]);
		$row=NULL;
	}
	else
	{
		if($row['psw']==$psw)
		{
			$status=array('status'=>Status::$status[0]);//有账号且密码正确返回200
		}
		else
		{
			$status=array('status'=>Status::$status[4]);//密码不正确返回204
			$row=NULL;
		}
	}
	//最后输出jason格式的状态值
	$show['status']=$status['status'];
	$show['response']=array($row);
	echo json_encode($show);
?>