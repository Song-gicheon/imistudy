<?php
 // 그룹원 삭제 및 그룹원 추가.

 include('../../adodb5/adodb.inc.php');

 $db = newADOConnection('mysqli');
 $db->debug = true;
 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
 
 $id = 'test'; // 세션 이용.
 $del_member = isset($_REQUEST['del'])?$_REQUEST['del']:NULL;
 $group = $_GET['team'];
 echo $del_member;
 if($del_member != NULL){

	$sql = "Delete from team where team_id=$del_member;";
	$ok = $db->execute($sql);
 
	Header("Location:select_group.php?team=$group");
 }
 else{
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
		<input type='hidden' name='team_name' value='<?php echo $group?>'> 
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
<?php

 }
	
?>