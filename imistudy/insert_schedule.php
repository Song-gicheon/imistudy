<!doctype html>
<html>
<head>
 <meta charset="utf-8">
 <title> 일정 추가 </title>
</head>
<body>
<?php
 require('cal.inc.php');

 function selectYear($start, $end, $cur=''){
	 for($start; $start<$end+1; $start++){
		 if($start == $cur){
			 $date_year.= "<option value= '$start' selected>$start</option>\n";
		 }else{
			 $date_year.= "<option value= '$start'>$start</option>\n";
		 }
	 }
	 return $date_year;
 }

 function selectMonth($cur = ""){
	 for($m=1; $m<=12; $m++){
		 if(strlen($m) == 1) $m="0".$m;
		 if($m == $cur){
			$date_month .= "<option value=
			'$m' selected>$m</option>";
		 }else{
			 $date_month .= "<option value='$m'>$m</option>";
		 }
	 }
	 return $date_month;
 }

 function selectDay($cur='', $max_date){
	 for($d=1; $d<=$max_date; $d++){
		if(strlen($d) == 1) $d = "0".$d;
		if($d == $cur){
			$date_day .= "<option value='$d' selected>$d</option>";
		}
		else{
			$date_day .= "<option value='$d'>$d</option>";
		}
	 }
	 return $date_day;
 }

 function selectTime($cur=''){
	 for($t=1; $t<=24; $t++){
		 if($t == $cur){
			 $date_time .= "<option value='$t' selected>$t</option>";
		 }else{
			 $date_time .= "<option value='$t'>$t</option>";
		 }
	 }
	 return $date_time;
 }

 function selectGroup($id, $db){
	 $query = "select team_name from team where user_id='$id' group by team_name;";
	 $option .= "<option>NULL</option>";
	 $rs = $db->execute($query);
	 while(!$rs->EOF){
		 $option .= "<option value='".$rs->fields[0]."'>".$rs->fields[0]."</option>";
		 $rs->moveNext();
	 }
	 return $option;
 }
?>
<style>
 select{
  height:30px;
  width:60px;
 }
</style>
<div id='add_container' class='schedule_box'>
	<h1>Add Schedule</h1>
	<div>
		<p> Term </p>
<?php

 $sch_id = $_POST['sch_id'];
 echo "<form class='add_event' action='insert.php' method='post'>";
 echo "<input type='hidden' name='sch_id' value='$sch_id'/>";
 echo "<span id='start_time' class='time_box'>";
 echo "<select name='s_y'>".selectYear('2015', '2050', date('Y'))."</select>";
 echo "<select name='s_m'>".selectMonth(date('m'))."</select>";
 echo "<select name='s_d'>".selectDay(date('d'), $max_date)."</select>";
 echo "<select name='s_t'>".selectTime(date('H'))."</select>";
 echo "</span>";
 
 echo "&nbsp; ~ &nbsp;";

 echo "<span id='end_time' class='time_box'>";
 echo "<select name='e_y'>".selectYear('2015', '2050', date('Y'))."</select>";
 echo "<select name='e_m'>".selectMonth(date('m'))."</select>";
 echo "<select name='e_d'>".selectDay(date('d'), $max_date)."</select>";
 echo "<select name='e_t'>".selectTime(date('H'))."</select>";
 echo "</span>";

?>
	</div>
	<div>
		<p>Schedule Name</p>
		<input type='text' name='sche_name'/> 
	</div>
	<div>
		<p>contents</p>
		<textarea cols='60' rows'50' autofocus requiredwrap='hard'
			placeholder='write.' name='in_schedule'></textarea>
	</div>
	<div id='alarm_set'>
	<p>
		<input type='checkbox' id='chk_alarm' value='alram' onClick="alarm_on()">Alarm
 
		 <span id='alarm_time' class='time_box' name='alarm_box'>
<?php
	 echo "<select id='ay' name='a_y' disabled>".selectYear('2015', '2050', date('Y'))."</select>";
	 echo "<select id='am' name='a_m' disabled>".selectMonth(date('m'))."</select>";
	 echo "<select id='ad' name='a_d' disabled>".selectDay(date('d'), $max_date)."</select>";
	 echo "<select id='ah' name='a_t' disabled>".selectTime(date('H'))."</select>";
	 echo "</span>";
	 echo "</div>";
	 echo "<div>";
	 echo "<p> Group : <select name='group'>".selectGroup($id, $db)."</select></p>";
	 echo "</div>";
?>
	<input type='submit' value='submit'> 
</form>
</div>
 <script language= 'javascript'>
	var chk = document.getElementById('chk_alarm');
	var ay = document.getElementById('ay');
	var am = document.getElementById('am');
	var ad = document.getElementById('ad');
	var ah = document.getElementById('ah');
	 function alarm_on(){
		 if(chk.checked == true){
			 ay.disabled = false;
			 am.disabled = false;
			 ad.disabled = false;
			 ah.disabled = false;
		 }else{
			 ay.disabled = true;
			 am.disabled = true;
			 ad.disabled = true;
			 ah.disabled = true;
		 }
	 }
 </script>

 </body>
 </html>