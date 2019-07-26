<!-- 버스 시간표 -->
<?php
	// 세션 연결
	session_start();
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='index.php'; </script>";
	}

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$_POST['title'] = "버 스 시 간 표";
	include("menu.inc.php"); 

	// 텍스트
	$rot_st	= $_POST['routeStart'];
	$rot_en	= $_POST['routeEnd'];

	$rot_ch	= $_POST['routeCode'];
	$rot_pr	= $_POST['routePrice'];
	$bus_rd	= $_POST['round'];
	
	if(isset($_POST['choiceDate'])){
		$date	= $_POST['choiceDate'];
		$_POST['m'] = date('Y-m', strtotime($date));
		$_POST['d'] = date('d', strtotime($date));
	}

	$_POST['Start'] = $rot_st;
	$_POST['End'] = $rot_en;

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/calender.inc.php");
	echo "<input type='hidden' name='routeEnd' value='".$rot_en."'>";
	echo "<input type='hidden' name='routeStart' value='".$rot_st."'>";
	echo "<input type='hidden' name='routeCode' value='".$rot_ch."'>";
	echo "<input type='hidden' name='routePrice' value='".$rot_pr."'>";
	echo "</form>";

?>
<style>
	#main{
		float:right;
		position:relative;
	}
	
	#form{
		position:relative;
		width:600px;
		height:300px;
		padding:30px;
	}
	#user_info{
		width:500px;
		text-align:left;
		margin:20px;
		margin-top:50px;
		border:1px solid black;
		border-collapse:collapse;
	}
	#user_info tr{
		height:50px;
	}
	#user_info .tag{
		cursor:pointer;
	}

	#user_info td, th{
		padding:0 10px 0 20px;
		border-bottom:1px solid gray;
	}
	#user_info td div{
		text-align:center;
		font-weight:bold;
		font-size:50px;
	}
	#user_info tr .t_head{
		border-bottom:none;

	}
</style>
<?php
	// date 값이 오늘보다 이전인 경우 진행하지 않도록 함.
	if(empty($date)){
		$date = $year_month."-".$this_date;
	}
	if(strtotime($date) < strtotime(date('Y-m-d'))){
		echo "
			<script>
				alert('유효하지 않은 날짜입니다.');
			</script>
			";
	}

	$first_price	= $rot_pr * 1.5;
	$premium_price	= $rot_pr * 2;

	// 조회한 운행 정보의 ID를 이용해서 선택된 노선에 대한 모든 정보와, 선택 시간값을 받게 된다.
	// 이 값을 이용해서 해당 노선에 배차된 버스들의 데이터를 전부 가져온다.
	$sql = "SELECT * from bus WHERE race_id=".$rot_ch." and time > '".date('Y-m-d H:i:s')."' order by time;";

	$rs = $db->execute($sql);

	if($rs == false){
		die("버스 시간표 연결 실패");
	}

	// 불러온 버스 배차 시간 데이터를 모두 저장한다.
	while(!$rs->EOF){
		$busTime[] = array(
			'busID'		=> $rs->fields['bus_id'],
			'busGR'		=> $rs->fields['stat'],
			'busTI'		=> $rs->fields['time'],
			'rotID'		=> $rs->fields['race_id']
			);

		$rs->moveNext();
		
	}
	unset($rs);

	// 불러온 데이터 중에서 선택 일자의 버스 시간표만 걸러서 보여준다. 
	// 현재 페이지에서 다른 날짜를 재선택하면, 리다이렉트되어 선택 날짜의 버스 시간표를 보여주도록 한다. datepicker 사용
	

	// 버스 시간표는 table 형식으로 구성되며, 원하는 시간 선택시 해당 버스 예매 페이지로 이동.
	// imistudy/schedule_2/cal.inc.php 파일 가져와서 날짜 변환에 활용한다.
	
	// 버스, 버스 등급, 개당운임료 및 총 운임료 를 전달함.
	// 전송할 데이터 : BUS_ID, BUS_STATE, TICKET_PRICE(= RACE_PRICE * BUS_STATE(x))

?>
	<div id='main'>
	<table id='user_info'>
		<tr>
		<td colspan=3 class='t_head'>
			<div><?=$rot_st?> → <?=$rot_en?></div>
		</td>
		</tr>
		<tr>
		<td colspan=3 class='t_head'>
			<div style="font-size:25px; font-weight:normal;"><?=$date?></div>
		</td>
		</tr>
		<tr>
		<th width='140px'>시간</th>
		<th width='140px'>등급</th>
		<th width='220px'>요금</th>
		</tr>
<?php	
	foreach($busTime as $value){
		if(date("Y-m-d", strtotime($value['busTI'])) == $date){
			echo "<tr class='tag' onclick='Choice_bus(".$value['busID'].", ".$value['busGR'].");'>";
			echo "<td>".date("H:i", strtotime($value['busTI']))."</td>";
			switch($value['busGR']){
				case 1:
					echo "<td>일반</td>";
					echo "<td>".$rot_pr."원</td>";
					break;
				case 2:
					echo "<td>우등</td>";
					echo "<td>".$first_price."원</td>";
					break;
				case 3:
					echo "<td>프리미엄</td>";
					echo "<td>".$premium_price."원</td>";
					break;
				default:
					echo "<td>--------</td>";
			}
			echo "</tr>";
		}
	}
?>
	</table>
	<form id='form' action='sltSeat.php' method='POST'>
	<input type='hidden' name='generalPay' value='<?=$rot_pr?>'>
	<input type="hidden" name="busCode">
	<input type="hidden" name="busGrade">
	<input type="hidden" name="busPayment">
	<input type="hidden" name="busRound" value =<?=$bus_rd?>>
	</form>
	</div>
<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
<script>
	// 원하는 버스 선택하면 좌석 선택 화면으로 전환되게 한다.
	// 전송 데이터는 hidden 타입의 값으로 설정되서 전송된다.
	
	// 클릭한 tr 태그에서 value값을 알아와야 한다.
	function Choice_bus(busCode, busGrade){
		var busPrice;
		switch(busGrade){
			case 1:
				busPrice = <?php echo $rot_pr; ?>;
				break;
			case 2:
				busPrice = <?php echo $first_price; ?>;
				break;
			case 3:
				busPrice = <?php echo $premium_price; ?>;
				break;
			default:
		}
		$('input[name=busCode]').val(busCode);
		$('input[name=busGrade]').val(busGrade);
		$('input[name=busPayment]').val(busPrice);

		$('form').submit();
	}

</script>