<?php

 include('../../adodb5/adodb.inc.php');
 $db = newADOConnection('mysqli');

 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");

 $pagename = basename($_SERVER['PHP_SELF']); 

 $id='test';
 $y = date('Y');
 $m = date('m');
 $d = date('d');
 // 파라미터가 존재하지 않는 경우 default 값으로 오늘 날짜를 적용하게 된다.
 $year = isset($_GET['year'])?$_GET['year']:$y;
 $month = isset($_GET['month'])?$_GET['month']:$m;
 $day = isset($_GET['day'])?$_GET['day']:$d;

 if(strlen($month) == 1) $month="0".$month;
 if(strlen($day) == 1) $day = "0".$day;

 $prev_month = $month-1;
 $next_month = $month+1;

 // 1개월 전후로 이동해도 기본적으로 년은 변하지 않는다.
 $prev_year = $next_year = $year;

 // 1월, 12월의 경우 년도가 바뀌므로 명시해줄 필요가 있다.
 if($month == 1){
	 $prev_month = 12;
	 $prev_year = $year-1;
 }
 else if($month == 12){
	 $next_month = 1;
	 $next_year = $year+1;
 }
 // 1년 전후로 이동하는 경우 년도만 변화한다.
 $pre_year = $year-1;
 $nex_year = $year+1;

 // yyyy-mm-dd 형태로 받아서 이동하는 날짜를 받아온다.
 // 이 날짜는 일정 관리에 이용된다.
 $prev_date = date('Y-m-d', mktime(0,0,0, $month-1, 1, $year));
 $next_date = date('Y-m-d', mktime(0,0,0, $month+1, 1, $year));
 
 // date('t') 를 이용하면 해당 월의 총 일 수를 구할 수 있다.
 $max_date = date('t', mktime(0,0,0, $month, 1, $year));

 $start_day = date('w', mktime(0,0,0, $month, 1, $year)); // 시작요일
 $total_week = ceil(($max_date + $start_day)/7);
 // 전체 일 수 + 시작요일을 7로 나누어서 한 달이 총 몇 주인지 구한다.
 
 $last_day = date('w', mktime(0,0,0, $month, $max_date, $year));

?>
 <script src='https://code.jquery.com/jquery-1.10.2.js'></script>
 <script>
</script>

 <style>
 .schedule_box{
	float:right;
	margin:20px;
 }
 </style>

 <div id="calender" class="schedule_box">
 <table class="table" style="table-layout:fixed; margin:10px;" border='2' height='500px' width='600px'>
 <tr align = "center" height='30'>
  <td> <!-- 이전 년으로  -->
   <a href= <?php echo "$pagename?year=$pre_year&month=$month&day=1"; ?>>◀◀</a>
  </td>
  <td> <!-- 이전 달으로 -->
   <a href= <?php echo "$pagename?year=$prev_year&month=$prev_month&day=1";?>>◀</a>
  </td>
  <td colspan='3'> <!-- 현재 표시중인 날 // 클릭하면 이번달로 이동 -->
  <a href= <?php echo "$pagename?year=$y&month=$m&day=1";?>><?php echo "&nbsp; $year . $month  &nbsp;"; ?></a>
  </td>
  <td> <!-- 다음 달으로 -->
  <a href= <?php echo "$pagename?year=$next_year&month=$next_month&day=1";?>>▶</a>
  </td>
  <td> <!-- 다음 년으로 -->
  <a href= <?php echo "$pagename?year=$nex_year&month=$month&day=1";?>>▶▶</a>
  </td>
 </tr>
  <!-- 요일 표시 -->
 <tr class = "day" width=>
  <th height="40">SUN</th>
  <th>MON</th>
  <th>TUE</th>
  <th>WED</th>
  <th>THU</th>
  <th>FRI</th>
  <th>SAT</th>
 </tr>

 <script type='text/javascript'>
 </script>
<?php
 $day=1;
 
 $go_y = $year;
 $go_m = $month;
 $go_d = $day;

 for($i=1; $i<=$total_week; $i++){
?> 
 <tr>
<?php
 $lunc = false;
 for($j=0; $j<7; $j++){
	 
	 // 시작 요일부터 마지막 날까지 날짜를 기입한다.
	 if(!(($i==1 && $j< $start_day)||($i==$total_week && $j>$last_day))){
		 
		 if(strlen($day) == 1) $day = "0".$day;

		 if($j==0){
			 $style = 'red';
		 }else if($j==6){
			 $style = 'blue';
		 }else{
			 $style = 'black';
		 }
		 
		 if($j==1 || $j==3 || $j==5){
			 $lunc = true;
		 }

		 $w_day = "<font color='$style' padding='3'>$day</font>";

		 $today = "$year-$month-$day";
		 
		 // 음력 표기일 ( 월 수 금 )
		 if($lunc == true){
			 $query = "select lunar_date from lunar_data where solar_date=".$year.$month.$day;
			 $rs = $db->execute($query);
			 $w_day .= "<br><font style='font-size:8;' class='luna' color='black' padding='4' align='left'>".$rs->fields[0]."</font>";
			 $lunc = false;
		 }

		 // 달력상에서 가장 먼저 입력된 일일 일정을 보여준다. 
		 $sql_select = "SELECT schedule team FROM schedules
						WHERE '$today'>=DATE(s_date) and '$today'<=DATE(e_date) limit 1;";

		 $ok = $db->execute($sql_select);
				 
		 if($ok == false){
			 die("failed");
		 }
		 else{
			 $w_day .= "<br>".$ok->fields[0];
		 }

		$go_y = $year;
		$go_m = $month;
		$go_d = $day;
	 }

	 // 이전 달 날짜 표기
	 else if($j < $start_day && $i==1){
		$style='gray';
		$prev_total_date = date('t', mktime(0,0,0, $prev_month, 1, $year));
		$prev_d = $prev_total_date - $start_day + $j+1;

		$w_day = "<font color='gray' padding='3'>".$prev_month.".".$prev_d."</font>";
		
		$go_y = $year;
		$go_m = $prev_month;
		$go_d = $prev_d;
		if($month == 1) $go_y=$prev_year;
	 }

	 // 다음 달 날짜 표기
	 else if($j > $last_day && $i==$total_week){
		$style='gray';
		$next_d = - $last_day + $j;

		$w_day = "<font color='gray' padding='3'>".$next_month.".".$next_d."</font>";
		
		$go_y = $year;
		$go_m = $next_month;
		$go_d = $next_d;
		if($month == 12) $go_y=$next_year;
	 }

	 // 각 날짜마다 클릭해서 일정 확인 가능. 
	 echo "<td class='select_date' style='table-layout:fixed;' align='left' valign='top'
	 onclick='javascript:location.href=\"select_schedule.php?year=$go_y&month=$go_m&day=$go_d\"'>";
	 echo $w_day;

		$day++;
	 echo "</td>";
 }
 echo "</tr>";
}
?>
 <script>
	var time = "<?php print(date('F d, Y H:i:s', time())); ?>";
	var now = new Date(time);
	var al_arr = new Array();

	setInterval("Current_time()", 1000);

 </script>
 </table>

<?php 
 include('view_group.php');
 ?>

<!--  달력 아래에 일정 등록 버튼 -->
 <form action='insert_schedule.php'>
  <input type='submit' value='Add Event' />
 </form>
 
 <div id='alarm_time'><?php echo date("Y-m-d H:i:s", time()); ?></div>
 <div> Today Schedule Alarm : </div>
<?php

 $current_day = "$y-$m-$d";
 $alarm_sql = "select schedule, a_date from schedules where '$current_day'=DATE(a_date);";
 $a_rs = $db->execute($alarm_sql);
 $k=0;
 while(!$a_rs->EOF){
	 echo "<p>".$k.". ".$a_rs->fields[0]."</p>";
	echo "<script>
		al_arr[$k] = '".$a_rs->fields[1]."'
		</script>";
	$k++;
	$a_rs->moveNext();
	
	
 }

?>
</div>
<script>

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
		
		document.getElementById('alarm_time').innerHTML = y+'-'+m+'-'+d+' '+h+':'+mi+':'+s;
		if(y+'-'+m+'-'+d+' '+h+':'+mi+':'+s == '2019-07-05 14:03:10'){
			alert('alarm');
		}
		for(var i=0; i<al_arr.length; i++){
			if(al_arr[i] == y+'-'+m+'-'+d+' '+h+':'+mi+':'+s){
				alert((i+1)+'번째 alarm');
			}
		}
	}
</script>
