<!-- 구성원 및 그룹 스케줄 확인 페이지 -->
<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<title>Group Set</title>
	<style>
		 .form{
			 float:left;
		 }
	 </style>
</head>
<body>
<?php
	 // 선택 그룹의 구성원 목록 탐색
	 // 선택 그룹의 그룹 일정 목록 탐색
	 // 그룹 구성원 추가 및 삭제 

	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/cal.inc.php");

	$group_id = $_GET['team_id'];
	$group_name = $_GET['team_name'];

	// 그룹 id 로 그룹의 멤버를 조회한다.
	$sql = "select id, name from group_mem where group_id=".$group_id.";";
	$rs = $db->execute($sql);

	echo "<div class='schedule_box'>";
	echo "<h1>'".$group_name."' Group</h1>";
	echo "<div>";
	echo "<h3>Member</h3>";
	echo "<table style='table-layout:fixed; margin-bottom:20px;' height='30px'>";

	while(!$rs->EOF)
	{
		echo "<tr width='250px'>";
		echo "<td width='200px'>";
		echo $rs->fields['name']; // 구성원
		echo "</td>";
		echo "<td>";
		echo "<a href='group_member_delete.php?del_mem_id=".$rs->fields['id']."'>X</a>";
		echo "</td>";
		echo "</tr>";
		$rs->moveNext();
	}
	?>
		<tr>
		<td colspan='2'>
			<form class='form' action='group_update.php' method='post'> 
				<input type='hidden' name='g_id' value='<?php echo $group_id ?>'>
				<input type='hidden' name='team' value='<?php echo $group_name; ?>'>
				<input type='submit' value='+New Member'>
			</form>
		  </td>
		 </tr>
		 </table>
	 </div>
	 <div>
<?php
	echo "<h2>".$group_name." Schedules</h2>";

	for($i=0; $i<count($m_schedule); $i++){
		if($m_schedule[$i]['gr_id'] == $group_id){
			
			echo "<table class='today_schedules' style='table-layout:fixed; margin-bottom:20px;'>";
			echo "<tr>";
			echo "<td style='font-weight:bold;' width='200px'>Schedule Name</td>";
			echo "<td>".$m_schedule[$i]['subject']."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='font-weight:bold;'>Term</td>";
			echo "<td>".$m_schedule[$i]['start']." ~ ".$m_schedule[$t]['end']."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='font-weight:bold;'>Content</td>";
			echo "<td>".$m_schedule[$i]['plan']."</td>";
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
		<tr>
			<td>
			<!-- 업데이트 버튼 -->
			<form name='form' class='form' action='update_schedule.php' method='post'>
			<input type='hidden' name='s_id' value='<?php echo $m_schedule[$t]['id']; ?>'/>
			<input type='hidden' name='schedule' value='<?php echo $m_schedule[$t]['subject']; ?>'/>
			<input type='hidden' name='start_time' value='<?php echo $m_schedule[$t]['start']; ?>'/>
			<input type='hidden' name='end_time' value='<?php echo $m_schedule[$t]['end']; ?>'/>
			<input type='hidden' name='s_content' value='<?php echo $m_schedule[$t]['plan']; ?>'/>
			<input type='hidden' name='alarm_time' value='<?php echo $m_schedule[$t]['alarm']; ?>'/>
			<input type='hidden' name='g_id' value='<?php echo $m_schedule[$t]['gr_id']; ?>'/>
			<input type='submit' value='Update'/>
			</form>

			<!-- 삭제 버튼 -->
			<form name='form' class='form' action='delete_schedule.php' method='post'>
			<input type='hidden' name='s_id' value='<?php echo $m_schedule[$t]['id']; ?>'/>
			<input type='submit' value='Delete'/>
			</form>
			</td>
		</tr>
	</table>

<?php
	}
 }

?>
	<div>
</div>
</body>
</html>