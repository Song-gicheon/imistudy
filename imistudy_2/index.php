<!-- 홈 -->
<?php 
	// 세션 연결
	session_start();
	// 세션이 아직 연결되어 있다면
	if(isset($_SESSION['id'])){
		echo "<script> location.href='routeSrch.php'; </script>";
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>LOG-IN</title>
</head>
<body>
<?php
	$_POST['title'] = "버 스 시 간 표";
	include("menu.inc.php"); 
?>
<style>
	#login{
		margin-left:35%;
		margin-right:35%;
		width:30%;
	}
	
	#login form{
		width:100%;
	}

	#login table{
		width:100%;
	}
	
	#login table td{
		padding:2px;
	}


	#login .tin{
		width:70%;
		height:60px;
	}

	#login .sin{
		width:30%;
		height:120px;
	}

	input{
		font-size:20px;
		width:100%;
		height:100%;
		margin:5px;
	}

	

</style>
<!-- 로그인 폼 -->
<div id='login'>
<form action="login.php" method="post">

	<table>
		<tr>
		<td class='tin'>
			<input type="text" name="login_id" placeholder="ID" required/>
		</td>
		<td rowspan=2 class='sin'>
			<input type="submit" value="LOG-IN"/>
		</td>
		<tr>
		<td class='tin'>
			<input type="password" name="login_pw" placeholder="**********" required/>
		</td>
		</tr>
		
	<p class="sign">회원이 아니라면 <a href="signUp.php">회원가입</a></p>
	
</form>
</div>
</body>
</html>