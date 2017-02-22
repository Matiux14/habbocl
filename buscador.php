<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', 'Resultados');
	$TplClass->SetParam('active1', active);
	$Functions->Logged("true");
	$TplClass->SetParam('HKLINK', '');

	$users = $db->query("SELECT rank FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	if($user['rank'] >= MINRANK){
		$TplClass->SetParam('HKLINK', '<a href='.HK.'>ACP</a>');
	}
			if(isset($_POST['palabra'])){ 
			$buscar = $Functions->FilterText($_POST['palabra']);
			if(empty($buscar)){
				$_SESSION['ERROR_RETURN'] = "Debes insertar un nombre de usuario";
					header("LOCATION: ". PATH ."/me?buscar");
			}else{
				$con=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
				$sql = "SELECT * FROM users WHERE username like '%$buscar%' ORDER BY id DESC";
				mysql_select_db(DB_DATABASE, $con);
				$result = mysql_query($sql, $con);
				$total = mysql_num_rows($result);
				if ($row = mysql_fetch_array($result)){
						header("LOCATION: ". PATH ."/home/".$row['id']."");
				}else{ 
					$_SESSION['ERROR_RETURN'] = "No se encontraron resultados para: <b>$buscar</b>";
						header("LOCATION: ". PATH ."/me?buscar");
				}
			}
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
	$TplClass->AddTemplate("Data", "buscador");
//COLUMNA FOOTER	
	$TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>
