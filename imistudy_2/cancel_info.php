<?php
	// 전달받은 id값으로 예매 정보를 조회해서 반환함.

	$user_id	= $_POST['id'];

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$sql_ticket	=	"SELECT bus.stat, bus.time, race.start, race.end, race.race_time, cancel_tb.seat_num, cancel_tb.cancel_time, cancel_tb.refund, cancel_tb.cancel_id
					 FROM bus JOIN race ON bus.race_id=race.race_id JOIN cancel_tb ON bus.bus_id=cancel_tb.bus_id 
					 WHERE cancel_tb.user_id='".$user_id."' order by cancel_tb.cancel_time desc;";
	$rs_ticket = $db->execute($sql_ticket);
	
	if($rs_ticket == false || $rs_ticket->EOF){
		echo "취소 내역이 없습니다.";
		return;
	}
	// 일단은 전부 담아두고, 조건이 없을시에는 전부 출력한다.
	// 조건이 주어지면 조건에 따라서 출력한다.
	// 또한 현재 시간과 도착 시간을 비교해서 예매 취소 여부를 결정한다.
	echo "취 소 내 역";
	while(!$rs_ticket->EOF){

		switch($rs_ticket->fields['stat']){
			case 1:
				$grade = "일반";
				break;
			case 2:
				$grade = "우등";
				break;
			case 3:
				$grade = "프리미엄";
				break;
			default:
				$grade = "알수없음";
		}

		echo "<table class='ticket'>";
		echo "<tr>";
		echo "	<td class='stime' colspan='2'>";
		echo "	<div>출발시간</div>".$rs_ticket->fields['time'];
		echo "	</td>";
		echo "</tr>";


		echo "<tr class='city'>";
		echo "	<td> 출발지 </td>";
		echo "	<td> 도착지 </td>";
		echo "</tr>";


		echo "<tr>";
		echo "	<td>".$rs_ticket->fields['start']."</td>";
		echo "	<td>".$rs_ticket->fields['end']."</td>";
		echo "</tr>";

		echo "<tr><td>취소시간 : ".$rs_ticket->fields['cancel_time']."</td></tr>";
		echo "<tr><td>수수료   : ".$rs_ticket->fields['refund']."</td></tr>";
		
		echo "</table>";

		$rs_ticket->moveNext();
	}
			
	
	unset($rs_ticket);
?>