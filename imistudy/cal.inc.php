<?php

 include('../../adodb5/adodb.inc.php');
 $db = newADOConnection('mysqli');

 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");

 $pagename = basename($_SERVER['PHP_SELF']); 

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
 <script src='http://code.jquery.com/jquery-1.10.2.js'></script>
 <script>
</script>

 <style>
 .schedule_box{
	float:right;
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
 for($i=1; $i<=$total_week; $i++){
?> 
 <tr>
<?php
 $lunc = false;
 for($j=0; $j<7; $j++){
	 echo "<td class='select_date' style='table-layout:fixed;' align='left' valign='top'
	 onclick='javascript:location.href=\"select_schedule.php?year=$year&month=$month&day=$day\"'>";
	 if(!(($i==1 && $j< $start_day)||($i==$total_week && $j>$last_day))){
		 if($j==0){
			 $style = 'red';
		 }else if($j==6){
			 $style = 'blue';
		 }else if($j==1 || $j==3 || $j==5){
			 $lunc = true;
		 }else{
			 $style = 'black';
		 }
		 if($year==$y && $month==$m && $day==date('j')){
		 }
		 // 각 날짜마다 클릭해서 일정 확인 가능. 
		 echo "<font color='$style' padding='3'>$day</font>";

		 // 음력 표기일 ( 월 수 금 )
		 if($lunc == true){
			 echo "<font class='luna' color='black' padding='4' align='left'></font>";
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
			echo $ok->fields[$i];
		 }

		 $day++;
	 }
	 echo "</td>";
 }
?>

 </tr>
<?php
}
?>
 </table>
<!--  달력 아래에 일정 등록 버튼 -->
 <form action='insert_schedule.php' method='post'>
  <input type='submit' value='Add Event' /></form>
 
</div>
