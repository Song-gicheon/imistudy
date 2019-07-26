<!-- 회원가입 확인 -->
<?php
	$member_name	= $_POST['mbname'];
	$member_id		= $_POST['id'];
	$member_pw		= $_POST['pw'];
	$member_age		= $_POST['age'];
	$member_gender	= $_POST['gender'];


	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$db->execute("start transaction;"); // 여기서는 의미 없지만 통계 추정 테이블 이용시에 의미있음.

	$sql = "INSERT INTO user VALUES('".$member_id."', '".$member_pw."', '".$member_name."', 0, ".$member_age.", ".$member_gender.");";
	$rs = $db->execute($sql);
	if($rs == false){
		echo"
		<script>
			alert('이미 존재하는 아이디 입니다.');
			history.back();
		</script>
		";
	}
	$db->execute("commit;");
	unset($rs);
	header("Location:index.php");

?>