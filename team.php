<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', 'Equipo');
	$TplClass->SetParam('active2', active);
	$Functions->Logged("true");
	$TplClass->SetParam('HKLINK', '');

	$users = $db->query("SELECT rank FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	if($user['rank'] >= MINRANK){
		$TplClass->SetParam('HKLINK', '<a href='.HK.'>ACP</a>');
	}
	
	$TplClass->SetAll();

	if( $_SESSION['ERROR_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error">'.$_SESSION['ERROR_RETURN'].'</div></div>');
		unset($_SESSION['ERROR_RETURN']);
	}
	
	if( $_SESSION['GOOD_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error" style="background: #88B600;border: 1px solid #88B600;">'.$_SESSION['GOOD_RETURN'].'</div></div>');
		unset($_SESSION['GOOD_RETURN']);
	}
	
	$TplClass->AddTemplate("Header", "header");
//COLUMNA 1	
	$TplClass->AddTemplate("Data", "team");
//COLUMNA FOOTER	
	$TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>
