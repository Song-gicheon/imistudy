<?php
 // �׷� ���� �� �׷� ������ ���� ����
	
 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // ���� �̿�.
 $team_id = $_GET['del'];


 $sql = "DELETE a, b FROM team a JOIN schedules b ON a.team_name=b.team and a.user_id=b.id 
		WHERE a.team_name='$team_id' and a.user_id='$id';";
 $ok = $db->execute($sql);
 
 Header("Location:select_schedule.php");
?>