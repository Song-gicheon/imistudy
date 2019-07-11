<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<title> Make Group </title>
	
</head>
<body>
	<style>
	 .schedule_box{
		float:right;
		margin:10px;
		width:620px;
	}
	</style>
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
	<div class='schedule_box'>
		<h2>New Group</h2>
		<form action='make_.php' method='POST'>
			<div id='team_name'>
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
	</div>
</body>
</html>