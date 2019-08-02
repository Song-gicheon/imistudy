<?php
// 4. 노선 구간별 이용률					race_using.php

	$startTime	= $_POST['raceUseS'];
	$endTime	= $_POST['raceUseE'];


	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	// 기간 내에 각 노선별 이용 횟수를 불러오고, 전체 노선 이용 횟수로 나눠서 이용률을 표시한다.
	$sql = "SELECT race.start, race.end, sum(A.use_cnt)/B.total*100 AS rate
			FROM using_race A JOIN race ON A.race_id = race.race_id, (
				SELECT sum(use_cnt) AS total FROM using_race WHERE term >= '".$startTime."' AND term < '".$endTime."') B
			WHERE term >= '".$startTime."' AND term < '".$endTime."' group by A.race_id;";

	$rs = $db->execute($sql);

	if($rs == false || $rs->EOF){
		die('실패');
	}
	while(!$rs->EOF){
		
		echo "노선 : ".$rs->fields['start']." → ".$rs->fields['end']."  <br>";
		echo "해당 구간 이용률  : ".$rs->fields['rate']." %<br><br>";

		$rs->moveNext();
	}
?> 