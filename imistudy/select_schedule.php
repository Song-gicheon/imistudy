
<?php

 require('cal.inc.php');
 // 선택된 날짜의 정보를 별도로 전송받을 필요가 있음. 

 $select_y = isset($_GET['year'])?$_GET['year']:$y;
 $select_m = isset($_GET['month'])?$_GET['month']:$m;
 $select_d = isset($_GET['day'])?$_GET['day']:$d;

 if(strlen($select_m) == 1) $select_m="0".$select_m;
 if(strlen($select_d) == 1) $select_d="0".$select_d;

 $today = "$select_y-$select_m-$select_d";

 echo $today;
 // 오늘이 포함된 모든 계획은 보여줄 수 있도록 한다.
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
			// 각 일정을 클릭하면 변경할 수 있도록 한다.
			// 이 때 출력된 정보도 같이 전송 

			echo "<div>".$ok->fields[$i]."</div>";
			// 일정 : xxx
			// 기간 : x:x:x ~ x:x:x
			// 내용 : xxxxx...
			// 그룹 여부.
		}
		$ok->moveNext();
		echo "<br>";
	}
 }
 

?>