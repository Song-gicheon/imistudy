<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title> 일정 변경 </title>
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

</head>
<body>
<?php

	// 변경할 일정에 대한 정보
	// 일정 id, 이름, 기간, 내용, 알람, 그룹
	$schedule_id = $_REQUEST['s_id'];
	$subject	 = $_REQUEST['schedule'];
	$start		 = $_REQUEST['start_time'];
	$end		 = $_REQUEST['end_time'];
	$in_plan	 = $_REQUEST['s_content'];
	$alarm		 = $_REQUEST['alarm_time'];
	$group_id	 = $_REQUEST['g_id'];

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

	function selectDay($cur = ""){
		$max_date = date('t', strtotime($cur));
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

	function selectGroup($db, $group_id){
		$query		= "select id, name from group_tb;";
		$option		.= "<option value=null>---</option>\n";
		$rs = $db->execute($query);
		while(!$rs->EOF){
			if($group_id == $rs->fields['id']){
			$option .= "<option value='".$rs->fields['id']."' selected>".$rs->fields['name']."</option>\n";
		 }else{
			$option .= "<option value='".$rs->fields['id']."'>".$rs->fields['name']."</option>\n";
		 }
			$rs->moveNext();
		}
		return $option;
	}
?>

<div class='schedule_box'>
	<h1>Update Schedule</h1>
	<div id='term_set'>
		<h4> 1. Term </h4>
	<form name='add_event' action='update.php' method='post' onsubmit='return formChk();'>
<?php
	 echo "<input type='hidden' name='s_id' value='".$schedule_id."'/>";

	 echo "<span id='start_time' class='time_box'>";
	 echo "<select name='s_y'>".selectYear('2015', '2050', date('Y', strtotime($start)))."</select>";
	 echo "<select name='s_m'>".selectMonth(date('m', strtotime($start)))."</select>";
	 echo "<select name='s_d'>".selectDay(date('d', strtotime($start)), $max_date)."</select>";
	 echo "<select name='s_t'>".selectTime(date('H', strtotime($start)))."</select>";
	 echo "</span>";
	 
	 echo "&nbsp; ~ &nbsp;";

	 echo "<span id='end_time' class='time_box'>";
	 echo "<select name='e_y'>".selectYear('2015', '2050', date('Y', strtotime($end)))."</select>";
	 echo "<select name='e_m'>".selectMonth( date('m', strtotime($end)))."</select>";
	 echo "<select name='e_d'>".selectDay( date('d', strtotime($end)), $max_date)."</select>";
	 echo "<select name='e_t'>".selectTime( date('H', strtotime($end)))."</select>";
	 echo "</span>";
?>
	</div>
	<div id='name_set'>
		<h4> 2. Schedule Name </h4>
		<input type='text' name='sche_name' value='<?php echo $subject; ?>'/>
	</div>
	<div id='contents_set'>
		<h4> 3. Schedule Contents </h4>
		<textarea cols='70' rows='10' name='in_schedule'><?php echo $in_plan; ?></textarea>
	</div>
	<div id='alarm_set'>
		<h4> 4. Alarm Check </h4>
		<input type='checkbox' id='chk_alarm' name='chk' value='alram' onClick="alarm_on()" checked>
 
		<span id='alarm_time' class='time_box' name='alarm_box'>
<?php
	// 알람 값이 지정되지 않은 경우에 현재 시간을 대입해준다.
	// 그리고 알람 체크박스도 체크하지 않는다.
	if($alarm == 0){
		echo "<script>
				document.getElementById('chk_alarm').checked = false;
				alarm_on();
			 </script>";
		$alarm = date('Y-m-d H:00:00');
	}
	echo "<select id='ay' name='a_y'>".selectYear('2015', '2050', date('Y', strtotime($alarm)))."</select>";
	echo "<select id='am' name='a_m'>".selectMonth(date('m', strtotime($alarm)))."</select>";
	echo "<select id='ad' name='a_d'>".selectDay(date('d', strtotime($alarm)), $max_date)."</select>";
	echo "<select id='ah' name='a_t'>".selectTime(date('H', strtotime($alarm)))."</select>";
	echo "</span>";
	echo "</div>";
	echo "<div id='group_set'>";
	echo "<h4> 5. Group </h4>";
	echo "Group : <select name='group'>".selectGroup($db, $group_id)."</select>";
	echo "</div>";
?>
	<input type='submit' value='submit'> 
</form>
</div>
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
	alarm_on();
 </script>

 </body>
 </html>

