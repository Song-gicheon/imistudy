<?php
	// include 경로는 절대 경로로 맞춰준다.
	// DB = $db;
	include($_SERVER['DOCUMENT_ROOT']."/dev_test/schedule_2/connect.inc.php");

	// 삭제할 그룹 id
	$delete_group = $_REQUEST['del_id'];

	// Delete 하기 전에 삭제할 데이터가 존재하는지 미리 검색
	$sql	= "Select id, name from group_tb where id='".$delete_group."'";
	$rs		= $db->execute($sql);
	if($rs == false){
		die('DB 연결 에러');
	}
	if(!$rs->EOF){

		// 검색 후에 나온 결과값을 이용해서 삭제.
		$sql	= "Delete from group_tb where id='".$rs->fields['id']."'";
		$ok		= $db->execute($sql);
		
		// 2차 쿼리문 에러 처리
		if($ok == false){
			die('DB 연결 에러');
		}

		// 삭제 후에 affected rows 값을 확인해서 데이터가 제대로 삭제되었는지 확인
		if(!$db->affected_rows()){
			echo "<script>
				alert('그룹이 삭제되지 않았습니다.');
				</script>";
		}

		$sql	= "Delete from group_mem where group_id='".$rs->fields['id']."'";
		$ok2	= $db->execute($sql);

		// 3차 쿼리문 에러 처리
		if($ok2 == false){
			die('DB 연결 에러');
		}

		// 삭제 후에 affected rows 값을 확인해서 데이터가 제대로 삭제되었는지 확인
		if(!$db->affected_rows()){
			echo "<script>
				alert('구성원이 없는 그룹입니다.');
				history.back();
				</script>";
		}

	}
	else{		
		// 만약 삭제할 데이터가 존재하지 않는다면 에러 메시지 출력.
		echo "<script>
				alert('삭제할 그룹이 존재하지 않습니다..');
				history.back();
			 </script>";
	}
	;

?>

