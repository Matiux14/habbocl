<?php
	require_once 'class.mysql.php';
	require_once 'class.tpl.php';
	require_once 'class.functions.php';

	$MysqlClass  = new MysqlClass();
	$TplClass    = new TplClass();
	$Functions   = new Functions();

	$db = $MysqlClass->database();
	$Functions->CheckMaintenance();
	
?>