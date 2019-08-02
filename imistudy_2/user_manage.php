<?php
// 2. 회원별 이용 내역 확인 (우수고객)		user_manage.php

	$startTime	= $_POST['userTicketS'];
	$endTime	= $_POST['userTicketE'];


	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$sql = "SELECT user_id, sum(ticket_cnt) AS ticketing, sum(ticket_pay) AS payment
			FROM sales_hour
			WHERE term >= '".$startTime."' AND term < '".$endTime."'
			group by user_id order by payment desc;";

	$rs = $db->execute($sql);

	if($rs == false || $rs->EOF){
		die('실패');
	}
	while(!$rs->EOF){
		
		echo "사용자 명  : ".$rs->fields['user_id']." <br>";
		echo "총 예매 수 : ".$rs->fields['ticketing']." 회<br>";
		echo "총 매출액  : ".$rs->fields['payment']." 원<br><br>";

		$rs->moveNext();
	}
?> 