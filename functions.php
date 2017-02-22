<?php
	ob_start();
	require_once 'global.php';
	
	$TplClass->SetAll();
	if( $_SESSION['ERROR_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error">'.$_SESSION['ERROR_RETURN'].'</div></div>');
		unset($_SESSION['ERROR_RETURN']);
	}
	
	if( $_SESSION['GOOD_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error" style="background: #88B600;border: 1px solid #88B600;">'.$_SESSION['GOOD_RETURN'].'</div></div>');
		unset($_SESSION['GOOD_RETURN']);
	}
	$online = $Functions->Get('online');
	$diamonds = $Functions->Get('vip_points');
	$userid = $Functions->Get('id');
	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	
	//CAMBIAR NOMBRE
		$oldname = $Functions->Get('username');
		$changename = $Functions->FilterText($_POST['changename']);
		$confpass = $Functions->FilterText($_POST['pnpass']);
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$cad = "";
		for($i=0;$i<12;$i++) {
			$cad .= substr($str,rand(0,62),1);
		}
		$passwordchanged = $Functions->Hash($changename, $confpass);
		
		if(isset($_POST['changename'])){
			$newname = $Functions->FilterText($_POST['changename']);
			$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $newname);
			if($user['cms_changename'] == 1){
				$_SESSION['ERROR_RETURN'] = "Lo sentimos, pero ya has cambiado tu nombre 1 vez";
					header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}elseif($online == 1){
				$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
					header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}elseif($newname !== $filter || strlen($newname) < 2 || strlen($newname) > 19){
				$_SESSION['ERROR_RETURN'] = "Inserta un nombre valido (Min: 2 Caract. Max 18 Caract.)";
				header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}elseif($Functions->ComprobateExist($newname)){
				$_SESSION['ERROR_RETURN'] = "Ese nombre ya esta en uso.";
					header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}elseif(empty($_POST['changename']) || empty($_POST['pnpass'])){
				$_SESSION['ERROR_RETURN'] = "Debes rellenar ambos campos";
					header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}elseif(strlen($confpass) < 6 || strlen($confpass) > 32){
				$_SESSION['ERROR_RETURN'] = 'La contraseña es incorrecta';
					header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}elseif(strpos($_POST['changename'], 'MOD-') !== false){
				$_SESSION['ERROR_RETURN'] = "Ese nombre est&aacute; prohibido.";
					header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}else{
				$new = $db->query("UPDATE users SET cms_changename = '1', username = '{$changename}', password = '{$passwordchanged}' WHERE username = '{$Functions->Get('username')}' AND password = '{$_SESSION['password']}' LIMIT 1");
				$db->query("UPDATE rooms_data SET owner = '{$changename}' WHERE owner = '{$oldname}' LIMIT 1");
				$_SESSION['GOOD_RETURN'] = "Se ha cambiado tu nombre y tus respectivas salas con &eacute;xito.";
				$_SESSION['username'] = $changename;
				$_SESSION['password'] = $passwordchanged;
				unset($_SESSION['cms_changename']);
				header("LOCATION: ". PATH ."/account/settings?save=true&tab=1");
			}
		}
	//END CAMBIA NOMBRE
	//PLACA DE REGALO
		if(isset($_POST['badgecode'])){
			$badgec = $Functions->FilterText($_POST['badgecode']);
			$badgel = $db->query("SELECT code,price FROM cms_badges_gift WHERE id = '{$badgec}' LIMIT 1");
			if($badgel->num_rows > 0){
				$badgef = $badgel->fetch_array();
				$cdbadge = $badgef['code'];
				$cpbadge = $badgef['price'];
				$badgen = $db->query("SELECT * FROM user_badges WHERE badge_id = '{$cdbadge}' AND user_id = '{$userid}' LIMIT 1");
				if($badgen->num_rows > 0){
					$_SESSION['ERROR_RETURN'] = "Al parecer ya posees esta placa. ¡Espera la otra Semana!";
						header("LOCATION: ". PATH ."/me?badgeaction");
				}elseif($online == 1){
					$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
						header("LOCATION: ". PATH ."/me?badgeaction");
				}elseif($diamonds >= $cpbadge){
					$_SESSION['GOOD_RETURN'] = "Has reclamado tu placa con &eacute;xito.";
						header("LOCATION: ". PATH ."/me?badgeaction");
					$do1 = $db->query("UPDATE users SET vip_points = vip_points - '{$cpbadge}' WHERE username = '{$_SESSION['username']}'");
					$dbBadge= array();
					$dbBadge['user_id'] = $userid;
					$dbBadge['badge_id'] = $cdbadge;
					$query = $db->insertInto('user_badges', $dbBadge);	
				}else{
					$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error inesperado.";
						header("LOCATION: ". PATH ."/me?badgeaction");
				}
			}else{
				$_SESSION['ERROR_RETURN'] = "Esa placa no est&aacute; disponible.";
					header("LOCATION: ". PATH ."/me?badgeaction");
			}
		}
	//END PLACA DE REGALO
	//BUSCAR USUARIO
		if(isset($_POST['search'])){ 
			$buscar = $Functions->FilterText($_POST['search']);
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
					$_SESSION['ERROR_RETURN'] = " <b style='margin-left: 60px; margin-right: 10px;'>No se encontro resultados para $buscar</b>";
						header("LOCATION: ". PATH ."/buscador.php");
				}
			}
		}
	//END BUSCAR USUARIO
	//REFERIDOS
		if(isset($_POST['canjearrankrefer'])){
			$sql2 = $db->query("SELECT cms_refers, rank FROM users WHERE username = '{$_SESSION['username']}'");
			$pointss = $sql2->fetch_array();
			$pointsold = $pointss['cms_refers'];
			$rank = $pointss['rank'];
			if($rank >= 3){
				$_SESSION['ERROR_RETURN'] = "Al parecer ya eres publicista";
					header("LOCATION: ". PATH ."/Referidos?Canjear");
			}elseif($online == 1){
				$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
					header("LOCATION: ". PATH ."/Referidos?Canjear");
			}elseif($pointsold >= 60){
				$db->query("UPDATE users SET rank = '3', cms_refers = cms_refers - '60' WHERE username = '{$_SESSION['username']}'");
				$_SESSION['GOOD_RETURN'] = "¡Has canjeado tu rango exitosamente!";
					header("LOCATION: ". PATH ."/Referidos?Canjear");
			}else{
				$_SESSION['ERROR_RETURN'] = "Lo sentimos, pero no tienes los suficientes referidos para obtener el rango";
					header("LOCATION: ". PATH ."/Referidos?Canjear");
			}
		}
	//END REFERIDOS
	//VOUCHER
		if(isset($_POST['voucher'])){
			$code = $Functions->FilterText($_POST['codigov']);
			$C = $db->query("SELECT * FROM cms_vouchercontrol WHERE user = '{$_SESSION['username']}' && voucher = '$code'");
			$repeat = $C->fetch_array();
			if(empty($code)){
				$_SESSION['ERROR_RETURN'] = "Debes insertar un c&oacute;digo voucher";
					header("LOCATION: ". PATH ."/Tienda?codigo");
			}elseif($online == 1){
				$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
					header("LOCATION: ". PATH ."/Tienda?codigo");
			}elseif($repeat['voucher'] == $code){
				$_SESSION['ERROR_RETURN'] = "Ya has canjeado el c&oacute;digo una vez";
					header("LOCATION: ". PATH ."/Tienda?codigo");
			}else{
				$sqlBuscar = $db->query("SELECT * FROM items_vouchers WHERE voucher = '$code' LIMIT 1");					
				$totalRows = $sqlBuscar->num_rows;
				if(!empty($totalRows)){
					while($row = $sqlBuscar->fetch_array()){
						$total = $row['value'];
						if($row['max_uses'] <= $row['cur_uses']){
							$_SESSION['ERROR_RETURN'] = "El c&oacute;digo voucher ya ha sido canjeado";
								header("LOCATION: ". PATH ."/Tienda?codigo");
						}elseif($row['type'] == 'credits'){
							$db->query("UPDATE items_vouchers SET cur_uses = cur_uses + '1'  WHERE voucher = '$code' LIMIT 1");
							$db->query("UPDATE users SET credits = credits + '".$row['value']."'  WHERE username = '{$_SESSION['username']}'");
							$db->query("INSERT INTO cms_vouchercontrol (user, voucher) VALUES ('{$_SESSION['username']}', '$code')");
							$_SESSION['GOOD_RETURN'] = "C&oacute;digo Voucher por <strong>$total</strong> Cr&eacute;ditos canjeado con &eacute;xito";
								header("LOCATION: ". PATH ."/Tienda?codigo");
						}elseif($row['type'] == 'vippoints'){
							$db->query("UPDATE items_vouchers SET cur_uses = cur_uses + '1'  WHERE voucher = '$code' LIMIT 1");
							$db->query("UPDATE users SET vip_points = vip_points + '".$row['value']."'  WHERE username = '{$_SESSION['username']}'");
							$db->query("INSERT INTO cms_vouchercontrol (user, voucher) VALUES ('{$_SESSION['username']}', '$code')");
								$_SESSION['GOOD_RETURN'] = "C&oacute;digo Voucher por <strong>$total</strong> Diamantes canjeado con &eacute;xito";
								header("LOCATION: ". PATH ."/Tienda?codigo");
						}
					}
				}elseif($totalRows == 0){
					$_SESSION['ERROR_RETURN'] = "El c&oacute;digo voucher es inv&aacute;lido";
						header("LOCATION: ". PATH ."/Tienda?codigo");
				}		
			}
		}
	//END VOUCHER
	//PLACAS
		if(isset($_POST['buybadge'])){
			$badgec = $Functions->FilterText($_POST['buybadgecode']);
			$badgel = $db->query("SELECT code,price FROM cms_badges WHERE id = '{$badgec}' LIMIT 1");
			if($badgel->num_rows > 0){
				$badgef = $badgel->fetch_array();
				$cdbadge = $badgef['code'];
				$cpbadge = $badgef['price'];
				$badgen = $db->query("SELECT * FROM user_badges WHERE badge_id = '{$cdbadge}' AND user_id = '{$userid}' LIMIT 1");
				if($badgen->num_rows > 0){
					$_SESSION['ERROR_RETURN'] = "Al parecer ya posees esta placa.";
						header("LOCATION: ". PATH ."/Tienda=ComprarPlacas?badgeaction");
				}elseif($online == 1){
					$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
						header("LOCATION: ". PATH ."/Tienda=ComprarPlacas?badgeaction");
				}elseif($diamonds >= $cpbadge){
					$_SESSION['GOOD_RETURN'] = "Has comprado la placa con &eacute;xito.";
						header("LOCATION: ". PATH ."/Tienda=ComprarPlacas?badgeaction");
					$do1 = $db->query("UPDATE users SET vip_points = vip_points - '{$cpbadge}' WHERE username = '{$_SESSION['username']}'");
					$dbBadge= array();
					$dbBadge['user_id'] = $userid;
					$dbBadge['badge_id'] = $cdbadge;
					$query = $db->insertInto('user_badges', $dbBadge);	
				}else{
					$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error inesperado.";
						header("LOCATION: ". PATH ."/Tienda=ComprarPlacas?badgeaction");
					}
			}else{
				$_SESSION['ERROR_RETURN'] = "Esa placa no est&aacute; disponible.";
						header("LOCATION: ". PATH ."/Tienda=ComprarPlacas?badgeaction");
			}			
		}
	//END PLACAS
	//RARES
		if(isset($_POST['buyrare'])){
		$rarec = $Functions->FilterText($_POST['rarecode']);
		$rarel = $db->query("SELECT code,price,item_name FROM cms_rares WHERE id = '{$rarec}' LIMIT 1");
			if($rarel->num_rows > 0){
				$raref = $rarel->fetch_array();
				$cdrare = $raref['code'];
				$cprare = $raref['price'];
				if($online == 1){
					$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
						header("LOCATION: ". PATH ."/Tienda=ComprarRares?rareaction");
				}elseif($diamonds >= $cprare){
					$_SESSION['GOOD_RETURN'] = "Rare comprado con &eacute;xito";
						header("LOCATION: ". PATH ."/Tienda=ComprarRares?rareaction");		
					$do1 = $db->query("UPDATE users SET vip_points = vip_points - '{$cprare}' WHERE username = '{$_SESSION['username']}'");
					$dbrare= array();
					$dbrare['user_id'] = $userid;
					$dbrare['room_id'] = 0;
					$dbrare['base_item'] = $cdrare;
					$dbrare['extra_data'] = '';
					$dbrare['x'] = 0;
					$dbrare['y'] = 0;
					$dbrare['z'] = 0.000;
					$dbrare['rot'] = 0;
					$dbrare['wall_pos'] = '';
					$dbrare['rare_id'] = 0;
					$dbrare['songcode'] = '';
					$dbrare['group_id'] = 0;
					$dbrare['builders'] = 0;				
					$query = $db->insertInto('items_rooms', $dbrare);				
				}else{
					$_SESSION['ERROR_RETURN'] = "No tienes lo suficiente para comprar este rare";
					header("LOCATION: ". PATH ."/Tienda=ComprarRares?rareaction");			
				}
			}else{
				$_SESSION['ERROR_RETURN'] = "Ese rare no est&aacute; en venta";
					header("LOCATION: ". PATH ."/Tienda=ComprarRares?rareaction");		
			}
		}
	//END RARES
	//VIP
		if(isset($_POST['buyvip'])){
			if($user['rank'] >= 2){
				$_SESSION['ERROR_RETURN'] = "Al parecer ya eres VIP";
					header("LOCATION: ". PATH ."/Tienda=ComprarVIP?Comprar");
			}elseif($online == 1){
				$_SESSION['ERROR_RETURN'] = "Debes estar fuera del client para evitar errores";
					header("LOCATION: ". PATH ."/Tienda=ComprarVIP?Comprar");
			}elseif($diamonds >= 25){
				$db->query("UPDATE users SET rank = '2', vip_points = vip_points - '25' WHERE username = '{$_SESSION['username']}'");
				$_SESSION['GOOD_RETURN'] = "¡Has comprado suscripci&oacute; VIP exitosamente!";
					header("LOCATION: ". PATH ."/Tienda=ComprarVIP?Comprar");
			}else{
				$_SESSION['ERROR_RETURN'] = "Lo sentimos, pero no tienes los suficientes Diamantes para comprar VIP";
					header("LOCATION: ". PATH ."/Tienda=ComprarVIP?Comprar");
			}
		}
	//END VIP
	//BUG
		if(isset($_POST['BugReporter'])){
			$text = $Functions->FilterText($_POST['BugReporter']);
			$security = $db->query("SELECT * FROM cms_comments WHERE username = '{$_SESSION['username']}' && type = 'bug' ORDER by id DESC LIMIT 1");
			$sec = $security->fetch_array();
			if($security->num_rows > 0){
				if($sec['time'] >= time() - 300){
					$_SESSION['ERROR_RETURN'] = "&iexcl;No puedes mandar reportes seguidos! Debes esperar 5 minutos para enviar otro";
						header("LOCATION: ". PATH ."/report.php#");
				}else{
					$db->query("INSERT INTO cms_comments (username, comentario, type, time, posted_on, posted_in) VALUES ('". $_SESSION['username'] ."', '{$_POST['BugReporter']}', 'bug', '".time()."', '".date("Y-m-d ")."', '0')");
					$_SESSION['GOOD_RETURN'] = "&iexcl;Reporte enviado! Gracias por tu apoyo, esto se hace para mejorar el hotel y disfrutes mejor de &eacute;l";
						header("LOCATION: ". PATH ."/report.php#");
				}
			}else{
					$db->query("INSERT INTO cms_comments (username, comentario, type, time, posted_on, posted_in) VALUES ('". $_SESSION['username'] ."', '{$_POST['BugReporter']}', 'bug', '".time()."', '".date("Y-m-d ")."', '0')");
					$_SESSION['GOOD_RETURN'] = "&iexcl;Reporte enviado! Gracias por tu apoyo, esto se hace para mejorar el hotel y disfrutes mejor de &eacute;l";
						header("LOCATION: ". PATH ."/report.php#");
			}
		}
	//END BUG
	//FORGOT 
		if(isset($_POST['emailAddress'])){
			$email = $Functions->FilterText($_POST['emailAddress']);
			$buscar = $db->query("SELECT mail FROM users WHERE mail = '{$email}'");
			$_SESSION['correo'] = $email;
			if($buscar->num_rows > 0){
				$_SESSION['tmptxt_seg'] = $Functions->GenerateCode();
				$code = $_SESSION['tmptxt_seg'];
				mail("$email",'Recuperación de contraseña - YeezyCMS by Forbi', "Estimado usuario, hemos detectado la solicitud del cambio de tu contraseña correctamente. Si no es as&iacute; ignora este mensaje, de lo contrario haz clic <a href='". PATH ."/account/password/resetIdentity/9346b03cbb86c009501ce113cb38dce39ebba9c34a6416d8edef5ac544db7dddb5158bf4e86bc09c089a3ed7e87049f144888ef2b45e1a02986bdc8858d82ad0dd460/?c=$code'>Aqu&iacute;</a> o copia el siguiente enlace:<br> ". PATH ."/account/password/resetIdentity/9346b03cbb86c009501ce113cb38dce39ebba9c34a6416d8edef5ac544db7dddb5158bf4e86bc09c089a3ed7e87049f144888ef2b45e1a02986bdc8858d82ad0dd460/?c=$code <br> ¿No ha funcionado? ¡Manda nuevamente el formulario!");
					$_SESSION['GOOD_RETURN'] = "Te hemos enviado un Email con un enlace para cambiar tu contraseña. Recuerda comprobar tambi&eacute;n la carpeta de 'Spam'";
					header("LOCATION: ". PATH ."#");
			}else{
				$_SESSION['REG_ERROR'] = "&iexcl;El Email no se encuentra! Intenta registrandote <a href='/welcome/register'>Aqu&iacute;</a>";
					header("LOCATION: ". PATH ."#");
			}
		}
	//END FORGOT
	//NEWPASS 
		if(isset($_POST['newsena'])){
			$mail = $_SESSION['correo'];
			$contra = $Functions->FilterText($_POST['newsena']);
			$contra2 = $Functions->FilterText($_POST['newsena2']);
			$buscar = $db->query("SELECT * FROM users WHERE mail = '{$mail}'");
			$user = $buscar->fetch_array();
			$newpassword = $Functions->Hash($user['username'], $contra);
			if(strlen($contra) < 6 || strlen($contra) > 32){
				$_SESSION['ERROR_RETURN'] = "Inserta una contraseña v&aacute;lida";
				header("LOCATION: ". PATH ."/account/password/resetIdentity/9346b03cbb86c009501ce113cb38dce39ebba9c34a6416d8edef5ac544db7dddb5158bf4e86bc09c089a3ed7e87049f144888ef2b45e1a02986bdc8858d82ad0dd460/?c=". $_SESSION['tmptxt_seg']."");
			}else{
				if($contra !== $contra2){
				$_SESSION['ERROR_RETURN'] = 'Las contrase&ntilde;as no son iguales';
				header("LOCATION: ". PATH ."/account/password/resetIdentity/9346b03cbb86c009501ce113cb38dce39ebba9c34a6416d8edef5ac544db7dddb5158bf4e86bc09c089a3ed7e87049f144888ef2b45e1a02986bdc8858d82ad0dd460/?c=". $_SESSION['tmptxt_seg']."");
				}else{
					$db->query("UPDATE users SET password = '{$newpassword}' WHERE mail = '{$mail}' LIMIT 1");
					$_SESSION['password'] = $newpassword;
					$_SESSION['GOOD_RETURN'] = 'Contraseña Actualizada con &eacute;xito';
					header("LOCATION: ". PATH ."/index");
				}
			}
		}
	//END NEWPASS
	ob_end_flush(); 
?>