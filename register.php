<?php
	ob_start();

	require_once 'global.php';

	$Functions->Logged("false");

	$TplClass->SetParam('username', '');
	$TplClass->SetParam('password', '');
	$TplClass->SetParam('FBID', FBID);
	
	if( $_SESSION['REG_ERROR'] ){
		$TplClass->SetParam('error', '<div class="alert alert-danger alrt-dng" role="alert">&nbsp;&nbsp;<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Corregir los siguientes errores<br>'.$_SESSION['REG_ERROR'].'</div> <br>');
		unset($_SESSION['REG_ERROR'], $_SESSION['REG_USERNAME'], $_SESSION['REG_MAIL'], $_SESSION['REG_PASSWORD'], $_SESSION['REG_PASSWORD2']);
	}

	if( $_SESSION['LOGIN_ERROR'] ){
		$TplClass->SetParam('error', '<div class="alert alert-danger alrt-dng" role="alert">&nbsp;&nbsp;<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.$_SESSION['LOGIN_ERROR'].'</div> <br>');
		$TplClass->SetParam('username', $_SESSION['LOGIN_USERNAME']);
		$TplClass->SetParam('password', $_SESSION['LOGIN_PASSWORD']);
		unset($_SESSION['LOGIN_ERROR'], $_SESSION['LOGIN_USERNAME'], $_SESSION['LOGIN_PASSWORD']);
	}
	
	$TplClass->AddTemplate("Index", "register");
    $TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>