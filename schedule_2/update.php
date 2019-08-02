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
<?php
	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/connect.inc.php");

	// Post로 받은 값들 : 선택 일정 ID, 일정 이름, 시작, 끝, 내용, 알람, 그룹
	$schedule_id= $_POST['s_id'];
	$s_name		= $_POST['sche_name'];
	$start		= $_POST['s_y'].$_POST['s_m'].$_POST['s_d'].$_POST['s_t']."0000";
	$end		= $_POST['e_y'].$_POST['e_m'].$_POST['e_d'].$_POST['e_t']."0000";
	$in_plan	= $_POST['in_schedule'];
	$team		= $_POST['group'];
	if(isset($_POST['chk'])){
		$alarm	= $_POST['a_y'].$_POST['a_m'].$_POST['a_d'].$_POST['a_t']."0000";
	}

	// SELECT를 이용해서 존재하는 일정인지 확인합니다.
	$sql	= "SELECT id FROM schedules WHERE id='".$schedule_id."';";
	$rs		= $db->execute($sql);

	// 1차 쿼리문 에러 처리
	if($rs == false){
		die('DB 연결 에러');
	}

	if(!$rs->EOF){

		// 일정을 변경합니다..
		$sql	=	"UPDATE schedules
					 SET name= '".$s_name."', s_date='".$start."', e_date='".$end."', content='".$in_plan."', a_date='".$alarm."', group_id='".$team."'
					 WHERE id='".$rs->fields['id']."'";
		$ok		= $db->execute($sql);

		// 2차 쿼리문 에러 처리
		if($ok == false){
			die('DB 연결 에러');
		}
		// 삭제 후에 affected rows 값을 확인해서 데이터가 제대로 삭제되었는지 확인
		
		if(!$db->affected_rows()){
			echo "<script>
				alert('값이 변경되지 않았습니다.');
				location.href=\"select_schedule.php?m=".$_POST['s_y']."-".$_POST['s_m']."&d=".$_POST['s_d']."\";
				</script>";
		}
	}
	else{		
		// 만약 변경할 데이터가 존재하지 않는다면 에러 메시지 출력.
		echo "<script>
				alert('변경할 일정이 존재하지 않습니다..');
				history.back();
			 </script>";

	}
	echo "<script>
			alert('정상적으로 변경되었습니다.');
			location.href=\"select_schedule.php?m=".$_POST['s_y']."-".$_POST['s_m']."&d=".$_POST['s_d']."\";
		 </script>";


?>