
<?php

 require('cal.inc.php');
 // ���õ� ��¥�� ������ ������ ���۹��� �ʿ䰡 ����. 

 $select_y = isset($_GET['year'])?$_GET['year']:$y;
 $select_m = isset($_GET['month'])?$_GET['month']:$m;
 $select_d = isset($_GET['day'])?$_GET['day']:$d;

 if(strlen($select_m) == 1) $select_m="0".$select_m;
 if(strlen($select_d) == 1) $select_d="0".$select_d;

 $today = "$select_y-$select_m-$select_d";

 echo $today;
 // ������ ���Ե� ��� ��ȹ�� ������ �� �ֵ��� �Ѵ�.
 $sql= "select id, schedule, s_date, e_date, content, team 
		from schedules
		where '$today'>=DATE(s_date) and '$today'<=DATE(e_date);";

 $ok = $db->execute($sql);
 
 if($ok == false){
	 die("failed");
 }
 else{
	while(!$ok->EOF){
		for($i=0, $max=$ok->fieldCount(); $i<$max; $i++){
			// �� ������ Ŭ���ϸ� ������ �� �ֵ��� �Ѵ�.
			// �� �� ��µ� ������ ���� ���� 

			echo "<div>".$ok->fields[$i]."</div>";
			// ���� : xxx
			// �Ⱓ : x:x:x ~ x:x:x
			// ���� : xxxxx...
			// �׷� ����.
		}
		$ok->moveNext();
		echo "<br>";
	}
 }
 

?>