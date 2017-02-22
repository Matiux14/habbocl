<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', $_SESSION['username']);
	$TplClass->SetParam('active1', active);
	$Functions->Logged("true");
	$TplClass->SetParam('HKLINK', '');

	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	if($user['rank'] >= MINRANK){
		$TplClass->SetParam('HKLINK', '<a href='.HK.'>ACP</a>');
	}if(empty($getid)){
		$perfil = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
		$userhome = $perfil->fetch_array();
		$getid = $Functions->FilterText($userhome['id']);
	}else{
		$perfil = $db->query("SELECT * FROM users WHERE id = '{$getid}' LIMIT 1");
		$userhome = $perfil->fetch_array();
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
//COLUMNA CENTRO
	$TplClass->AddTemplate("Data", "home");
//COLUMNA FOOTER	
	$TplClass->AddTemplate("Data", "footer");
	
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