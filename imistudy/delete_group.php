<?php
 // 그룹 삭제 및 그룹 스케줄 같이 삭제
 session_start();
 $id= $_SESSION['id'];
 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $team_id = $_GET['del'];


 //$sql = "DELETE a, bFROM team a JOIN schedules b ON a.team_name=b.team and a.user_id=b.id WHERE a.team_name='$team_id' and a.user_id='$id';";

 $sql = "DELETE FROM team WHERE team_name='$team_id' and user_id='$id';";

 $ok = $db->execute($sql);

 $sql = "DELETE FROM schedules WHERE team='$team_id' and id='$id';";

 $ok = $db->execute($sql);
 Header("Location:select_schedule.php");
?>