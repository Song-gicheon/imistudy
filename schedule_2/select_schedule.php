<?php
	// 세션 연결
	session_start();
	$url = ($_SERVER['HTTPS'] == 'on')?'https://':'http://';
	$url .= ($_SERVER['SERVER_PORT'] != '80')?$_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT']:$_SERVER['HTTP_HOST']; 
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='".$url."/imistudy/imistudy_2/index.php'; </script>";
	}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title> 일정 확인 </title>
	<style>
	 .today_schedules{
		 margin-bottom:30px;
	 }
	 .form{
		 float:left;
	 }
	</style>
</head>
<body>
<?php
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/cal.inc.php");

	// cal.inc.php 에서 이미 불러온 일정에서 선택한 날짜의 일정만을 추려내서 출력한다.
	// $year_month > 선택 연월, $this_date > 선택 일
	
	$select_date = $year_month."-".$this_date;
	
	echo "<div class='schedule_box'>";
	echo "<h1>".$select_date." Schedule</h1>";

	for($t=0; $t<count($m_schedule); $t++){
		if($select_date >= date('Y-m-d', strtotime($m_schedule[$t]['start'])) &&
			$select_date <= date('Y-m-d', strtotime($m_schedule[$t]['end']))){
			
			echo "<table class='today_schedules'>";
			echo "<tr>";
			echo "<td style='font-weight:bold;' width='200px'>Schedule Name</td>";
			echo "<td>".$m_schedule[$t]['subject']."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='font-weight:bold;'>Term</td>";
			echo "<td>".$m_schedule[$t]['start']." ~ ".$m_schedule[$t]['end']."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='font-weight:bold;'>Content</td>";
			echo "<td>".$m_schedule[$t]['plan']."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='font-weight:bold;'>group</td>";
			echo "<td>".$m_schedule[$t]['group']."</td>";
			echo "</tr>";
					
?> 
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

<?php
			echo "</table>";
		}
	}
?>
	</div>
</body>
</html>