<?php
// 1. 시간 단위별 예매/ 매출 통계 확인		benefit.php	

	$startTime	= $_POST['ticketCheckS'];
	$endTime	= $_POST['ticketCheckE'];


	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$sql = "SELECT sum(ticket_cnt) AS ticketing, sum(ticket_pay) AS payment
			FROM sales_hour
			WHERE term >= '".$startTime."' AND term < '".$endTime."';";

	$rs = $db->execute($sql);

	if($rs == false || $rs->EOF){
		die('실패');
	}
	
	echo "총 예매 수 : ".$rs->fields['ticketing']." 회<br>";
	echo "총 매출액  : ".$rs->fields['payment']." 원<br>";
?>