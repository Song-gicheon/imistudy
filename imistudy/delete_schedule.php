<?php

 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // ���� �̿�.

 $sch_id = $_POST['sch_id'];
 echo $_POST['sch_id'];
 $sql = "Delete from schedules where sch_id='$sch_id'";
	 

 $ok = $db->execute($sql);
 
?>
 
