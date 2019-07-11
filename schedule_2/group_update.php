<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<title> Add Group Member </title>
	
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
<?php
	$group_id = $_POST['g_id'];
	$group_name = $_POST['team'];
?>
	<div class='schedule_box'>
		<h2>Add '<?php echo $group_name; ?>' Member</h2>
		<form action='group_member_update.php' method='get'>
			<div id='team_name'>
				<input type='hidden' name='g_id' value='<?php echo $group_id;?>'>
			</div>
			<div id='member_Name'>
				<h3> Member <input type='button' onclick='add_memberBox();' value='Add'></h3>
				<table><tbody id='member_box'>
				<tr>
					<td><input type='text' name='member_name[]'></td>
				</tr>
				</tbody></table>
			</div>
			<input type='submit' value='Add Member'>
		</form>
	</div>
</body>
</html>