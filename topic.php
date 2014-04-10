<?php
//这里是一个显示信息页面
	require_once "Database.class.php";
	$p=new Page();//一个分页处理的类对象
	$date=date("Ymd");
	$response;//存返回值
	if(isset($_REQUEST['page'])&&isset($_REQUEST['topic_id']))
	{
		$page=$_REQUEST['page'];
		$topic_id=$_REQUEST['topic_id'];
		$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
		mysql_select_db(Database::$selectdatabase);
		mysql_query("set names utf8");
		$sql="update ".Database::$database_topiclist_table." set click_amount=click_amount+1 where topic_id='$topic_id'";
		mysql_query($sql);//使话题总点击量加一
		//<取到话题代号，日期已存在则使话题点击量加一，日期不存在使新建日期
		$sql="select * from ".Database::$database_click_amount_table." where date='$date' and topic_id='$topic_id'";//查找看有没有对应的话题id和日期
		$row=mysql_fetch_assoc(mysql_query($sql));
		if($row)
		{
			$sql="update ".Database::$database_click_amount_table." set click_amount=click_amount+1 where topic_id='$topic_id' and date='$date'";
			mysql_query($sql);
		}
		else
		{
			$date=date("Ymd");
			$sql="insert into ".Database::$database_click_amount_table." (topic_id,date,click_amount) values('$topic_id','$date',1)";//日期格式为年月日，如19940513
			mysql_query($sql,$conn) or die(mysql_error());
		}
		//>(与上一行注释对应)
		$sql="select * from ".Database::$database_topic_table." where topic_id=$topic_id";
		mysql_query($sql);
		$rows=mysql_affected_rows();//获取所对应topic_id信息行数
		$p->max_page=ceil($rows/Page::$page_size);//最大页数，往上取整，如1.2取2
		//除了页码范围直接内容返回空
		if($page<1||$page>$p->max_page)
		{
			$show['status']=200;//一定正常
			$show['response']=array(null);
			echo json_encode($show);
			exit();
		}
		$sql="select * from ".Database::$database_topic_table." where topic_id='".$topic_id."' order by article_id desc limit ".($page-1)*Page::$page_size.",".Page::$page_size;//倒序取第（($page-1)*Page::$page_size）到第（($page-1)*Page::$page_size）+10行信息,总共十条信息
	$res=mysql_query($sql) or die(mysql_error());
		$i=0;
		while($row=mysql_fetch_assoc($res))
		{
			$s="select * from user where id='".$row['author']."'";
			$r=mysql_query($s);
		    $ro=mysql_fetch_assoc($r);
			$row['nickname']=$ro['nickname'];
			$response[$i++]=$row;//存储row中信息
		}
		$show['status']=200;//一定正常
		$show['response']=$response;
		echo json_encode($show);
	}
	mysql_free_result($res);
?>