<!-- 예매 발권 -->
<form action='bustime.php' method='post'>
	<input type='hidden' name='routeCode'>
	<input type='hidden' name='routePrice'>
	<input type='hidden' name='busRound'>
</form>
<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
<script>
	function back_bus(routeCode, routePrice){

		$('input[name=routeCode]').val(routeCode);
		$('input[name=routePrice]').val(routePrice);
		$('input[name=busRound]').val(1);
	
		$('form').submit();
	}
</script>
<?php
	// 세션 연결
	session_start();
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='index.php'; </script>";
	}
	// 최종적으로 INSERT가 실행되는 테이블이 여러개이므로 Insert를 여러번 실행시켜야 한다.
	// 그래서 트랜잭션을 실행한 후, Insert가 실행되는 과정에서 문제가 생기면 롤백할 수 있도록 해준다.
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");
	$tran = $db->execute("start transaction;");
	if($tran == false){
		die('transaction error');
	}


	// 전송받는 데이터 : 선택한 버스, 선택 자리(복수 가능), 총 금액
	$bus_ch		= $_POST['busCode'];
	$bus_set	= $_POST['seatNum'];
	$bus_pay	= $_POST['busPayment'];
	$tot_pay	= $_POST['totalPay'];
	$bus_rd		= $_POST['busRound'];

	// 전송받은 데이터를 검증한다.
	// select문을 이용해서 버스 존재하는지 확인, 그리고 티켓 이미 있는지 확인.
	// 데이터 검증이 완료되면 Insert 하며, 검증 과정에서 문제가 생기는 경우 예외처리한다.
	$sql = "SELECT ticket_id FROM ticket WHERE seat_num IN(";
	foreach($bus_set as $value){
		$sql .= $value.", ";
	}
	$sql .= "NULL) AND bus_id IN(SELECT bus_id FROM bus WHERE bus_id = ".$bus_ch.");";

	$rs = $db->execute($sql);
	if($rs == false){
		die('ticketing 데이터 검증 오류 발생 아마도 버스가 없음.');
		// 이경우엔 경고창 띄우고 처음 화면으로 이동시키면 될거같음.
	}
	if(!$rs->EOF){
		echo "이미 발권됨";
		// 마찬가지로 뒤로 이동

	}
	// 발권 정보가 없는 경우에만 예매 과정을 거치게 된다.
	
	// 1. 사용자 테이블에 결제된 금액을 추가한다. ( 실제로 결제가 이루어졌다고 가정함.)
	// user.money = 사용자가 현재까지 사용한 금액.
	$sql_pay	= "Update user SET money = money+".$tot_pay." WHERE id = '".$_SESSION['id']."';";
	$pay_rs		= $db->execute($sql_pay);

	if($pay_rs == false || $db->affected_rows() < 1){
		echo "<script>alert('ERROR');</script>";
		die('error');

		// 쿼리가 실행되지 않았거나, 값이 변경되지 않는 경우 모든 거래 진행을 취소함.
		// 이 경우에는 쿼리 문제로 값이 들어가지 않았거나, 실제로는 예매하지 않은 경우(0)를 포함함.
	}

	// 2. 결제 상황에 이상이 없으면 티켓 테이블에 예매 내역을 추가한다.
	$sql_ticket = "INSERT INTO ticket VALUES";
	foreach($bus_set as $value){
		$sql_ticket .= "('', ".$bus_ch.", ".$value.", '".$_SESSION['id']."', DEFAULT, ".$bus_pay.")";
		if(next($bus_set) == true){
			$sql_ticket .= ", ";
		}
	}
	$sql_ticket .= ";";

	echo $sql_ticket."<br>";
	$rs = $db->execute($sql_ticket);
	if($rs == false){
		die('예매되지 않았습니다.');
	}

	// 모두 예매되었으면 commit 한다.
	$cmt = $db->execute("COMMIT;");
	if($cmt == false){
		die('commit error');
	}

	
	unset($pay_rs);
	unset($rs_ticket);
	unset($rs);
	unset($cmt);

	// 왕복이라면 다시 버스 시간표 화면으로 돌아간다.
	// 이때, 도착지와 출발지가 바뀌어야 한다.

	echo $bus_rd;
	if($bus_rd == 2){
		$sql = "SELECT race_id, price From race WHERE (start, end) IN(SELECT end, start FROM race WHERE race_id=(SELECT race_id FROM bus WHERE bus_id = ".$bus_ch."));";
		$rs = $db->execute($sql);
		if($rs == false){
			die('왕복');
		}
		unset($rs);
		echo "<script>back_bus(".$rs->fields['race_id'].", ".$rs->fields['price'].");</script>";
		
	}
	// 전부 진행되었으면 예매 내역을 확인하는 myPage로 이동한다.
	else{
		header("Location:myPage.php");
	}
	
?>