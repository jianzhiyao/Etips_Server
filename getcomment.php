<?php
//该文件用于用制定的话题id和文章id返回评论内容
	require_once "Database.class.php";
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	//判断是否同时拿到了topic_id和article_id
	$response;
	$comment_page_size=10;
	if(isset($_REQUEST['topic_id'])&&isset($_REQUEST['article_id']))
	{
		$topic_id=$_REQUEST['topic_id'];
		$article_id=$_REQUEST['article_id'];
		$sql="select * from ".Database::$database_comments_table." where topic_id=$topic_id and article_id=$article_id order by comment_id desc";//用comment_id倒序来确定最新的在前面
		$res=mysql_query($sql);
		$i=0;
		while($row=mysql_fetch_assoc($res))
		{
			$s="select * from user where id='".$row['author']."'";
			$r=mysql_query($s);
		    $ro=mysql_fetch_assoc($r);
			$row['nickname']=$ro['nickname'];
			$response[$i++]=$row;
		}
		$show['status']=200;
		$show['response']=$response;
		echo json_encode($show);
		exit();
	}
	else if(isset($_REQUEST['author']))
	{
		$author=$_REQUEST['author'];
		if(!isset($_REQUEST['page']))//page缺省状态
				$page=1;
			else
				$page=$_REQUEST['page'];
		$sql="select * from ".Database::$database_comments_table." where to_author='".$author."' order by sendTime desc limit ".($page-1)*$comment_page_size .",".$comment_page_size;//先获得该账号被评论的评论
		$res=mysql_query($sql);
		$status=200;
		$response;
		$i=0;
		while($row=mysql_fetch_assoc($res))
		{
			$nickname;//评论者的nickname
			$sql="select * from ".Database::$database_user_table." where id ='".$row['author']."'";
			$res0=mysql_query($sql) or die(error());
			$r0=mysql_fetch_assoc($res0);
			$nickname=$r0['nickname'];
			if($row['to_comment_id']==0)//如果这个是0就代表是普通评论，直接获得原帖还有评论
			{
				$sql="select * from ".Database::$database_topic_table." where article_id= '".$row['article_id']."'";
				$res1=mysql_query($sql) or die(mysql_error());
				$row1=mysql_fetch_assoc($res1);//这里row1（数字一）用于获得帖子的资源
				$content=$row1['content'];//这里是帖子原文
				$content_id=$row1['article_id'];
				$comment=$row['content'];//这里是评论原文
				$sendTime=$row1['sendTime'];
				$response[$i++]=array("content"=>$content,'content_id'=>$content_id,"comment"=>$comment,"sendTime"=>$sendTime,"author"=>$row1['author'],"incognito"=>$row1['incognito'],"nickname"=>$nickname,"topic_id"=>$row1["topic_id"],"article_id"=>$row1["article_id"],'comment_id'=>$row['comment_id']);
			}
			else//否则代表评论的评论，直接获得主评论（被评论的评论），还有客评论
			{
				$sql="select * from ".Database::$database_comments_table." where comment_id='".$row['to_comment_id']."'";
				$res1=mysql_query($sql);
				$row1=mysql_fetch_assoc($res1);//row1(数字一)用于获得主评论的资源
				$content=$row1['content'];//这里是主评论原文
				$content_id=$row1['comment_id'];
				$comment=$row['content'];//这里是客评论原文
				$sendTime=$row1['sendTime'];
				$response[$i++]=array("content"=>$content,"content_id"=>$content_id,"comment"=>$comment,"sendTime"=>$sendTime,"author"=>$row1['author'],"incognito"=>$row1['incognito'],"nickname"=>$nickname,"topic_id"=>$row1["topic_id"],"article_id"=>$row1["article_id"],'comment_id'=>$row['comment_id']);
			}
		}
		echo json_encode(array("status"=>$status,"response"=>$response));
	}
	else
	{
		$show['status']=203;
		$show['response']=array(null);
		echo json_encode($show);
		exit();
	}
?>