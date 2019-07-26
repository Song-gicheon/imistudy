<?php
	// 전달받은 id값으로 예매 정보를 조회해서 반환함.

	$user_id	= $_POST['id'];
	
	$today		= $_POST['date']; // 오늘 날짜가 주어진 경우

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$sql_ticket	=	"SELECT bus.stat, bus.time, race.start, race.end, race.race_time, ticket.seat_num, ticket.ticketing_time, ticket.payment, ticket.ticket_id
					 FROM bus JOIN race ON bus.race_id=race.race_id JOIN ticket ON bus.bus_id=ticket.bus_id 
					 WHERE ticket.user_id='".$user_id."' order by ticket.ticketing_time desc;";
	$rs_ticket = $db->execute($sql_ticket);
	
	if($rs_ticket == false || $rs_ticket->EOF){
		echo "예매 내역이 없습니다.";
		return;
	}
	// 일단은 전부 담아두고, 조건이 없을시에는 전부 출력한다.
	// 조건이 주어지면 조건에 따라서 출력한다.
	// 또한 현재 시간과 도착 시간을 비교해서 예매 취소 여부를 결정한다.
	echo "예 매 내 역";
	while(!$rs_ticket->EOF){
		if(!empty($today)){
			if($today != date('Y-m-d', strtotime($rs_ticket->fields['time']))){
				$rs_ticket->moveNext();
				continue;
			}
		}

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

		$raceTime	= $rs_ticket->fields['race_time'];
		$th			= (int)date("H", strtotime($raceTime));
		$tm			= (int)date("i", strtotime($raceTime));
		$endTime	= date("Y-m-d H:i:s", strtotime("+".$th." hours"."+".$tm." minutes".$rs_ticket->fields['time']));

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

		echo "<tr>";
		echo "	<td class='etime' colspan='2'>";
		echo "	<div>도착 예정시간</div>".$endTime;
		echo "	</td>";
		echo "</tr>";
		
		echo "<tr><td>예매시간 : ".$rs_ticket->fields['ticketing_time']."</td></tr>";
		echo "<tr><td>예매요금 : ".$rs_ticket->fields['payment']."</td></tr>";
		

		if(time() < strtotime($endTime)){
			echo "<tr><td><button onClick='Cancel(".$rs_ticket->fields['ticket_id'].", ".strtotime($endTime).");'> 예매 취소 </button></td></tr>";
		}
		echo "</table>";

		$rs_ticket->moveNext();
	}
			
	
	unset($rs_ticket);
?>