
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
 $sql= "select sch_id, schedule, s_date, e_date, content, team, a_date
		from schedules
		where '$today'>=DATE(s_date) and '$today'<=DATE(e_date);";

 $ok = $db->execute($sql);
 
 if($ok == false){
	 die("failed");
 }
 else{
	while(!$ok->EOF){
	
		// �� ������ Ŭ���ϸ� ������ �� �ֵ��� �Ѵ�.
		// �� �� ��µ� ������ ���� ���� 

		// ���� : xxx
		// �Ⱓ : x:x:x ~ x:x:x
		// ���� : xxxxx...
		// �׷� ����.
		echo "<div> Schedule Name : ".$ok->fields[1]."</div>";
		echo "<div> Start : ".$ok->fields[2]."</div>";
		echo "<div> End : ".$ok->fields[3]."</div>";
		echo "<div> Content : ".$ok->fields[4]."</div>";
		echo "<div> group : ".$ok->fields[5]."</div>";
		
?> 
		<script type='text/javascript'>
	
			function upd(form){
				form.action = 'update_schedule.php';
				form.submit();
			}

			function del(f){
				f.action = 'delete_schedule.php';
				f.submit();
			}
		</script>

		<form name='form' class='form' method='post'>
			<input type='hidden' name='sch_id' value='<?php echo $ok->fields[0]; ?>'/>
			<input type='button' value='Update' onclick='upd(this.form);'/>
			<input type='button' value='Delete' onclick='del(this.form);'/>
		</form>

<?php
		$ok->moveNext();
		echo "<br>";
	}
}
 

?>