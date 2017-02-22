<?php
	ob_start();
	require_once 'global.php';
	$Functions->RegisterSubmit();
	ob_end_flush(); 
?>