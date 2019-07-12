<?php
	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/schedule_2/connect.inc.php");

	// 멤버를 추가할 그룹 id
	$group_id	= $_GET['g_id'];
	$member		= $_GET['member_name'];


	// Update 하기 전에 추가할 그룹이 테이블에 존재하는지 미리 검색
	$sql	= "Select id from group_tb where id='".$group_id."'";
	$rs		= $db->execute($sql);

	if($rs == false){
		die('DB 연결 에러');
	}

	if(!$rs->EOF){
		// 검색 후에 나온 결과값을 이용해서 데이터 추가
		$sql	= "INSERT INTO group_mem(name, group_id) VALUES";

		for($k=0; $k<count($member); $k++){

			$sql .= "('".$member[$k]."', ".$group_id.")";

			if($k != count($member)-1){
				$sql .= ", ";
			}
		}

		$ok		= $db->execute($sql);
		
		// 2차 쿼리문 에러 처리
		if($ok == false){
			die('DB 연결 에러 2');
		}

		// 삭제 후에 affected rows 값을 확인해서 데이터가 제대로 삭제되었는지 확인
		if(!$db->affected_rows()){
			echo "<script>
				alert('멤버가 추가되지 않았습니다.');
				history.back();
				</script>";
		}
	}
	else{		
		// 만약 변경할 그룹 테이블이 존재하지 않는다면 에러 메시지 출력.
		echo "<script>
				alert('선택하신 그룹이 존재하지 않습니다..');
				history.back();
			 </script>";
	}

	Header("Location:select_schedule.php");

?>

