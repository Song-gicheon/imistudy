<?php

 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // ���� �̿�.

 $schedules = $_POST['sche_name'];
 $s_date = $_POST['s_y'].$_POST['s_m'].$_POST['s_d'].$_POST['s_t']."0000";
 $e_date = $_POST['e_y'].$_POST['e_m'].$_POST['e_d'].$_POST['e_t']."0000";
 $t_name = $_POST['in_schedule'];
 $alarm = $_POST['chk_alarm'];
 $a_date = NULL;
 if($alarm == true){
 	$a_date = $_POST['a_y'].$_POST['a_m'].$_POST['a_d'].$_POST['a_t']."0000";
 }
 $team = 0; // �׷� ������ ���� üũ�� ����
 

// �����ٸ��� �ƴ϶� �ٸ� Ű ���� ���� �������ߵ�.
 $sql = "Insert into schedules values(default, '$schedules', '$s_date', '$e_date', '$t_name','$id', '$a_date', $team);";
	 

 $ok = $db->execute($sql);
 
 if($ok == false){
	 die("failed");
 }
 else{
	 print_r($ok->GetRows());
 }

// ���� �ڵ����� ������ �� ���� ȭ������ ��ȯ �ʿ�.
?>
 
