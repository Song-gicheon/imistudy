
<!Doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>통계 페이지</title>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="jquery-ui-timepicker-addon.css">

	<script src="//code.jquery.com/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script src="jquery-ui-timepicker-addon.js"></script>
	<style>
	.datetime, .date{
		width:300px;
		font-size:25px;
		text-align:center;
		height:60px;
	}

	input[type=submit]{
		width:80px;
		height:60px;
		font-size:25px;
		font-weight:bold;
	}
	</style>


</head>
<body>
	<!-- 1. 시간단위별 예매 매출 통계 -->
	<form action="benefit.php" method="post">
		<p> 1. 시간단위별 예매 매출 통계</p>
		<input type="text" class="datetime" name="ticketCheckS" readonly>
		<input type="text" class="datetime" name="ticketCheckE" readonly>
		<input type="submit" value="확인">
	</form>

	<!-- 2. 회원별 이용내역 통계 확인 -->
	<form action="user_manage.php" method="post">
		<p> 2. 회원별 이용내역 통계 확인 </p>
		<input type="text" class="datetime" name="userTicketS" readonly>
		<input type="text" class="datetime" name="userTicketE" readonly>
		<input type="submit" value="확인">
	</form>

	<!-- 3. 회원별 취소내열 통계 확인 -->
	<form action="user_cancel.php" method="post">
		<p> 3. 회원별 취소내열 통계 확인</p>
		<input type="text" class="datetime" name="userCancelS" readonly>
		<input type="text" class="datetime" name="userCancelE" readonly>
		<input type="submit" value="확인">
	</form>

	<!-- 4. 노선 구간별 이용률 통계   -->
	<form action="race_using.php" method="post">
		<p> 4. 노선 구간별 이용률 통계 </p>
		<input type="text" class="date" name="raceUseS" readonly>
		<input type="text" class="date" name="raceUseE" readonly>
		<input type="submit" value="확인">
	</form>

	<!--
	5. 연령 및 성별에 따른 구분 
	<form action="statistic.php" method="post">
		<p> 5. 연령 및 성별에 따른 구분 </p>
		<input type="text" class="date" name="statis_S" readonly>
		<input type="text" class="date" name="statis_E" readonly>
		
		<input type="submit" value="확인">
	</form>
	-->
</body><script>
    $(".datetime").datetimepicker({
        dateFormat:'yy-mm-dd',
        monthNamesShort:[ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
        dayNamesMin:[ '일', '월', '화', '수', '목', '금', '토' ],
        changeMonth:true,
        changeYear:true,
        showMonthAfterYear:true,
 
        // timepicker 설정
        timeFormat:'HH:00:00',
        controlType:'select',
        oneLine:true,
    });

		
    $(".date").datepicker({
        dateFormat:'yy-mm-dd',
        monthNamesShort:[ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
        dayNamesMin:[ '일', '월', '화', '수', '목', '금', '토' ],
        changeMonth:true,
        changeYear:true,
        showMonthAfterYear:true,
 
    });
</script>
</html>
