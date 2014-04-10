<?php
/*返回每一个话题最新的帖子*/
	require_once "Database.class.php";
	require_once "status.class.php";
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$sql="select * from ".Database::$database_topiclist_table;
	$res=mysql_query($sql);
	$topic_amount=mysql_affected_rows();//获取话题数
	$i;
	$topic;//话题详细内容的存放数组
	$article;//存放所得的帖子
	//获得话题的详细资料
	for($i=0;$i<$topic_amount;$i++){
		$topic[$i]=mysql_fetch_assoc($res);
	}
	//获取对应话题最新帖子的内容
	for($i=0;$i<$topic_amount;$i++){
		$sql="select * from ".Database::$database_topic_table." where topic_id=".$topic[$i]['topic_id']." order by article_id desc limit 0,1";
		$res=mysql_query($sql);
		$article[$i]=mysql_fetch_assoc($res);
	}
	//如果没有最新帖子返回null
	for($i=0;$i<$topic_amount;$i++){
		if(!$article[$i])
		$article[$i]=NULL;
	}
	$show['status']=200;
	$show['response']=$article;
	echo json_encode($show);
	exit();
	
?>