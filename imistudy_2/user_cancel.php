<?php
// 3. 회원별 취소 내역 확인					user_cancel.php

	$startTime	= $_POST['userCancelS'];
	$endTime	= $_POST['userCancelE'];


	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$sql = "SELECT user_id, sum(cancel_cnt) AS canceling, sum(cancel_ref) AS refund
			FROM cancel_hour
			WHERE term >= '".$startTime."' AND term < '".$endTime."'
			group by user_id order by canceling desc;";

	$rs = $db->execute($sql);

	if($rs == false || $rs->EOF){
		die('실패');
	}
	while(!$rs->EOF){
		
		echo "사용자 명  : ".$rs->fields['user_id']." <br>";
		echo "취소 횟수 : ".$rs->fields['canceling']." 회<br>";
		echo "지불 수수료 총액  : ".$rs->fields['refund']." 원<br><br>";

		$rs->moveNext();
	}
?>