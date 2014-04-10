<?php
//这是一个注册账号的文件
	require_once 'status.class.php';
	require_once 'Database.class.php';
	if(isset($_REQUEST['nickname']))
	$nickname=$_REQUEST['nickname'];//匿名
	if(isset($_REQUEST['account']))
	$account=$_REQUEST['account'];//邮箱
	if(isset($_REQUEST['id']))
	$id=$_REQUEST['id'];//学号
	if(isset($_REQUEST['psw']))
	$psw=$_REQUEST['psw'];//密码
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$st;
	//判断邮箱格式是否异常
	if(!preg_match("/(.+)@(\w+)\.([a-zA-Z]{2,})/",$account))
	{
		$st=array('status'=>206);//设置状态的关联数组
		$show['status']=$st['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
	$s=new Status();//获取状态实体
	$status=$s->getStatus($nickname,$account,$id);
	if($status=='200')
	{//返回代表正常信息的json格式信息
		$sql="insert into ".Database::$database_user_table." values('".$nickname."','".$account."','".$id."','".$psw."')";
		mysql_query($sql);
		$st=array('status'=>$status);//设置状态的关联数组
		$show['status']=$st['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
	else if($status=='201')
	{//返回代表错误信息的json格式信息
		$st=array('status'=>$status);//设置状态的关联数组
		$show['status']=$st['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
	else if($status=='207')
	{
		$st=array('status'=>$status);//设置状态的关联数组
		$show['status']=$st['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
	
	
?>