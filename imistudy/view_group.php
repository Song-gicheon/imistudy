
 <h3> Your Group </h3>
 <table style="table-layout:fixed; margin:20px;" height='30px' align='center'>
<?php
 // 현재 id의 그룹 목록.
 $sql = "select team_name from team where user_id='$id' group by team_name;";

 $result = $db->execute($sql);
 while(!$result->EOF){
	 echo "<tr width='80px'>";
	 echo "<td>";
	 echo "<a href='select_group.php?team=".$result->fields[0]."'>".$result->fields[0]."</a>"; // 팀명
	 echo "</td>";
	 echo "<td><button onclick='javascript:location.href=\"delete_group.php?del=".$result->fields[0]."\"'>Delete</button><td>";
	 echo "</tr>";
	 $result->moveNext();
 }
 echo "<tr><td><button onclick='javascript:location.href=\"make_group.php\"'>Make Group</button><td></tr>";
?>
</table>
