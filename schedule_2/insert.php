<script>
	//insert_confirm();
	function insert_confirm(){
		var flag = confirm("이미 같은 이름의 일정이 존재합니다.\n계속하시겠습니까?");
		if(!flag){
			history.back();
		}
	}
</script>
<?php
	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/dev_test/schedule_2/connect.inc.php");

	// Post로 받은 값들 : 일정 이름, 시작, 끝, 내용, 알람, 그룹
	$s_name		= $_POST['sche_name'];
	$start		= $_POST['s_y'].$_POST['s_m'].$_POST['s_d'].$_POST['s_t']."0000";
	$end		= $_POST['e_y'].$_POST['e_m'].$_POST['e_d'].$_POST['e_t']."0000";
	$in_plan	= $_POST['in_schedule'];
	$team		= $_POST['group'];
	if(isset($_POST['chk'])){
		$alarm	= $_POST['a_y'].$_POST['a_m'].$_POST['a_d'].$_POST['a_t']."0000";
	}

	// SELECT를 이용해서 이미 사용되는 일정 이름인지 확인합니다.
	$sql	= "SELECT name FROM schedules WHERE name='".$s_name."';";
	$rs		= $db->execute($sql);

	// 1차 쿼리문 에러 처리
	if($rs == false){
		die('DB 연결 에러');
	}

	// 이미 사용중인 일정 이름을 재사용하는 경우에 경고합니다.
	if(!$rs->EOF){
		echo "<script>insert_confirm();</script>";
	}
	
	// 일정 이름과 기간이 동일한 경우에는 이미 존재하는 일정으로 생각하여
	// 일정이 추가되지 않도록 합니다.
	$sql = "INSERT IGNORE INTO schedules VALUES
	('', '".$s_name."', ".$start.", ".$end.", '".$in_plan."', '".$alarm."', ".$team.");";
	
	$ok = $db->execute($sql);
	
	// 2차 쿼리문 에러 처리
	if($ok == false){
		die('DB 연결 에러');
	}
	
	// 변경된 값이 존재하지 않는 경우, 사용자에게 알립니다.
	if(!$db->affected_rows()){
		echo "<script>
			alert('일정이 추가되지 않았습니다.');\
			location.href='Location:select_schedule.php';
			</script>";

	}

	// 제대로 입력되면 입력된 일정 페이지로 이동합니다.
	else{
		Header("Location:select_schedule.php?m=".$_POST['s_y']."-".$_POST['s_m']."&d=".$_POST['s_d']);
	}

?>