<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<title> Make Group </title>
	
</head>
<body>
<?php 
 // 그룹 생성
 // 1. 그룹명 입력
 // 2. 최소 1명 이상의 그룹원 추가
 // * 
 include('cal.inc.php');
 $group = $_GET['team'];

?>
	<script>
		function add_memberBox(){
			var row = document.getElementById('member_box');
			var tr = document.createElement('tr');
			tr.innerHTML = "<td><input type='text' name='member_name[]'></td>";
			tr.innerHTML += "<td><input type='button' onclick='rm_memberBox(this);' value='remove'></td>";
			row.appendChild(tr);
		}
		function rm_memberBox(obj){
			var row = document.getElementById('member_box');
			row.removeChild(obj.parentNode.parentNode);
		}
	</script>
	<form action='make.php' method='get'>
	<div>
		<p>Team Name</p>
		<input type='text' name='team_name'> 
	</div>
	<div id='member_Name'>
		<p> Member <input type='button' onclick='add_memberBox();' value='Add'></p>
		<table><tbody id='member_box'>
		<tr>
		 <td><input type='text' name='member_name[]'></td>
		</tr>
		</tbody></table>
	</div>
		<input type='submit' value='Make'>
	</form>
</body>
</html>