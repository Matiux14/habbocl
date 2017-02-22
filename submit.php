<?php
	ob_start();
	require_once 'global.php';
	$Functions->Login();
	ob_end_flush(); 
?>