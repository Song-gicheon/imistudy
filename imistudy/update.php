<?php

 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // ���� �̿�.

 $sch_id = $_POST['sch_id'];
 $schedules = $_POST['sche_name'];
 $s_date = $_POST['s_y'].$_POST['s_m'].$_POST['s_d'].$_POST['s_t']."0000";
 $e_date = $_POST['e_y'].$_POST['e_m'].$_POST['e_d'].$_POST['e_t']."0000";
 $t_name = $_POST['in_schedule'];
 $team= 0;
 $alarm = $_POST['a_y'];
 $sql='';
 if($alarm != NULL){
 	$a_date = $_POST['a_y'].$_POST['a_m'].$_POST['a_d'].$_POST['a_t']."0000";
	$sql = "Update schedules set
	 schedule='$schedules', s_date='$s_date', e_date='$e_date', content='$t_name', a_date='$a_date', team=0
	 where sch_id='$sch_id';";
 }
 else{
	 $a_date=null;
	$sql = "Update schedules set
	 schedule='$schedules', s_date='$s_date', e_date='$e_date', content='$t_name', a_date='$a_date', team=0
	 where sch_id='$sch_id';";
	 
 }
 
 

 $ok = $db->execute($sql);
 
 if($ok == false){
	 die("failed");
 }

 Header("Location:select_schedule.php");
?>
 