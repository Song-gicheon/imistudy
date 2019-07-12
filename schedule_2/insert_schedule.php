<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title> 일정 추가 </title>
<style>
 select{
	 height:30px;
	 width:60px;
}

 .schedule_box{
	float:right;
	margin:10px;
	width:620px;
}
</style>
<script>
	function formChk(){
		var start_time = add_event.s_y.value+add_event.s_m.value+add_event.s_d.value+add_event.s_t.value;
		var end_time = add_event.e_y.value+add_event.e_m.value+add_event.e_d.value+add_event.e_t.value;

		if(start_time > end_time){
			alert('일정이 올바르지 않습니다.');
			return false;
		}
		if(!add_event.sche_name.value){
			alert('일정 이름을 적어주세요.');
			return false;
		}
		if(!add_event.in_schedule.value){
			alert('일정 내용을 적어주세요.');
			return false;
		}
	}

</script>
</head>
<body>
<?php

	$this_year = date('Y');
	$this_month = date('m');
	$this_date = date('d');
	$max_date = date('t', strtotime($this_year."-".$this_month));


	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/connect.inc.php");


	// 각 년-월-일-시, 그룹에 대해 Select Box를 만들어주는 함수 선언.

	function selectYear($start, $end, $cur=''){
		for($start; $start<$end+1; $start++){
			if($start == $cur){
				$date_year.= "<option value='".$start."' selected>$start</option>\n";
			}else{
				$date_year.= "<option value= '".$start."'>".$start."</option>\n";
			}
		}
		return $date_year;
	}

	function selectMonth($cur = ""){
		for($m=1; $m<=12; $m++){
			if(strlen($m) == 1){
				$m="0".$m;
			}
			if($m == $cur){
				$date_month .= "<option value=".$m." selected>".$m."</option>\n";
			}else{
				$date_month .= "<option value='".$m."'>".$m."</option>\n";
			}
		}
		return $date_month;
	}

	function selectDay($cur = "", $max_date){
		for($d=1; $d<=$max_date; $d++){
			if(strlen($d) == 1) $d = "0".$d;
			if($d == $cur){
				$date_day .= "<option value='".$d."' selected>".$d."</option>\n";
			}
			else{
				$date_day .= "<option value='".$d."'>".$d."</option>\n";
			}
		}
		return $date_day;
	}

	function selectTime($cur = ""){
		for($t=1; $t<=24; $t++){
			if($t == $cur){
				$date_time .= "<option value='".$t."' selected>".$t."</option>\n";
			}else{
				$date_time .= "<option value='".$t."'>".$t."</option>\n";
			}
		}
		return $date_time;
	}

	function selectGroup($db){
		$query = "select id, name from group_tb;";
		$option .= "<option value=null>---</option>\n";
		$rs = $db->execute($query);
		while(!$rs->EOF){
			$option .= "<option value='".$rs->fields['id']."'>".$rs->fields['name']."</option>\n";
			$rs->moveNext();
		}
		return $option;
	}
	// 일정을 작성해서 서버 DB에 Insert 한다.
?>

<div class='schedule_box'>
	<h1>Add Schedule</h1>
	<div id='term_set'>
		<h4> 1. Term </h4>
	<form name='add_event' action='insert.php' method='post' onsubmit='return formChk();'>
<?php
	 echo "<span id='start_time' class='time_box'>";
	 echo "<select name='s_y'>".selectYear('2015', '2050', $this_year)."</select>";
	 echo "<select name='s_m'>".selectMonth($this_month)."</select>";
	 echo "<select name='s_d'>".selectDay($this_date, $max_date)."</select>";
	 echo "<select name='s_t'>".selectTime(date('H'))."</select>";
	 echo "</span>";
	 
	 echo "&nbsp; ~ &nbsp;";

	 echo "<span id='end_time' class='time_box'>";
	 echo "<select name='e_y'>".selectYear('2015', '2050', $this_year)."</select>";
	 echo "<select name='e_m'>".selectMonth($this_month)."</select>";
	 echo "<select name='e_d'>".selectDay($this_date, $max_date)."</select>";
	 echo "<select name='e_t'>".selectTime(date('H'))."</select>";
	 echo "</span>";
?>
	</div>
	<div id='name_set'>
		<h4> 2. Schedule Name </h4>
		<input type='text' name='sche_name'/>
	</div>
	<div id='contents_set'>
		<h4> 3. Schedule Contents </h4>
		<textarea cols='70' rows='10' autofocus requiredwrap='hard'
			placeholder='write.' name='in_schedule'></textarea>
	</div>
	<div id='alarm_set'>
		<h4> 4. Alarm Check </h4>
		<input type='checkbox' id='chk_alarm' name='chk' value='alram' onClick="alarm_on()">
 
		 <span id='alarm_time' class='time_box' name='alarm_box'>
<?php
	 echo "<select id='ay' name='a_y' disabled>".selectYear('2015', '2050', $this_year)."</select>";
	 echo "<select id='am' name='a_m' disabled>".selectMonth($this_month)."</select>";
	 echo "<select id='ad' name='a_d' disabled>".selectDay($this_date, $max_date)."</select>";
	 echo "<select id='ah' name='a_t' disabled>".selectTime(date('H'))."</select>";
	 echo "</span>";
	 echo "</div>";
	 echo "<div id='group_set'>";
	 echo "<h4> 5. Group </h4>";
	 echo "Group : <select name='group'>".selectGroup($db)."</select>";
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

