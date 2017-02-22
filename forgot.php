<?php
	ob_start();

	require_once 'global.php';
	require_once 'functions.php';

	$Functions->Logged("false");

	$TplClass->SetParam('username', '');
	$TplClass->SetParam('password', '');
	
	if( $_SESSION['ERROR_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error">'.$_SESSION['ERROR_RETURN'].'</div></div>');
		unset($_SESSION['ERROR_RETURN']);
	}
	
	if( $_SESSION['GOOD_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error" style="background: #88B600;border: 1px solid #88B600;">'.$_SESSION['GOOD_RETURN'].'</div></div>');
		unset($_SESSION['GOOD_RETURN']);
	}
	
	$TplClass->SetParam('FBID', FBID);
	$getid = $Functions->FilterText($_GET['c']);
	$correo = $_SESSION['correo'];
	if(empty($getid)){
		$TplClass->AddTemplate("Index", "index");
	}elseif($getid == $_SESSION['tmptxt_seg']){
		$TplClass->AddTemplate("Index", "forgot");
	}else{
		$TplClass->AddTemplate("Index", "index");
	}
	
	$TplClass->DisplayClosed();
	ob_end_flush(); 
?>