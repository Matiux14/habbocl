<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', 'Referidos');
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
	$TplClass->Display('generic" style="display:table;');
//COLUMNA 3
	$TplClass->Display('raven3" style="width:100px;float: right;"');
	$TplClass->Display("column-3");
	$TplClass->AddTemplate("Data/Columnas", "column-3");
	$TplClass->DisplayClosed();
	$TplClass->DisplayClosed();
//COLUMNA CENTRO
	$TplClass->Display('raven" style="width: 758px;float: left;"');
	$TplClass->AddTemplate("Data/Columnas", "column-custom");
//COLUMNA 1	
	$TplClass->Display("column-1");
	$TplClass->AddTemplate("Data/Columnas", "column-1");
	$TplClass->DisplayClosed();
//COLUMNA 2
	$TplClass->Display("column-2");
	$TplClass->AddTemplate("Data/Columnas", "column-2");
	$TplClass->DisplayClosed();

//COLUMNA FOOTER	
	$TplClass->DisplayClosed();
	$TplClass->DisplayClosed();
	$TplClass->Display('generic" style="display:table;');
	$TplClass->Display('raven" style="width: 748px;float: left;');
	$TplClass->AddTemplate("Data", "footer");
	$TplClass->DisplayClosed();
	$TplClass->DisplayClosed();
	$TplClass->DisplayClosed();
	
	ob_end_flush(); 
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>