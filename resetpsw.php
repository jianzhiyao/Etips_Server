<?php
//这里是重设密码的文件
	require_once 'status.class.php';
	require_once 'Database.class.php';
	if(isset($_REQUEST['account']))
	$account=$_REQUEST['account'];
	if(isset($_REQUEST['resetpsw']))
	$resetpsw=$_REQUEST['resetpsw'];
	if(isset($_REQUEST['validtime']))
	{
	$validtime=$_REQUEST['validtime'];
	$s=new Status();//状态获取类
	if($s->judgeTime($validtime)=='202')
	{
		$st=array('status'=>'202');
		$show['status']=$st['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();//有效期过了，异常退出
	}
	}
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$sql="select * from ".Database::$database_user_table." where account='".$account."'";
	$res=mysql_query($sql,$conn) or die(mysql_error());//
	if($res)
	{
		$sql="update ".Database::$database_user_table." set psw='".$resetpsw."' where account='".$account."'";
		$res1=mysql_query($sql) or die(mysql_error());
		mysql_free_result($res);
		if(mysql_affected_rows()>0)
		{
			$st=array('status'=>'200');
			$show['status']=$st['status'];
			$show['response']=array(null);
			echo json_encode($show);
			exit();//正常退出程序
		}
	}
	exit();
?>