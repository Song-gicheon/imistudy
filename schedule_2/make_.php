<?php
	// 세션 연결
	session_start();
	$url = ($_SERVER['HTTPS'] == 'on')?'https://':'http://';
	$url .= ($_SERVER['SERVER_PORT'] != '80')?$_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT']:$_SERVER['HTTP_HOST']; 
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='".$url."/imistudy/imistudy_2/index.php'; </script>";
	}
	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/connect.inc.php");


	$group_name = $_POST['team_name'];
	$member		= $_POST['member_name'];

	// SELECT를 이용해서 이미 사용되는 그룹 이름인지 확인합니다.

	$sql	= "SELECT name from group_tb WHERE name='".$group_name."' AND user_id = '".$_SESSEION['id']."';";
	$rs		= $db->execute($sql);

	// 1차 쿼리문 에러 처리
	if($rs == false){
		die('DB 연결 에러');
	}

	// 이미 사용중인 일정 이름을 재사용하는 경우에 뒤로가기 합니다.
	// 같은 id의 경우 중복된 그룹명 사용 불가
	// group_tb의 그룹명 name 속성은 Unique Key 로 설정되어 있음.

	if($rs->EOF){

		$sql = "INSERT IGNORE INTO group_tb VALUES('', '".$group_name."', '".$_SESSEION['id']."');";
		$ok	 = $db->execute($sql);

		if($ok == false){
			die('DB 연결 에러2');
		}
			
		// 변경된 값이 존재하지 않는 경우, 사용자에게 알립니다. (이미 삽입된 경우)
		if(!$db->affected_rows()){
			echo "<script>
				alert('그룹이 추가되지 않았습니다.');
				</script>";
		}

		// 이후 추가된 그룹에 그룹원도 추가합니다.
		$sql = "INSERT INTO group_mem(name, group_id) VALUES";
		for($k=0; $k<count($member); $k++){

			$sql .= "('".$member[$k]."', (SELECT id FROM group_tb WHERE name = '".$group_name."'))";

			if($k != count($member)-1){
				$sql .= ", ";
			}
		}

		$ok2 = $db->execute($sql);

		if($ok2 == false){
			die('DB 연결 에러3');
		}
		// 변경된 값이 존재하지 않는 경우, 사용자에게 알립니다.
		if(!$db->affected_rows()){
			echo "<script>
				alert('그룹의 멤버가 추가되지 않았습니다.');\
				location.href='Location:select_schedule.php';
				</script>";
		}
	}
	else{
		echo "<script>
				alert('이미 사용중인 그룹명입니다.');
				history.back();
				</script>";
	}
	Header("Location:select_schedule.php");

?>