<?php
 $sql = "select team_name from team where user_id='$id' group by team_name;";

 $result = $db->execute($sql);
 $k = 0;
 while(!$result->EOF){
	 echo "<h3>".$result->fields[0]; // ÆÀ¸í
	 echo " &nbsp; <button onclick='javascript:location.href=\"select_group.php?team=".$result->fields[0]."\"'>Select Group</button>";
	 echo " &nbsp; <button onclick='javascript:location.href=\"update_group.php?team=".$result->fields[0]."\"'>Update Group</button>";
	 echo " &nbsp; <button onclick='javascript:location.href=\"delete_group.php?team=".$result->fields[0]."\"'>Delete Group</button></h3>";
	 $result->moveNext();
 }
 echo "<button onclick='javascript:location.href=\"make_group.php\"'>Make Group</button>  ";
?>
