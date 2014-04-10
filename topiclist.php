<?php
	require_once "Database.class.php";
	$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
	$sql='select * from '.Database::$database_topiclist_table;
	$res=mysql_query($sql,$conn);
	//话题应该不多，一次全部输出，不分页
	$i=0;
	$response;
	while($row=mysql_fetch_row($res))
	{
		$ret=array('topic_id'=>$row[0],'topic_name'=>$row[1],'click_amount'=>$row[2],"description"=>$row[3],"enableIncognito"=>$row[4]);
		$response[$i]=$ret;
		$i++;
	}
	$show['status']=200;//一定正常
	$show['response']=$response;
	echo json_encode($show);
?>