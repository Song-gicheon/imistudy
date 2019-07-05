<?php

 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // 세션 이용.

 $schedules = $_POST['sche_name'];
 $s_date = $_POST['s_y'].$_POST['s_m'].$_POST['s_d'].$_POST['s_t']."0000";
 $e_date = $_POST['e_y'].$_POST['e_m'].$_POST['e_d'].$_POST['e_t']."0000";
 $t_name = $_POST['in_schedule'];
 $alarm = $_POST['a_y'];
 $team= 0;
 echo $alarm;
 $sql='';
 if($alarm != NULL){
 	$a_date = $_POST['a_y'].$_POST['a_m'].$_POST['a_d'].$_POST['a_t']."0000";
	$sql = "Insert into schedules(schedule, s_date, e_date, content, id, a_date, team) values('$schedules', '$s_date', '$e_date', '$t_name','$id', '$a_date', '$team');";
 }else{
	$sql = "Insert into schedules(schedule, s_date, e_date, content, id, team) values('$schedules', '$s_date', '$e_date', '$t_name','$id', '$team');";
 }
 $team = 0; // 그룹 유무는 따로 체크할 예정
 

// 스케줄명이 아니라 다른 키 값을 따로 만들어줘야됨.
 $ok = $db->execute($sql);
 

 Header("Location:select_schedule.php?year=".$_POST['s_y']."&month=".$_POST['s_m']."&day=".$_POST['s_d']);
?>
 
