<?php
	ob_start();

	require_once 'global.php';
	$Functions->Logged("false");
	$remote_ip = USER_IP;
	$sql = $db->query("SELECT * FROM users WHERE ip_last = '".$remote_ip."'");

	if($sql->num_rows > 0) {
		header("Location: " . PATH . "/index.php");
		exit;
	} else {
		if(isset($_GET['user'])){	
			$_SESSION['refer'] = $Functions->FilterText($_GET['user']);
			$_SESSION['refer_type'] = "username";
		}
		header("Location: ". PATH ."/index.php");
		exit;
	}

	ob_end_flush();
?>