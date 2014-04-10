<?php
/*该文件用于评论信息*/
	require_once "Database.class.php";
	require_once "status.class.php";
	if(isset($_REQUEST['topic_id'])&&isset($_REQUEST['content'])&&isset($_REQUEST['author'])&&isset($_REQUEST['sendTime'])&&isset($_REQUEST['incognito'])&&isset($_REQUEST['content'])&&isset($_REQUEST['article_id']))
	//提交信息完整
	{
		$topic_id=$_REQUEST['topic_id'];//评论对应话题id
		$article_id=$_REQUEST['article_id'];//话题对应信息id
		$sendTime=$_REQUEST['sendTime'];//发送时间
		$author=$_REQUEST['author'];//作者
		$incognito=$_REQUEST['incognito'];//是否匿名
		$content=$_REQUEST['content'];//评论内容
		if(isset($_REQUEST['to_comment_id']))//过渡版本，暂时可以缺省
			$to_comment_id=$_REQUEST['to_comment_id'];
		else
			$to_comment_id=0;//0表示这是一般的帖子的评论
		$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
		mysql_select_db(Database::$selectdatabase);
		mysql_query("set names utf8");
		//原文章评论数+1
		$sql="select * from ".Database::$database_topic_table." where topic_id=$topic_id and article_id=$article_id";
		$res=mysql_query($sql);
		$row=mysql_fetch_assoc($res);
		$article_author=$row["author"];
		$num=$row['comments']+1;//评论数加一
		if(isset($_REQUEST['to_author']))//过渡版本，暂时可以缺省
			$to_author=$_REQUEST['to_author'];
		else//如果没有就是原来的帖子的作者的学号
			$to_author=$row['author'];
		$sql="update ".Database::$database_topic_table." set comments=".$num." where article_id=$article_id";
		mysql_query($sql);
		//+1结束
		//同时在用户表那里加一个tips的值
		$sql="update ".Database::$database_user_table." set tips=tips+1 where id='$to_author'";//给被评论的人加一个状态值
		mysql_query($sql);
		//插入评论处理
		$sql="insert into ".Database::$database_comments_table." (topic_id,article_id,sendTime,author,incognito,content,to_author,to_comment_id)  values('$topic_id','$article_id','$sendTime','$author','$incognito','$content','$to_author','$to_comment_id')";//插入评论
		//作于测试时间之用$sql="insert into ".Database::$database_comments_table." (topic_id,article_id,sendTime,author,incognito,content,to_author,to_comment_id)  values('$topic_id','$article_id',".date("U").",'$author','$incognito','$content','$to_author','$to_comment_id')";//插入评论
		$res=mysql_query($sql,$conn) or die(mysql_error());
		
		$s;
		if($res)
		{
			$s=array('status'=>Status::$status[0]);
		}
		else
		{
			$s=array('status'=>Status::$status[3]);
		}
	}
	else//提交信息不完整
		{
			$s=array('status'=>Status::$status[3]);
		}
		$show['status']=$s['status'];
		$show['response']=array(null);
		echo json_encode($show);
		exit();
?>