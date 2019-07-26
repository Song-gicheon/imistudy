<!-- 회원가입 양식 -->
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
 
  <title>회원 가입</title>
 </head>
 <style>
	input{
		width:20%;
	}

	input[type=text], input[type=password]{
		width:97%;
	}
 </style>
<body>
	<form action="signCheck.php" method="post" align="left">
	<table width="400px" style="padding:5px 0 5px 0;">
		<tr height="2" bgcolor="#FFC8C3" >
			<td colspan="2" >
			</td>
		</tr>
		<tr >
			<th width="120px">이름</th>
			<td width="270px">
				<input type="text" name="mbname">
			</td>
		</tr>
		<tr>
			<th>아이디</th>
			<td>
				<input type="text" name="id">
			</td>
		</tr>
		<tr>
			<th>비밀번호</th>
			<td>
				<input type="password" class="pwd" name="pw">
			</td>
		</tr>
		<tr>
			<th>비밀번호 확인</th>
			<td>
				<input type="password" class="pwd">
			</td>
		</tr>
		<tr>
			<th> 나이</th>
			<td>
				<input type="text" name="age">
			</td>
		</tr>
		<tr >
			<th> 성별 </th>
			<td>
				<input type='radio' name='gender' value=0> 남자
				<input type='radio' name='gender' value=1> 여자
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="padding-top:5px; border-top:2px solid #ffc8c3;">
				<input type="submit" value="회원가입">
				<input type="reset" value="취소">
			</td>
		</tr>
	</table>
	</form>
</body>
</html>