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
			$date_month .= "<option value='$m' selected>$m</option>";
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
?>
<style>
 #add_container{
  margin:30px;
  padding:30px;
 }
 select{
  height:30px;
  width:60px;
 }
</style>
 <div id='add_container' >
 <h1>Add Event</h1>
<?php

 $y = date('Y');
 $m = date('m');
 $d = date('d');
 echo "<form class='add_event' action='insert.php' method='post'>";
 echo "<span id='start_time' class='time_box'>";
 echo "<select name='s_y'>".selectYear('2015', '2050', date('Y'))."</select>";
 echo "<select name='s_m'>".selectMonth(date('m'))."</select>";
 echo "<select name='s_d'>".selectDay(date('d'), $max_date)."</select>";
 echo "<select name='s_t'>".selectTime(date('H'))."</select>";
 echo "</sapn>";
 
 echo "&nbsp; ~ &nbsp;";

 echo "<span id='end_time' class='time_box'>";
 echo "<select name='e_y'>".selectYear('2015', '2050', date('Y'))."</select>";
 echo "<select name='e_m'>".selectMonth(date('m'))."</select>";
 echo "<select name='e_d'>".selectDay(date('d'), $max_date)."</select>";
 echo "<select name='e_t'>".selectTime(date('H'))."</select>";
 echo "</span>";

?>
  <script language= 'javascript'>
 function alarm_on(){
	 var chk = document.getElementById('chk_alarm');
	 var box = document.getElementById('alarm_time');
	 if(chk.checked == true)
		 box.disabled = false;
	 else
		 box.disabled = true;
 }
 </script>
 <input type='text' name='sche_name'/> 
 <textarea cols='60' rows'50' autofocus requiredwrap='hard'
 placeholder='write.' name='in_schedule'></textarea>
<div id='alarm_set'>
<input type='checkbox' id='chk_alarm' value='alram' onClick="alarm_on()">Alarm
 
 <span id='alarm_time' class='time_box' name='alarm_box' disabled=''>
<?php
 echo "<select name='a_y'>".selectYear('2015', '2050', date('Y'))."</select>";
 echo "<select name='a_m'>".selectMonth(date('m'))."</select>";
 echo "<select name='a_d'>".selectDay(date('d'), $max_date)."</select>";
 echo "<select name='a_t'>".selectTime(date('H'))."</select>";
 echo "</span>";
?>
</div>
<input type='submit' value='submit'> 
</form>
</div>
