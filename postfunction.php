<head>
<meta http-equiv="content-type" content="text/html" charset="utf-8"/>
<style>
*{
	margin:auto;
}
</style>
<title>
管理页面
</title>
</head>
<?php
/*该文件用于publish文件的帖子发布*/
	require_once "Database.class.php";
	require_once "status.class.php";
	//少了提交参数不予插入
	if(isset($_REQUEST['topic_id'])&&isset($_REQUEST['content'])&&isset($_REQUEST['author'])&&isset($_REQUEST['sendTime'])&&isset($_REQUEST['incognito']))
	{	//接受参数
		$topic_id=$_REQUEST['topic_id'];//话题id
		$content=$_REQUEST['content'];//帖子内容
		$author=$_REQUEST['author'];//作者
		$sendTime=$_REQUEST['sendTime'];//发送时间
		$incognito=$_REQUEST['incognito'];//是否匿名
		$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
		mysql_select_db(Database::$selectdatabase);
		mysql_query("set names utf8");
		$sql="insert into ".Database::$database_topic_table." (topic_id,sendTime,author,incognito,comments,content) values ('".$topic_id."','".$sendTime."','".$author."','".$incognito."','0','".$content."')";//初始评论数为0
		$res=mysql_query($sql);
		if(!$res)//插入错误情况
		{
			$s=array('status'=>Status::$status[3]);
			$show['status']=$s['status'];
			$show['response']=array(null);
			echo json_encode($show);
			exit();
		}
		if(mysql_affected_rows()>0)
		{
			$s=array('status'=>Status::$status[0]);
			$show['status']=$s['status'];
			$show['response']=array(null);
			echo json_encode($show);
			echo '<script type="text/javascript">alert("发布成功"); </script>';
			header("REFRESH:0.1;URL=publish.php");
			exit();
		}
	}
	else
	{
		//少了参数立即输出203错误
		$s=array('status'=>Status::$status[3]);
		$show['status']=$s['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
	
?>