<!-- 예매 취소 -->

<?php
	// 세션 연결
	session_start();
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='index.php'; </script>";
	}

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

?>
<?php
	// 마이페이지에서 본인 예매 내역을 확인하고, 가능하다면 취소할 수 있도록 합니다.
	// 여기서 예매 시간과 버스 시간을 비교해서 예매 취소 여부를 가늠합니다.

	// 취소할 때에도 update 문으로 사용 금액을 감해야 하므로 트랜잭션이 사용됩니다.

	$ticket		= $_POST['cancelCode'];
	$endTime	= $_POST['cancelTime'];

	$rs = $db->execute("start transaction;");
	if($rs == false){
		die('?? 오류생김');
	}


	// 조회한 버스 출발 시간과 현재 시간과 비교하여 취소가 가능한 시간인지 확인합니다.
	$sql = "SELECT time FROM bus WHERE bus_id = (SELECT bus_id FROM ticket WHERE ticket_id = ".$ticket.");";
	$rs = $db->execute($sql);

	if($rs == false || $rs->EOF){
		die('잘못된 티켓.');
	}
	if($endTime < strtotime("now")){
		// 현재시간이 버스 도착시간 이후일 때에는 취소가 불가능함.
		echo "
		<script>
			alert('시간이 초과되어 예매 취소가 불가능합니다.');
			history.back();
		</alert>
			";
	}
	
	// 해당 티켓 가격의 90% 만큼 사용자의 결제 금액을 반환하고
	$sql = "UPDATE user SET money = money - (0.9*(SELECT payment FROM ticket WHERE ticket_id = ".$ticket.")) WHERE id = '".$_SESSION['id']."';";
	$rs = $db->execute($sql);

	
	if($rs == false || $db->affected_rows() < 1){
		die('환불 실패');
	}

	// 그리고 취소 테이블에 취소된 예매 정보를 등록합니다.
	// 이는 예매-취소 과정에서 수수료가 발생하기 때문에 정확한 거래정보를 관리하기 위함입니다.
	// 수수료는 10% 입니다.
	$sql = "INSERT INTO cancel_tb(bus_id, seat_num, user_id, refund) SELECT bus_id, seat_num, user_id, payment*0.1 FROM ticket WHERE ticket_id = ".$ticket.";";
	$rs = $db->execute($sql);

	if($rs == false){
		die('취소 실패');
	}

	// 해당 티켓 예매 정보는 삭제합니다.
	$sql = "DELETE FROM ticket WHERE ticket_id = ".$ticket.";";
	$rs = $db->execute($sql);

	if($rs == false || $db->affected_rows() < 1){
		die('삭제 실패');
	}



	$rs = $db->execute("commit;");
	if($rs == false){
		die('커밋?? 오류생김');
	}
	
	unset($rs);

	echo "<script>alert('해당 티켓이 취소되었습니다.'); history.back();</script>";



?>