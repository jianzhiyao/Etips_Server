<?php
//此文件是一个返回状态Status的一个类
	require_once 'Database.class.php';
	class Status{
		public static $status=array('200','201','202','203','204','205','206','207');//正常，该账号或邮箱或学号已存在，修改没有在有效时间内，发布失败（各种原因）,密码错误，邮箱不存在，邮箱格式有误,用户学号id已经被注册
		
		//判断匿名,邮箱，id是否存在函数
		public function getStatus($nickname,$account,$id){
			$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
			//通过id抓信息
			$sql="select * from ".Database::$database_user_table." where id='".$id."'";
			$res=mysql_query($sql) or die(mysql_error());
			$row=mysql_fetch_assoc($res);
			if($row)
			{
				echo 7;
				return self::$status[7];
			}
			$sql="select * from ".Database::$database_user_table.' where nickname='."'".$nickname."' or account='".$account."'";
			$res=mysql_query($sql) or die(mysql_error());
			$row=mysql_fetch_assoc($res);
			if(!$row)
			{	
				return self::$status[0];//不存在返回正常信号
			}
			else
			{
				return self::$status[1];//存在返回错误信号
			}
		}
		//判断有效时间函数
		public function judgeTime($time){
			$currentTime=date("U");
			if($currentTime>$time)
			return self::$status[2];
		}
		
	}
?>