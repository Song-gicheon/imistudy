<?php	
	$DB_addr	= "localhost";
	$DB_id		= "root";
	$DB_pw		= "Kdkdldpadkdl123$%^";
	$DB_name	= "study";

	// adoDB�� �̿��ؼ� �����ͺ��̽��� �����Ѵ�.
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/adodb5/adodb.inc.php");
	$db = newADOConnection('mysqli');
	$db->debug = false;
	$db->connect($DB_addr, $DB_id, $DB_pw, $DB_name);
?>