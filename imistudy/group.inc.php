

 <div>
<?php

 include('../../adodb5/adodb.inc.php');
 $db = newADOConnection('mysqli');

 $db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");

 $id = 'test'; // ¼¼¼Ç
/*
 $result = $db->execute($sql);
 $k = 0;
 while(!$result->EOF){
	 echo "<h3>".$result->fields[0]; // ÆÀ¸í
	 echo " &nbsp; <button>Update Group</button>";
	 echo " &nbsp; <button>Delete Group</button></h3>";
	 $query = "select member_name from team where user_id='$id' and team_name='".$result->fields[0]."' order by member_name;";
	 $rs = $db->execute($query);
	 while(!$rs->EOF){
		 echo "<p>&nbsp;&nbsp; - ".$rs->fi
			 elds[0]."</p>";
		 $rs->moveNext();
	 }
	 $result->moveNext();
 }
 echo "<button>Make Group</button>";
*/
?>
 </div>