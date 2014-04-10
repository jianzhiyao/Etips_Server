<head>
<meta http-equiv="Content-Type" content="text/html"charset="utf-8" />
</head>
<?php
	/*该文件同于初次使用新建数据库*/
	require_once "Database.class.php";
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_query("set names utf8");
	mysql_query("create database ".Database::$selectdatabase);
	mysql_select_db(Database::$selectdatabase);
	sql_create_user_table(Database::$database_user_table,$conn);//新建用户table
	sql_create_topiclist_table(Database::$database_topiclist_table,$conn);//新建话题表
	sql_create_topic_table(Database::$database_topic_table,$conn);//话题内容
	sql_create_comments_table(Database::$database_comments_table,$conn);//评论表
	sql_create_clickamount_table(Database::$database_click_amount_table,$conn);//话题点击量储存
	echo "建表完成";
?>