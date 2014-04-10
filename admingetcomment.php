<head>
<meta http-equiv="Content-Type" content="text/html"charset="utf-8" />
</head>
<?php
//该文件用于网页管理端用指定的话题id和文章id返回评论内容
	require_once "Database.class.php";
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	//判断是否同时拿到了topic_id和article_id
	if(isset($_REQUEST['topic_id'])&&isset($_REQUEST['article_id']))
	{
		$topic_id=$_REQUEST['topic_id'];
		$article_id=$_REQUEST['article_id'];
		$sql="select * from ".Database::$database_comments_table." where topic_id=$topic_id and article_id=$article_id order by comment_id desc";//用comment_id倒序来确定最新的在前面
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			echo '<div style="border:1px solid black;">';
			foreach($row as $k=>$v)
			echo "$k=$v<br>";
			echo '</div>';
		}
		exit();
	}
	else
	{
		exit();
	}
?>