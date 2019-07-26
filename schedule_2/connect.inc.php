<?php	
	$DB_addr	= "localhost";
	$DB_id		= "root";
	$DB_pw		= "Kdkdldpadkdl123$%^";
	$DB_name	= "study";

	// adoDB를 이용해서 데이터베이스에 연결한다.
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/adodb5/adodb.inc.php");
	$db = newADOConnection('mysqli');
	$db->debug = false;
	$db->connect($DB_addr, $DB_id, $DB_pw, $DB_name);
?>