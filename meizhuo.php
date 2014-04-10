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
	echo '话题列表<br>';
	$sql='select * from '.Database::$database_topiclist_table;
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
		echo '<a href="adminShowTopic.php?topic_id='.$row['topic_id'].'">'.$row['topic_name'].'</a>'.'点击量:'.$row['click_amount'].'<br>';
		echo '<br><br><br><a href="addTopic.html">增加话题</a>';
	mysql_free_result($res);

?>
<br>
<br><br>

<br>
<form action="publish.php" method="post">
<input type="submit" value="发布帖子">
</form>
</html>