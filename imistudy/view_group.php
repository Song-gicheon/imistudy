<?php

 
 $sql = "select team_name from team where user_id='$id' group by team_name;";

 $result = $db->execute($sql);
 $k = 0;
 while(!$result->EOF){
	 echo "<h3>".$result->fields[0]; // ÆÀ¸í
	 echo " &nbsp; <button>Select Group</button>";
	 echo " &nbsp; <button>Update Group</button>";
	 echo " &nbsp; <button>Delete Group</button></h3>";
	 $result->moveNext();
 }
 echo "<button>Make Group</button>  ";
?>