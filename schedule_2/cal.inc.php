<!-- 전체 페이지에 들어가는 달력을 구현하는 코드.-->
<script src='https://code.jquery.com/jquery-1.10.2.js'></script>
<script>
	var time = "<?php echo date('F d, Y H:i:s', time()); ?>";
	var now = new Date(time);
	var al_arr = new Array();
</script>
<style>
 .schedule_box{
	float:right;
	margin:10px;
	width:620px;
}

 .table{
	 width:600px;
	 table-layout:fixed;
	 margin:10px;
}
 .move{
	 text-align:center;
	 height:30px;
	 font-weight:bold;
	 font-size:25px;
 }
 .calender td{	 
	 height:90px;
 }
 th{
	 height:40px;
	 width:80px;
	 background:#ddd;
	 border:2px solid #111;
 }

 .days{
	 font-size:17px;
	 padding:3px;
	 font-weight:bold;
 }

 .lunar{
	font-size:11px;
	color:black;
	padding:4px;
 }

 .m_sch{
	 font-size:11px;
	 color:#333;
	 background:#fbf;
	 padding:2px;
	 margin-top:2px;
	 margin-bottom:2px;
 }

 .add{
	 font-size:7px;
	 color:black;
	 text-align:right;
	 vertical-align:bottom;
 }

 .selectDate{
	 table-layout:fixed;
	 text-align:left;
	 vertical-align:top;
	 border:2px solid #111;
 }
</style>
<?php

	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/connect.inc.php");

	//기본 연월. 만약 get 변수가 존재한다면, 바꿔준다.
	$year_month = date('Y-m');
	if(isset($_GET['m'])){
		$year_month = $_GET['m'];
	}
	
	$this_date	= date('d');
	if(isset($_GET['d'])){
		$this_date = $_GET['d'];
	}

	// date 함수를 이용해서 지난 연월, 다음 연월을 구한다.
	$prev_month	= date('Y-m', strtotime($year_month." -1 month"));
	$next_month	= date('Y-m', strtotime($year_month." +1 month"));
	$prev_year	= date('Y-m', strtotime($year_month." -1 year"));
	$next_year	= date('Y-m', strtotime($year_month." +1 year"));
	
	// 총 날짜 수, 마지막 요일, 시작 요일, 총 주차 수
	$max_date	= date('t', strtotime($year_month));
	$last_day	= date('w', strtotime($year_month."-".$max_date));
	$start_day	= date('w', strtotime($year_month.'-01'));
	$total_week	= ceil(($max_date+$start_day)/7);

	//1. 일정 계획을 미리 호출한다.
	
	$sql = "SELECT A.id, A.name, A.s_date, A.e_date, A.content, A.a_date, A.group_id, IFNULL(B.name, '없음') AS group_name
			FROM schedules A LEFT OUTER JOIN group_tb B ON A.group_id = B.id
			WHERE A.s_date >= '".$year_month."-01 00:00:00' 
			OR A.e_date <= '".$year_month."-".$max_date." 24:00:00' 
			OR (A.s_date < '".$year_month."-01 00:00:00' AND A.e_date > '".$year_month."-".$max_date." 24:00:00');";
	
	$rs = $db->execute($sql);
	if($rs == false){
		die("DB 연결 에러");
	}
	else{
		$k=0;
		// 호출된 일정 계획을 배열에 저장한다.
		// 알람시간도 한꺼번에 자바스크립트 배열값에 저장해준다.
		while(!$rs->EOF){
			$m_schedule[] = array(
				'id'=>$rs->fields['id'],
				'subject'=>$rs->fields['name'],
				'start'=>$rs->fields['s_date'], 
				'end'=>$rs->fields['e_date'],
				'plan'=>$rs->fields['content'],
				'alarm'=>$rs->fields['a_date'],
				'gr_id'=>$rs->fields['group_id'],
				'group'=>$rs->fields['group_name']
				);
			if(empty($rs->fields['a_date'])){
				
				echo $rs->fields['a_date']."<br>s";
				echo "<script>
					al_arr[".$k."] = '".$rs->fields['a_date']."';
					</script>";
					$k++;
			}
			$rs->moveNext();
		}
	}

	//2. 이번 달의 음력 일자도 미리 호출한다.
	$sql = "SELECT lunar_date FROM lunar_data
			WHERE solar_date>='".$year_month."-01' 
			AND solar_date<='".$year_month."-".$max_date."';";
	
	$rs2 = $db->execute($sql);
	if($rs2 == false){
		die("DB 연결 에러");
	}
	else{
		// 호출한 음력 일자도 다른 배열에 저장한다.
		while(!$rs2->EOF){
			$lunar_date[] = date('m-d', strtotime($rs2->fields['lunar_date']));
			$rs2->moveNext();
		}
	}

?>
<div class="schedule_box">
<form action="insert_schedule.php">
	<input type="submit" value="Add Plan">
</form>

<table class="table">
	<tr class="move">
		<td><!-- 1년 이전 -->
		<a href="select_schedule.php?m=<?php echo $prev_year; ?>&d=<?php echo $this_date; ?>">◀◀</a>
		</td>
		<td><!-- 1달 이전 -->
		<a href="select_schedule.php?m=<?php echo $prev_month; ?>&d=<?php echo $this_date; ?>">◀</a>
		</td>
		<td colspan="3"><!--선택 연월 -->
		<a href="select_schedule.php"><?php echo $year_month; ?></a>
		</td>
		<td><!-- 1달 이후 -->
		<a href="select_schedule.php?m=<?php echo $next_month; ?>&d=<?php echo $this_date; ?>">▶</a>
		</td>
		<td><!-- 1년 이후 -->
		<a href="select_schedule.php?m=<?php echo $next_year; ?>&d=<?php echo $this_date; ?>">▶▶</a>
		</td>
	</tr>
	<tr>
		<th>SUN</th>
		<th>MON</th>
		<th>TUE</th>
		<th>WED</th>
		<th>THU</th>
		<th>FRI</th>
		<th>SAT</th>
	</tr>
<?php
	// 달력 그리기 전에 날짜 초기화
	$today = 1;
	$scd_n = 0;

	// '$i'는 몇 번째 주인지를 의미한다.
	for($i=1; $i<=$total_week; $i++){
		echo "<tr class='calender'>";

		// '$j'는 어떤 요일인지를 의미한다.
		for($j=0; $j<7; $j++){
			
			//선택된 달의 날짜 표기
			//첫 주의 시작 요일부터, 마지막 주 마지막 요일까지 계산
			if(!(($i == 1 && $j < $start_day) || ($i == $total_week && $j > $last_day))){
				
				$today = date('d', strtotime($year_month."-".$today));

				if($j==0){
					 $style = 'red';
				}else if($j==6){
					 $style = 'blue';
				}else{
					 $style = 'black';
				}
	
				$print_day = "<font class='days' color=".$style.">".$today."</font>";
				 
				if($j==1 || $j==3 || $j==5){
					$print_day .= "<font class='lunar'>".$lunar_date[$today-1]."</font>";
				}

				$plan_num = 0;

				for($t=0; $t<count($m_schedule); $t++){
					if($year_month."-".$today >= date('Y-m-d', strtotime($m_schedule[$t]['start'])) &&
						$year_month."-".$today <= date('Y-m-d', strtotime($m_schedule[$t]['end']))){
						
						$plan_num++;
						if($plan_num < 3){
							$print_day .="<div class='m_sch'>".$m_schedule[$t]['subject']."</div>";
						}
					}
				}
				if($plan_num > 2){
					$print_day .="<div class='add'>+".($plan_num-2)." plan</div>";
				}

				$go_m = $year_month;
				$go_d = $today;
				$today++;
			}
			
			// 지난 달 날짜 표기
			else if($i == 1 && $j < $start_day){
				$go_m		= $prev_month;
				$go_d		= date('t', strtotime($prev_month)) - $start_day + $j+1;

				$prev_date	= date('m', strtotime($prev_month))."-";
				$prev_date .= $go_d;

				$print_day	= "<font class='days' color='gray'>".$prev_date."</font>";

			}

			// 다음 달 날짜 표기
			else if($i == $total_week && $j > $last_day){
				$go_m		= $next_month;
				$go_d		= date('d', strtotime($next_month."-".($j - $last_day)));

				$next_date	= date('m', strtotime($next_month))."-";
				$next_date .= $go_d;

				$print_day = "<font class='days' color='gray'>".$next_date."</font>";

			}
			echo "<td class='selectDate' onclick='javascript:location.href=\"select_schedule.php?m=".$go_m."&d=".$go_d."\"'>";
			echo $print_day;
			echo "</td>";
		}
		echo "</tr>";
	}
?>
</table>
 <h3> Your Group </h3>
 <table style="table-layout:fixed; margin:20px;" height='30px' align='center'>
<?php
	 // 현재 id의 그룹 목록.
	 $sql = "select id, name from group_tb;";
	 $result = $db->execute($sql);

	 while(!$result->EOF){
		 echo "<tr width='200px' style='font-size:19px;'>";
		 echo "<td width='140px'>";
		 echo "<a href='group_view.php?team_id=".$result->fields['id']."&team_name=".$result->fields['name']."'>".$result->fields['name']."</a>"; // 팀명
		 echo "</td>";
		 echo "<td><button onclick='javascript:location.href=\"group_delete.php?del_id=".$result->fields['id']."\"'>Delete</button><td>";
		 echo "</tr>";
		 $result->moveNext();
	 }
	 echo "<tr><td><button onclick='javascript:location.href=\"group_make.php\"'>Make Group</button><td></tr>";
?>
</table>

</div>
<script>
	setInterval("Current_time()", 1000);

	function Current_time(){
		now.setSeconds(now.getSeconds()+1);
		var y = now.getFullYear();
		var m = now.getMonth()+1;
		var d = now.getDate();
		var h = now.getHours();
		var mi = now.getMinutes();
		var s = now.getSeconds();

		if(m<10){ m='0'+m;}
		if(d<10){ d='0'+d;}
		if(h<10){ h='0'+h;}
		if(mi<10){ mi='0'+mi;}
		if(s<10){ s='0'+s;}
		
		for(var i=0; i<al_arr.length; i++){
			if(al_arr[i] == y+'-'+m+'-'+d+' '+h+':'+mi+':'+s){
				alert('alarm 현재시간 : '+y+'-'+m+'-'+d+' '+h+':'+mi+':'+s);
			}
		}
	}
</script>