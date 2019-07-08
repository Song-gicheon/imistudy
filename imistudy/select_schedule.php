<!doctype html>
<html>
<head>
 <meta charset="utf-8">
 <title> 일정 확인 </title>
</head>
<body>
<?php

 require('cal.inc.php');
 // 선택된 날짜의 정보를 별도로 전송받을 필요가 있음. 

 $select_y = isset($_GET['year'])?$_GET['year']:$y;
 $select_m = isset($_GET['month'])?$_GET['month']:$m;
 $select_d = isset($_GET['day'])?$_GET['day']:$d;

 if(strlen($select_m) == 1) $select_m="0".$select_m;
 if(strlen($select_d) == 1) $select_d="0".$select_d;

 $today = "$select_y-$select_m-$select_d";
?>
 <div id='add_container' class='schedule_box'>
 
<?php
 echo "<h1>$today Schedule</h1>";

 // 오늘이 포함된 모든 계획은 보여줄 수 있도록 한다.
 $sql= "select sch_id, schedule, s_date, e_date, content, team, a_date
		from schedules
		where '$today'>=DATE(s_date) and '$today'<=DATE(e_date);";

 $ok = $db->execute($sql);
 if($ok == false){
	 die("failed");
 }
 else{
	 while(!$ok->EOF)
	 {
		 
		echo "<table style='margin-bottom:30px;'>";
		echo "<tr>";
		echo "<td style='font-weight:bold;' width='200px'>Schedule Name</td>";
		echo "<td>".$ok->fields[1]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-weight:bold;'>Start</td>";
		echo "<td>".$ok->fields[2]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-weight:bold;'>End</td>";
		echo "<td>".$ok->fields[3]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-weight:bold;'>Content</td>";
		echo "<td>".$ok->fields[4]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-weight:bold;'>group</td>";
		echo "<td>".$ok->fields[5]."</td>";
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
			<input type='hidden' name='sch_id' value='<?php echo $ok->fields[0]; ?>'/>
			<input type='hidden' name='group' value='<?php echo $ok->fields[5]; ?>'/>
			<td>
			<input type='button' value='Update' onclick='upd(this.form);'/>
			<input type='button' value='Delete' onclick='del(this.form);'/>
			</td>
		</form></tr>

<?php
		$ok->moveNext();

		echo "</table>";
	}
	echo "<br>";
}
?>


 </body>
 </html>