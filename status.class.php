<?php
//���ļ���һ������״̬Status��һ����
	require_once 'Database.class.php';
	class Status{
		public static $status=array('200','201','202','203','204','205','206','207');//���������˺Ż������ѧ���Ѵ��ڣ��޸�û������Чʱ���ڣ�����ʧ�ܣ�����ԭ��,����������䲻���ڣ������ʽ����,�û�ѧ��id�Ѿ���ע��
		
		//�ж�����,���䣬id�Ƿ���ں���
		public function getStatus($nickname,$account,$id){
			$conn=mysql_connect($_SERVER['SERVER_NAME'],Database::$database_username,Database::$database_userpassword);
	mysql_select_db(Database::$selectdatabase);
	mysql_query("set names utf8");
			//ͨ��idץ��Ϣ
			$sql="select * from ".Database::$database_user_table." where id='".$id."'";
			$res=mysql_query($sql) or die(mysql_error());
			$row=mysql_fetch_assoc($res);
			if($row)
			{
				echo 7;
				return self::$status[7];
			}
			$sql="select * from ".Database::$database_user_table.' where nickname='."'".$nickname."' or account='".$account."'";
			$res=mysql_query($sql) or die(mysql_error());
			$row=mysql_fetch_assoc($res);
			if(!$row)
			{	
				return self::$status[0];//�����ڷ��������ź�
			}
			else
			{
				return self::$status[1];//���ڷ��ش����ź�
			}
		}
		//�ж���Чʱ�亯��
		public function judgeTime($time){
			$currentTime=date("U");
			if($currentTime>$time)
			return self::$status[2];
		}
		
	}
?>