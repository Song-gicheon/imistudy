<?php
	// adoDB�� �̿��ؼ� �����ͺ��̽��� �����Ѵ�.
	include($_SERVER['DOCUMENT_ROOT']."/adodb5/adodb.inc.php");
	$db = newADOConnection('mysqli');
	$db->debug = false;
	$db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
?>