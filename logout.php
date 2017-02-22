<?php
	ob_start();
	require_once 'global.php';
	session_destroy();
	header("LOCATION: ". PATH ."/index.php?logout=true");
	ob_end_flush(); 
?>