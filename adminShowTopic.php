<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="utf-8"/>
<style>
*{
	margin:auto;
}
</style>
<title>
管理提取话题信息页面
</title>
</head>
<body style="text-align:center;">
<?php
	require_once 'Database.class.php';
	$p=new Page();
	$p->max_page=ceil(mysql_affected_rows()/Page::$page_size);
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$topic_id=$_REQUEST['topic_id'];
	
	//如果有page传值且所传值大于等于1才接受传值，不然设置nowpage为1
	if(isset($_REQUEST['page'])&&$_REQUEST['page']>=1)
	$p->now_page=$_REQUEST['page'];
	else
	$p->now_page=1;
	//
	
	$sql="select * from ".Database::$database_topic_table." where topic_id=$topic_id  order by article_id desc";
	$res=mysql_query($sql);
	$p->max_page=ceil(mysql_affected_rows()/Page::$page_size);//获得最大页码
	
	//不得超过最大页码的设置
	if($p->now_page>$p->max_page)
	$p->now_page=$p->max_page;
	//
	$sql="select * from ".Database::$database_topic_table." where topic_id=$topic_id  order by article_id desc limit ".(($p->now_page-1)*10).",".Page::$page_size;//倒序十个十个取
	$res=mysql_query($sql);
	echo "共有".$p->max_page."页，目前第".$p->now_page."页<br>";
	echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.($p->now_page-1).'&topic_id='.$topic_id.'">上一页</a>|';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.($p->now_page+1).'&topic_id='.$topic_id.'">下一页</a>';
	while($row=mysql_fetch_assoc($res))
	{
		echo '
		<div style="border:1px solid black;width:780px;">
			'.$row['content'].'<br>
			<font style="float:left;">发送时间：'.$row['sendTime'].'|作者：'.$row['author'].'|匿名情况：'.$row['incognito'].'</font>
			<a href="admingetcomment.php?article_id='.$row['article_id'].'&topic_id='.$row['topic_id'].'" style="float:right;">评论（'.$row['comments'].'）</a><br>
			<a href="delArticle.php?article_id='.$row['article_id'].'">删除</a>
		</div><br>
		';
		echo '<br>';
	}
	echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.($p->now_page-1).'&topic_id='.$topic_id.'">上一页</a>|';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.($p->now_page+1).'&topic_id='.$topic_id.'">下一页</a>';
?>