<!-- 좌석 선택 -->
<style>
	#main{
		float:right;
		position:relative;
		left:-50%;
	}

	#seat_form{
		float:left;
		position:relative;
		width:400px;
		padding:10px 5% 10% 5%;
		margin: 10px;
		text-align:center;
		left:50%;
	}

	table{
		margin:auto;
		width:80%;
	}
	#general_bus td{
		width:50px;
		height:40px;
		margin:5px;
		font-size:20;
		text-align:center;
	}
	#first_bus{
		border-spacing:5px;
	}
	#first_bus td{
		width:60px;
		height:45px;
		margin:5px;
		padding:5px;
		font-size:25;
		text-align:center;
	}
	#premium_bus{
		border-spacing:10px;
	}
	#premium_bus td{
		width:60px;
		height:50px;
		margin:5px;
		padding:5px;
		font-size:25;
		text-align:center;
	}

	.seat{
		border:1px solid black;
		cursor:pointer;
}
	.Noseat{
		border:1px solid gray;
		color:gray;
		background:#EEE;
	}

	.checked_td{
		font-weight:bold;
		background-color: #f8914f;
	}

	.button{
		margin:0;
		padding:0;
		font-size:30;
		width:80%;
		height:60px;
	}
</style>
<?php
	// 세션 연결
	session_start();
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='index.php'; </script>";
	}

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");
	
	// 버스, 버스 등급, 운임료 를 전달받음
	$bus_ch		= $_POST['busCode'];
	$bus_grd	= $_POST['busGrade'];
	$bus_pay	= $_POST['busPayment'];
	$gen_pay	= $_POST['generalPay'];
	$bus_rd		= $_POST['busRound'];

	// 기본 요금을 다시 계산해서
	// 전달받은 값이 올바른지 확인한다. ( 버스 ID, 등급, 가격이 DB에서 올바르게 조회되는지 확인해야한다.) 

	$sql_valid	= "SELECT bus_id FROM bus WHERE bus_id=".$bus_ch." AND stat=".$bus_grd." AND race_id IN(SELECT race_id FROM race WHERE price=".$gen_pay.");";
	$rs_valid	= $db->execute($sql_valid);
	
	// 확인해보니까 그런 버스가 없을 때는 에러 처리한다.
	if($rs_valid == false || $rs_valid->EOF){
		die('선택한 버스가 존재하지 않습니다.');
	}

	// 현재 버스에서 선택된 좌석이 어디인지 확인한다. 
	$sql = "SELECT seat_num FROM ticket WHERE bus_id = ".$bus_ch.";";

	$rs  = $db->execute($sql);
	if($rs == false){
		die("error in sltseat");
	}
	while(!$rs->EOF){
		
		$sltd[] = $rs->fields['seat_num'];
		$rs->moveNext();
	}

	unset($rs_valid);
	unset($rs);

	$_POST['title'] = "좌 석 선 택";
	include("menu.inc.php"); 

	$seat = 0;
	echo "<div id='main'>";
	echo "<form id='seat_form' action='ticketing.php' method='POST'>";
	echo "	<input type='hidden' name='busCode' value='".$bus_ch."'>";
	echo "	<input type='hidden' name='busPayment' value='".$bus_pay."'>";
	echo "	<input type='hidden' name='totalPay' value='0'>";
	echo "	<h2>좌석 선택</h2>";

	// 버스 등급에 따라 다른 버스 좌석표를 보여준다. * 일반 : 45 (5*11) , 우등 : 28 (4*9), 프리미엄 : 21 (4*7)
	switch($bus_grd){
		case 1:	// 일반
			echo "<table id='general_bus'>";
			for($i=1; $i<11; $i++){
				echo "<tr>";
				for($j=1; $j<5; $j++){
					if(in_array(++$seat, $sltd)){
						// 이미 선택된 좌석 disabled
						echo "<td class='Noseat'>";
						echo $seat;
						echo "</td>";
					}
					else{
						echo "<td class='seat'>";
						echo $seat;
						echo "</td>";
					}
					if($j == 2){
						echo "<td class='nodis'></td>";
					}
				}
				echo "</tr>";
			}
			// 맨 뒷줄
			while($seat<45){
				if(in_array(++$seat, $sltd)){
						// 이미 선택된 좌석 disabled
						echo "<td class='Noseat'>";
						echo $seat;
						echo "</td>";
					}
					else{
						echo "<td class='seat'>";
						echo $seat;
						echo "</td>";
					}
			}
			break;
		case 2:	// 우등
			echo "<table id='first_bus'>";
			for($i=1; $i<9; $i++){
				echo "<tr>";
				for($j=1; $j<4; $j++){
					if(in_array(++$seat, $sltd)){
						// 이미 선택된 좌석 disabled
						echo "<td class='Noseat'>";
						echo $seat;
						echo "</td>";
					}
					else{
						echo "<td class='seat'>";
						echo $seat;
						echo "</td>";
					}
					if($j == 2){
						echo "<td class='nodis'></td>";
					}
				}
				echo "</tr>";
			}
			// 맨 뒷줄
			while($seat<28){
				if(in_array(++$seat, $sltd)){
						// 이미 선택된 좌석 disabled
						echo "<td class='Noseat'>";
						echo $seat;
						echo "</td>";
					}
					else{
						echo "<td class='seat'>";
						echo $seat;
						echo "</td>";
					}
			}
			break;
		case 3:	// 프리미엄
			echo "<table id='premium_bus'>";
			for($i=1; $i<8; $i++){
				echo "<tr>";
				for($j=1; $j<4; $j++){
					if(in_array(++$seat, $sltd)){
						// 이미 선택된 좌석 disabled
						echo "<td class='Noseat'>";
						echo $seat;
						echo "</td>";
					}
					else{
						echo "<td class='seat'>";
						echo $seat;
						echo "</td>";
					}
					if($j == 2){
						echo "<td class='nodis'></td>";
					}
				}
				echo "</tr>";
			}
			break;
		default:// 예외
	}
?>
	</table>
	<div id='price_'><h3>가격 : 0원</h3></div>
	<input type="submit" class='button' value="선택">
	<input type="hidden" name="busRound" value=<?=$bus_rd?>>
	
	</form>
	</div>
</body>
</html>


<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
<script>
	
	var selected_seat = 0;
	$('.seat').click(function(){
		var i = $(this).html();
		$(this).toggleClass("checked_td");
		if($(this).children('input').length < 1){
			$(this).append("<input type='hidden' name='seatNum[]' value='"+i+"'>");
			price(++selected_seat);
		}
		else{
			$(this).children().remove();
			price(--selected_seat);
		}
	});

	function price(seat){
		var price = seat*<?php echo($bus_pay); ?>;
		var box = $('#price_');
		box.html("<h3>가격 : "+price+"원</h3>");
		$('input[name=totalPay]').val(price);
	}


</script>