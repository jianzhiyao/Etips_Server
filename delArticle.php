<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="utf-8"/>
<style>
*{
	margin:auto;
}
</style>
<title>
删除文章php页面
</title>
</head>
<body style="text-align:center;">
<?php
	require_once 'Database.class.php';
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$article_id=$_REQUEST['article_id'];
	//删除该话题的文章内容
	$sql="delete from ".Database::$database_topic_table." where article_id=".$article_id;
	mysql_query($sql);
	//且要删除所对应评论
	$sql="delete from ".Database::$database_comments_table." where article_id=".$article_id;
	echo '1秒后返回原来页面';
	header("REFRESH:1;URL=".$_SERVER['HTTP_REFERER']);
?>