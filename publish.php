<html><!--这个是管理首页-->
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
<body style="text-align:center;">
<?php
	require_once 'Database.class.php';
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$sql="select * from topiclist";
	$res=mysql_query($sql);
?>
<form action="postfunction.php" method="post"><!--postfunction文件是专门用来管理的插入-->
内容:<br>
<textarea name="content" rows="10" cols="50"></textarea><br>
帖子所属话题：<br>
<?php
	while($row=mysql_fetch_assoc($res))
	{
		
		echo $row['topic_name'].'<input type="radio" name="topic_id" value="'.$row['topic_id'].'"><br>';
	}
	$a=microtime();
	list($t1,$t2)=explode(" ",$a);
	$t=$t1+$t2*1000;
	$t=floor($t);
	echo $t;
	
	echo '<input type="hidden" name="sendTime" value="'.$t.'">';
	echo '<input type="hidden" name="author" value="'.$admin_id.'">';
	echo '是否允许匿名：是<input type="radio" name="incognito" value="1" checked/>否<input type="radio" name="incognito" value="0"/><br>';
?>
<input type="submit" value="点击提交">
<!--
		$topic_id=$_REQUEST['topic_id'];//话题id
		$content=$_REQUEST['content'];//帖子内容
		$author=$_REQUEST['author'];//作者
		$sendTime=$_REQUEST['sendTime'];//发送时间
		$incognito=$_REQUEST['incognito'];//是否匿名-->
</form>
<?php
	$a=microtime();
	var_dump($a);
?>