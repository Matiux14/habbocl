<?php 
if(!in_array($_SERVER['REMOTE_ADDR'],
  array('109.70.3.48', '109.70.3.146', '109.70.3.210'))) {
  header("HTTP/1.0 403 Forbidden");
  die("Error: Unknown IP");
}
$service_id	= $_GET['service_id'];
$shortcode	= $_GET['shortcode'];
$keyword	= $_GET['keyword'];
$message	= $_GET['message'];
$sender	= $_GET['sender'];
$operator	= $_GET['operator'];
$country	= $_GET['country'];
$price	= $_GET['price'];
$currency	= $_GET['currency'];
$custom	= $_GET['custom'];
$nosec = true;
ob_start();
	require_once 'global.php';
	$Functions->Logged('allow');
	global $Functions;
    $query = $db->query("UPDATE users SET seasonal_currency = seasonal_currency + '50' WHERE username = '{$_SESSION['username']}' LIMIT 1");
ob_end_flush(); 
?>