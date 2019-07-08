<?php
 session_start();
 $id= $_SESSION['id'];
 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 

 $team = $_GET['team_name'];
 $member = $_GET['member_name'];
 for($i=0; $i<count($member); $i++){	 
	 
	$sql = "Insert into team(team_name, user_id, member_name) select '$team', '$id', '$member[$i]' from dual where not exists(
			Select * from team where team_name='$team' and user_id='$id' and member_name='$member[$i]')";

	$rs = $db->execute($sql);
 }

 Header("Location:select_group.php?team=$team");
?>