<!-- 마이 페이지 -->
<?php
	// 세션 연결
	session_start();
	// 세션이 연결되지 않았다면
	if(!isset($_SESSION['id'])){
		echo "<script> location.href='index.php'; </script>";
	}

	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>마이페이지</title>
	<style>
	#info, .ticket{
		margin:40px;
		padding:20px;
		font-size:12;
		border:1px solid gray;
	}

	#info{
		width:400px;
		border-collapse:collapse;
	}
	#info td{
		padding:10px;
		border-bottom:1px dashed gray;
		border-right:1px dashed gray;
		
	}
	</style>
</head>
<body>

<?php 
	$_POST['title'] = "예 매 내 역";
	include("menu.inc.php"); 

	
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/calender.inc.php");
?>
 </form>
 <table id='info'>
<?php
	// user테이블에서 검색한 내용. 본인의 개인 정보.
	$sql_info	= "SELECT name, money, age, gender FROM user WHERE id='".$_SESSION['id']."';";
	$rs = $db->execute($sql_info);


	if($rs == false || $rs->EOF){
		die('개인정보 조회 실패');
	}
	// 0 = 남, 1 = 여
	if(empty($rs->fields['gender'])){
		$gender = '남';
	}
	else{
		$gender = '여';
	}

	echo "<tr>";
	echo "	<td width='100px;'>이름</td>";
	echo "	<td>".$rs->fields['name']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "	<td>나이</td>";
	echo "	<td>".$rs->fields['age']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "	<td>성별</td>";
	echo "	<td>".$gender."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "	<td>사용 금액</td>";
	echo "	<td>".$rs->fields['money']." 원 <button onClick='ticketInfo(null);'>사용 내역</button> <button onClick='cancelInfo();'>취소 내역</button></td>";
	echo "</tr>";	
	echo "</table>";
	
	unset($rs);

?>
	<div id='indx'>
	</div>
<script>
	// ajax 통신으로 버스 데이터를 받아옴.
	function Cancel(ticket, time){
		var $form = $('<form></form>');
		$form.attr('action', 'cancel.php');
		$form.attr('method', 'POST');
		$form.appendTo('body');

		var num = $('<input type="hidden" name="cancelCode" value='+ticket+'>');
		var time = $('<input type="hidden" name="cancelTime" value='+time+'>');
		$form.append(num).append(time);
		$form.submit();
	}

	function ticketInfo(set){
		$.ajax({
			type	:'POST',
			url		:'ticket_info.php',
			data	:{'id' : '<?=$_SESSION['id']?>', 'date' : set},
			async	:false,
			success	:function(re_data){
				$('#indx').html(re_data);
			}
		});
	}

	function cancelInfo(){
		$.ajax({
			type	:'POST',
			url		:'cancel_info.php',
			data	:{'id' : '<?=$_SESSION['id']?>'},
			async	:false,
			success	:function(re_data){
				$('#indx').html(re_data);
			}
		});
	}


	ticketInfo('<?=$year_month."-".$this_date?>');
</script>
</body>
</html>