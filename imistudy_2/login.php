<!-- 로그인 -->
<?php
	session_start();
	$id = $_POST['login_id'];
	$pwd = $_POST['login_pw'];
	
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");
	$sql = "select id, passwd from user where id='".$id."' and passwd='".$pwd."';";

	$result = $db->execute($sql);
	if($result == false){
		die('로그인 DB 연결 에러');
	}
	else{
		if(!$result->EOF){
			$_SESSION['id'] = $id;
			Header("Location:routeSrch.php");
		}
		else{
			echo "<script>						"; 
			echo "	alert('Log-In False');		";
			echo "	location.href='index.php';	";
			echo "</script>						";
		}
	}
				
	unset($result);

?>