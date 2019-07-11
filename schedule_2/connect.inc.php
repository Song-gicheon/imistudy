<?php
	// adoDB를 이용해서 데이터베이스에 연결한다.
	include($_SERVER['DOCUMENT_ROOT']."/adodb5/adodb.inc.php");
	$db = newADOConnection('mysqli');
	$db->debug = false;
	$db->connect("localhost", "root", "Kdkdldpadkdl123$%^", "study");
?>