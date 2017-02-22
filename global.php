<?php
	error_reporting(0);

	session_start();
    function SacarIP(){
		if($_SERVER){
			if($_SERVER["HTTP_X_FORWARDED_FOR"]){
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}elseif ($_SERVER["HTTP_CLIENT_IP"]){
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			}else{
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		}else{
			if(getenv("HTTP_X_FORWARDED_FOR")){
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			}elseif(getenv("HTTP_CLIENT_IP")){
				$realip = getenv("HTTP_CLIENT_IP");
			}else{
				$realip = getenv("REMOTE_ADDR");
			}
		}
		return $realip;
	}
	$realip = SacarIP();
	define ( 'USER_IP', $realip );
	define ( 'SEPARATOR', DIRECTORY_SEPARATOR );
	define ( 'DIR', __DIR__ );
	define ( 'WEB', true );
	define ( 'YeezyCMS', true );
	
	define( 'CHARSET','UTF-8' );
	header( 'Content-type: text/html; charset='.CHARSET );

	include( 'system/class.core.php' );
	
	$TplClass->SetParam( 'error', '' );
	
	$result = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1");
	if($result->num_rows > 0){while($data = $result->fetch_array()){ 
	$TplClass->SetParam( 'SHORTNAME', $data['hotelname'] );
	$TplClass->SetParam( 'FACE', $data['facebook'] );
	$TplClass->SetParam( 'IDPAYGOL', $data['id_paygol'] );
	$TplClass->SetParam( 'LOGO', $data['logo'] );}}else{echo '<i>No se encuentra la tabla cms_settings</i>';}
	
	$TplClass->SetParam( 'PATH', PATH );
	$TplClass->SetParam( 'PATHCLIENT', PATHCLIENT );
	$TplClass->SetParam( 'CDN', CDN );
	$TplClass->SetParam( 'HK', HK );
	$TplClass->SetParam( 'CLUBNAME', CLUBNAME );
	$TplClass->SetParam( 'ID', 'Yeezy (Private)');
	$TplClass->SetParam( 'FOOTER', FOOTER );
	$TplClass->SetParam( 'AVATARIMAGE', AVATARIMAGE );
	$TplClass->SetParam( 'IDNT', '<img style="margin-bottom:-3px;" src="/gallery/images/icons/id.png">');
	$TplClass->SetParam( 'MYNAME', $_SESSION['username'] );
	$TplClass->SetParam( 'MYLOOK', $_SESSION['look'] );
	$TplClass->SetParam( 'USERID', $_SESSION['id'] );
	$TplClass->SetParam( 'USERSON', $Functions->GetOns() );
    $TplClass->SetParam( 'USERREG', $Functions->GetCount('users') );
	$TplClass->SetParam( 'MYID', $Functions->GetID() );

	$resulta = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	while($lastc = $resulta->fetch_array()){ $TplClass->SetParam( 'LASTC', $Functions->GetLast($lastc['last_online']) );}
?>