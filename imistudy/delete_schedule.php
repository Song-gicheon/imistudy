<?php

 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // 세션 이용.

 $sch_id = $_POST['sch_id'];

 $sql = "Delete from schedules where sch_id='$sch_id'";
	 

 $ok = $db->execute($sql);
 
 Header("Location:select_schedule.php");
?>
 
