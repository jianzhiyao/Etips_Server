<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="utf-8"/>
<style>
*{
	margin:auto;
}
</style>
<title>
新增话题php页面
</title>
</head>
<body style="text-align:center;">
<?php
	require_once 'Database.class.php';
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$new_topic=$_REQUEST['new_topic'];
	$sql='insert into '.Database::$database_topiclist_table.' (topic_name,click_amount)  values("'.$new_topic.'",0)';
	mysql_query($sql) or die(mysql_error());
	echo '插入成功，一秒后跳到主页面';
	header("REFRESH:1;URL=http://etipsweb.duapp.com/ETipsproject/index.php");
 	exit();
?>