<!-- 구성원 및 그룹 스케줄 확인 페이지 -->
<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<title>Group Set</title>
</head>
<body>
<?php
 // 선택 그룹의 구성원 목록 탐색
 // 선택 그룹의 그룹 일정 목록 탐색
 // 그룹 구성원 추가 및 삭제 
 include('cal.inc.php');
 $group = $_GET['team'];
 $sql = "select team_id, member_name from team where user_id='$id' and team_name='$group';";
 $rs = $db->execute($sql);

 echo "<div class='schedule_box'>";
 echo "<h1>GROUP : $group</h1>";
 echo "<div>";
 echo "<h3>$group Member</h3>";
 echo "<table style='table-layout:fixed; margin-bottom:20px;' height='30px'>";
 
 while(!$rs->EOF)
 {
	 echo "<tr width='250px'>";
	 echo "<td width='200px'>";
	 echo $rs->fields[1]; // 구성원
	 echo "</td>";
	 echo "<td>";
	 echo "<a href='update_group.php?team=$group&del=".$rs->fields[0]."'>X</a>";
	 echo "</td>";
	 echo "</tr>";
	 $rs->moveNext();
 }
 ?>
		 <tr>
		  <td colspan='2'>
		  <button onclick='location.href="update_group.php?team=<?php echo $group?>"'>+ New Member</button>
		  </td>
		 </tr>
		 </table>
	 </div>
	 <div>
<?php
 echo "<h2>$group Schedules</h2>";

 $sql = "select sch_id, schedule, s_date, e_date, content, team, a_date
		from schedules
		where team='$group'";

 $rs = $db->execute($sql);
 while(!$rs->EOF)
 {
	 
	echo "<table style='margin-bottom:30px;'>";
	echo "<tr>";
	echo "<td style='font-weight:bold;' width='200px'>Schedule Name</td>";
	echo "<td>".$rs->fields[1]."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='font-weight:bold;'>Start</td>";
	echo "<td>".$rs->fields[2]."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='font-weight:bold;'>End</td>";
	echo "<td>".$rs->fields[3]."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='font-weight:bold;'>Content</td>";
	echo "<td>".$rs->fields[4]."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style='font-weight:bold;'>group</td>";
	echo "<td>".$rs->fields[5]."</td>";
	echo "</tr>";
	
?> 
	<script type='text/javascript'>

		function upd(form){
			form.action = 'update_schedule.php';
			form.submit();
		}

		function del(f){
			f.action = 'delete_schedule.php';
			f.submit();
		}
	</script>

	<tr><form name='form' class='form' method='post'>
		<input type='hidden' name='sch_id' value='<?php echo $rs->fields[0]; ?>'/>
		<input type='hidden' name='group' value='<?php echo $rs->fields[5]; ?>'/>
		<td><input type='button' value='Update' onclick='upd(this.form);'/>
		<input type='button' value='Delete' onclick='del(this.form);'/></td>
	</form></tr>


<?php
	$rs->moveNext();

	echo "</table>";
 }

?>
	<div>
</div>
</body>
</html>