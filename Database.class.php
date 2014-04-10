<?php
/*该文件用于设定数据库的一些信息，系统所用数据库名等都是从此文件传出 !!*/
/* $_SERVER['SERVER_NAME']='localhost';//重置服务器名
	class Database{
		static $database_username='root';//所用数据库名
		static $database_userpassword='';//所用数据库密码	
		static $selectdatabase='etips';//所选数据库
		static $database_user_table='user';//用户名表
		static $database_topiclist_table='topiclist';//话题表
		static $database_topic_table='topic';//帖子内容
		static $database_comments_table='comments';//帖子评论
		static $database_click_amount_table='clickamount';//点击量
}*/
	/*该文件用于设定数据库的一些信息，系统所用数据库名等都是从此文件传出*/
	$admin_id="1008601";//管理员id
	$_SERVER['SERVER_NAME']='sqld.duapp.com:4050';//重置服务器名
	class Database{
		static $database_username='dlh7tgVk6rMKZmneXZ754SGl';//所用数据库名
		static $database_userpassword='AmRWwQcf8cnMaGPW3CIMPep5dA8R6Ico';//所用数据库密码	
		static $selectdatabase='WzcjBJMzjCBReguGlRUD';//所选数据库
		static $database_user_table='user';//用户名表
		static $database_topiclist_table='topiclist';//话题表
		static $database_topic_table='topic';//帖子内容
		static $database_comments_table='comments';//帖子评论
		static $database_click_amount_table='clickamount';//点击量
	}
	class Page{
		static $page_size=10;
		public $page_count;
		public $max_page;
		public $now_page;
		static $a=0;
		public $move;
	}
	//一些创建表的函数
	function sql_create_user_table($table,$conn)
	{
		$sql="CREATE TABLE $table (nickname varchar(15) not null,account varchar(30) not null,id varchar(16) primary key,psw varchar(40) not null) DEFAULT CHARSET=utf8";
		mysql_query($sql,$conn);	
	}
	function sql_create_topiclist_table($table,$conn)
	{
		$sql="CREATE TABLE $table (topic_id int primary key auto_increment,topic_name varchar(30) not null,click_amount int) DEFAULT CHARSET=utf8";
		mysql_query($sql,$conn);
	}
	function sql_create_topic_table($table,$conn)
	{
		$sql="CREATE TABLE $table (article_id int primary key auto_increment,topic_id varchar(10),sendTime varchar(35) not null,author varchar(30) not null,incognito varchar(5) not null,comments varchar(10),content varchar(512) not null) DEFAULT CHARSET=utf8";
		mysql_query($sql,$conn);
	}
	function sql_create_comments_table($table,$conn)
	{
		$sql="CREATE TABLE $table (comment_id int primary key auto_increment,topic_id varchar(10),article_id varchar(10),sendTime varchar(35) not null,author varchar(30) not null,incognito varchar(5) not null,content varchar(512) not null) DEFAULT CHARSET=utf8";
		mysql_query($sql,$conn);
	}
	function sql_create_clickamount_table($table,$conn)
	{
		$sql="CREATE TABLE $table (id int primary key auto_increment,topic_id varchar(10),date varchar(15),click_amount int) DEFAULT CHARSET=utf8";
		mysql_query($sql,$conn);
	}
	
?>