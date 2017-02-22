<?php
	ob_start();

	require_once 'global.php';

	$Functions->Logged("false");

	$TplClass->SetParam('username', '');
	$TplClass->SetParam('password', '');
	$TplClass->SetParam('FBID', FBID);
	$TplClass->SetParam('CAPTCHA', $Functions->GenerateCaptcha());
	
	if( $_SESSION['REG_ERROR'] ){
		$TplClass->SetParam('error', '<div class="alert alert-danger alrt-dng" role="alert">&nbsp;&nbsp;<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.$_SESSION['REG_ERROR'].'</div> <br>');
		unset($_SESSION['REG_ERROR'], $_SESSION['REG_USERNAME'], $_SESSION['REG_MAIL'], $_SESSION['REG_PASSWORD'], $_SESSION['REG_PASSWORD2']);
	}

	if( $_SESSION['LOGIN_ERROR'] ){
		$TplClass->SetParam('error', '<div class="alert alert-danger alrt-dng" role="alert">&nbsp;&nbsp;<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.$_SESSION['LOGIN_ERROR'].'</div> <br>');
		$TplClass->SetParam('username', $_SESSION['LOGIN_USERNAME']);
		$TplClass->SetParam('password', $_SESSION['LOGIN_PASSWORD']);
		unset($_SESSION['LOGIN_ERROR'], $_SESSION['LOGIN_USERNAME'], $_SESSION['LOGIN_PASSWORD']);
	}
	
	if( $_SESSION['GOOD_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error" style="background: #88B600;border: 1px solid #88B600;">'.$_SESSION['GOOD_RETURN'].'</div></div>');
		unset($_SESSION['GOOD_RETURN']);
	}

	$TplClass->AddTemplate("Header", "header_i");
	$TplClass->AddTemplate("Index", "index");
    $TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>