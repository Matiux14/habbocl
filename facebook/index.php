<?php
/* #################################################################### \
░░░▒█ ▒█▀▀▀ ▀█▀ ▒█░▒█ ▒█▀▀▄ ▒█▀▀▀ ▒█▄░▒█ 　 ▒█▀▀█ ▒█▀▄▀█ ▒█▀▀▀█ 
░▄░▒█ ▒█▀▀▀ ▒█░ ▒█▀▀█ ▒█░▒█ ▒█▀▀▀ ▒█▒█▒█ 　 ▒█░░░ ▒█▒█▒█ ░▀▀▀▄▄ 
▒█▄▄█ ▒█▄▄▄ ▄█▄ ▒█░▒█ ▒█▄▄▀ ▒█▄▄▄ ▒█░░▀█ 　 ▒█▄▄█ ▒█░░▒█ ▒█▄▄▄█ 
────────────────CMS de Uso Privado 2015  by Jeihden─────────────────────
\ ################################################################### */

	ob_start();

	require_once '../global.php';

	$Functions->Logged("false");

	require_once 'facebook.php';
	$config = array();
	$config['appId'] = FBID;
	$config['secret'] = FBSECRET;

	$Facebook = new Facebook(Array(
		'appId'  => $config['appId'],
	  'secret' => $config['secret'],
	));
	$users = $Facebook->getUser();
	if($users){
		try {
			$my = $Facebook->api('/me');
		} catch(FacebookApiException $e) {
			$my = null;
			die("ERROR FB: ".$e);
		}
		}
	else{
		header("Location: ".PATH."/");
		exit();
	}

	if(is_null($my)){
		header("Location: ".PATH."/");
	}else{
		$facebook_id = $my['id'];
		
		$mail = $my['email'] . "@facebook.com.habbo";
		
		$check = $db->query("SELECT * FROM users WHERE facebook_id = '".$facebook_id."'");	

		if($check->num_rows > 0){
			$data = $check->fetch_array();
			$_SESSION['username'] = $data['username'];
			$_SESSION['password'] = $data['password'];
			$_SESSION['facebook_change'] = $data['facebook_change'];
			header("LOCATION: ". PATH ."/me");	
		}else{
			$name = $Functions->FilterText(rand(0, 99) . strtolower($facebook_id) . rand(0, 99) . rand(0, 9999));
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			$cad = "";
			for($i=0;$i<12;$i++) {
				$cad .= substr($str,rand(0,62),1);
			}
			$password = $Functions->Hash($name, $cad);
			$Functions->AddUser($name, $mail, $password, $facebook_id, "1", LOOK);
			$_SESSION['facebook_name'] = "1";
			$_SESSION['facebook_mail'] = $mail;
			$_SESSION['username'] = $name;
			$_SESSION['password'] = $password;
			$_SESSION['facebook_change'] = '0';
			header("LOCATION: ". PATH ."/me");
		}	
	}

	ob_end_flush();
?>