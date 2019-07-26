<!-- 노선 조회 -->
<?php
	// 세션 연결
	session_start();
	// 세션이 아직 연결되어 있다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='index.php'; </script>";
	}

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");
	// 모든 노선 정보를 가져온다.
	$sql = "SELECT * FROM race;";
	$rs = $db->execute($sql);
	if($rs == false){
		die('노선 조회 실패');
	}
	while(!$rs->EOF){
		$routeID[] = $rs->fields['race_id'];
		$routeSP[] = $rs->fields['start'];
		$routeEP[] = $rs->fields['end'];
		$routeTM[] = $rs->fields['race_time'];
		$routePR[] = $rs->fields['price'];
		$rs->moveNext();
	}
	
	$arr_start = array_unique($routeSP);

	// 1. 출발지 선택
	// 굳이 이걸 사용자 함수로 만들어서 쓸 필요가 있나? -> 없음 바꾸자

	function selectStart($routeSP){
		foreach($routeSP as $value){
			
			$option .= "<option value='".$value."'>".$value."</option>\n";
		}
		return $option;
	}
	
	// 만약 선택 시간이 현재 시간보다 빠른 경우를 검증해야함.
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>노선 조회</title>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	
	<script>
	var roI = <?php echo(json_encode($routeID)); ?>;
	var roS = <?php echo(json_encode($routeSP)); ?>;
	var roE = <?php echo(json_encode($routeEP)); ?>;
	var roT = <?php echo(json_encode($routeTM)); ?>;
	var roP = <?php echo(json_encode($routePR)); ?>;

	function Change1(){
		var start = $('#sPoint').val();
		$('#ePoint').attr('disabled', false);
		$('#ePoint').html('');
		for(i=0; i<roS.length; i++){
			if(start == roS[i]){
				$('#ePoint').append("<option>"+roE[i]+"</option>");
			} 
		}
	}
	function Change2(){
		var ends = $('#ePoint').val();
		for(i=0; i<roE.length; i++){
			if(ends == roE[i] && roS[i] == $('#sPoint').val()){
				$('#code').val(roI[i]);
				$('#time').val(roT[i]);
				$('#price').val(roP[i]);
			} 
		}
	}
	$(function(){
		$("#date").datepicker({
			dateFormat: "yy-mm-dd",
			minDate: 0
		});
	});
	</script>

	<style>
	#main{
		float:right;
		position:relative;
		left:-50%;
	}
	
	#form{
		float:left;
		position:relative;
		left:50%;
		width:600px;
		height:300px;
		padding:30px;
	}
	
	#table{
		width:100%;
	}
	
	#table tr td{
		height:100px;
	}
	#table tr th{
		text-align:left;
		padding:10px;
	}

	#sPoint, #ePoint{
		width:150px;
		height:100%;
		font-size:40px;
	}

	#date{
		width:300px;
		height:100%;
		font-size:40px;
	}

	.btn, .btn input, select{
		width:100%;
		height:50px;
		font-size:20px;
	}		
	</style>
</head>
<body>
	<!-- 메뉴 폼 -->
<?php 
	$_POST['title'] = "노 선 조 회";
	include("menu.inc.php"); 
?>

	<!-- 노선 조회 폼 -->
	<div id='main'>
	<form id='form' action="bustime.php" method="POST">
		<input type="hidden" id="code" name="routeCode">
		<input type="hidden" id="time" name="routeTime">		
		<input type="hidden" id="price" name="routePrice">	
		<table id='table'>
		
		<tr>
			<th>출발지</th>
			<th>도착지</th>
			<th>날짜선택</th>
		</tr>

		<tr>
		<!-- 출발지점 -->
		<td>
			<select id='sPoint' name='routeStart' onClick="Change1()">	
				<?php echo(selectStart($arr_start)); ?>
			</select>
		</td>

		<!-- 도착지점 -->
		<td>
			<select id='ePoint' name='routeEnd' onClick="Change2()" disabled>
			</select>
		</td>

		<!-- 선택 날짜 -->
		<td >
			<input type="text" id="date" name="choiceDate" readonly>		
		</td>
		</tr>

		<tr class= 'btn'>
		<td>
			<select name='round'>
				<option value=1>편도</option>
				<option value=2>왕복</option>
			</select>
		</td>
		<td id='btn' colspan='2'>
			<input type="submit" value="조회하기">
		</td>
		</tr>
	</form>
	</div>
</body>
</html>