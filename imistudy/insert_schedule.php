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
 echo "</span>";
 
 echo "&nbsp; ~ &nbsp;";

 echo "<span id='end_time' class='time_box'>";
 echo "<select name='e_y'>".selectYear('2015', '2050', date('Y'))."</select>";
 echo "<select name='e_m'>".selectMonth(date('m'))."</select>";
 echo "<select name='e_d'>".selectDay(date('d'), $max_date)."</select>";
 echo "<select name='e_t'>".selectTime(date('H'))."</select>";
 echo "</span>";

?>
<div>
	<div>
		<input type='text' name='sche_name'/> 
	</div>
	<div>
		<textarea cols='60' rows'50' autofocus requiredwrap='hard'
			placeholder='write.' name='in_schedule'></textarea>
	</div>
	<div id='alarm_set'>
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
	 echo "Group : <select name='group'>".selectGroup($id, $db)."</select>";
	 echo "</div>";
?>
	<input type='submit' value='submit'> 
	</div>
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