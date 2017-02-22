<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Editar Usuario');
	$TplClass->SetParam('zone', 'Editar Usuario');
	$Functions->LoggedHk("true");
	$Functions->LoggedHkADMIN("true");
	
	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	$action = $Functions->FilterText($_GET['action']);
	$id = $Functions->FilterText($_GET['id']);

	$TplClass->SetAll();
	if( $_SESSION['ERROR_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error">'.$_SESSION['ERROR_RETURN'].'</div></div>');
		unset($_SESSION['ERROR_RETURN']);
	}
	if( $_SESSION['GOOD_RETURN'] ){
		$TplClass->SetParam('error', '<div id="generic"><div id="error" style="background: #88B600;border: 1px solid #88B600;">'.$_SESSION['GOOD_RETURN'].'</div></div>');
		unset($_SESSION['GOOD_RETURN']);
	}
	$result = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1");
	while($data = $result->fetch_array()){
		$SHORTNAME = $data['hotelname'];
		$FACE = $data['facebook'];
		$LOGO = $data['logo'];
	}
	if(isset($_POST['buscador'])){ 
		$buscar = $Functions->FilterText($_POST['palabra']);
		if(empty($buscar)){
			$_SESSION['ERROR_RETURN'] = "Debes insertar un nombre de usuario";
				header("LOCATION: ". HK ."/users.php?buscar");
		}else{
			$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
			$sql = "SELECT * FROM users WHERE username = '$buscar' ORDER BY id DESC";
			mysql_select_db(DB_DATABASE, $con);
			$result = mysql_query($sql, $con);
			$total = mysql_num_rows($result);
			if ($row = mysql_fetch_array($result)){
					header("LOCATION: ". HK ."/users.php?id=".$row['id']."");
			}else{ 
				$_SESSION['ERROR_RETURN'] = "No se encontraron resultados para: <b>$buscar</b>";
				header("LOCATION: ". HK ."/users.php?buscar");
			}
		}
	}
	if(isset($_POST['save'])){
		if(empty($_POST['mision']) || empty($_POST['email']) || empty($_POST['imgprofile']) || empty($_POST['imgfondo']) || empty($_POST['diamantes']) || empty($_POST['creditos']) || empty($_POST['duckets']) || empty($_POST['video'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/users.php?id=".$id."");
		}else{
			$db->query("UPDATE users SET motto = '{$Functions->FilterText($_POST['mision'])}', mail = '{$Functions->FilterText($_POST['email'])}', cms_pprofile = '{$Functions->FilterText($_POST['imgprofile'])}', cms_pbackground = '{$Functions->FilterText($_POST['imgfondo'])}', seasonal_currency = '{$Functions->FilterText($_POST['diamantes'])}', credits = '{$Functions->FilterText($_POST['creditos'])}', activity_points = '{$Functions->FilterText($_POST['duckets'])}', cms_video = '{$Functions->FilterText($_POST['video'])}', facebook = '{$Functions->FilterText($_POST['face'])}', cms_twitter = '{$Functions->FilterText($_POST['twit'])}' WHERE id = ".$id."");
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Editar usuarios', 'Ha editado el usuario con id ".$id."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			$_SESSION['GOOD_RETURN'] = "Usuario editado correctamente";
			header("LOCATION: ". HK ."/users.php?id=".$id."");
		}

	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<?php global $db;
					if(!empty($id)){ 
					$hj = $db->query("SELECT * FROM users WHERE id = '". $id ."'");
					$h_edit = $hj->fetch_array();		
				?>
				<div class="col-lg-12">
					<div class="panel border-1 border-orange-500">
						<div class="panel-title bg-orange-500">
							<div class="panel-head color-white"><i class="fa fa-search"></i> Buscar a un Usuario</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Busca al usuario a editar</p>
								<div class="form-group">
									<input type="text" class="form-control" id="input-text" name="palabra" placeholder="Nombre de Usuario">
								</div>
								<input name="buscador" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-0" value="Buscar">
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="panel border-1 border-orange-500">
						<div class="panel-title bg-orange-500">
							<div class="panel-head color-white"><i class="fa fa-edit"></i> Edita a <?php echo $h_edit['username']; ?></div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<table>
									<tr>
										<td>Nombre: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/icon_ajustes.png" /></td>
										<td><b><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['username']; ?>" disabled="true" /></b></td>
									</tr>
									<tr>
										<td><br>Misi&oacute;n: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/mision.gif" /></td>
										<td><b><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" name="mision" value="<?php echo $h_edit['motto']; ?>" /></b></td>
									</tr>  
									<tr> 
										<td>ID: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/icon_inicio.png" /></td>
										<td><b><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['id']; ?>" disabled="true" /></b></td>
									</tr>
									<tr>
										<td>Correo electr&oacute;nico: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/mail.png" /></td>
										<td><b><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['mail']; ?>" name="email" /></b></td>
									</tr>
									<tr>
										<td>Rango: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/rank.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['rank']; ?>" disabled="true" /></td>
									</tr>
									<tr>
										<td>Se registró el día: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/registred.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del 2015", $h_edit['account_created'])); ?>" disabled="true" /></td>
									</tr>
									<tr>
										<td>Última Conexión: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/registred.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%c", $h_edit['last_online'])); ?>" disabled="true" /></td>
									</tr>
									<tr>
										<td>Cumpleaños: <img style="float:right;height:16px;width:16px;" src="http://static.habbo-happy.net/img/articles/87111f_42252962014818313610.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['cms_birthday']; ?>" disabled="true" /></td>
									</tr>
									<tr>
										<td>Foto de Perfil: <img style="float:right;height:16px;width:16px;" src="http://uploads.webflow.com/55404a22cc975b894a928310/53576fca3f5f51cb3600031a_Icon-Blue.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" name="imgprofile" value="<?php echo $h_edit['cms_pprofile']; ?>"/></td>
									</tr>
									<tr>
										<td>Foto de Fondo: <img style="float:right;height:16px;width:16px;" src="http://www.biharvista.in/Images/logo/gallery.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" name="imgfondo" value="<?php echo $h_edit['cms_pbackground']; ?>"/></td>
									</tr>
									<tr>
										<td>Facebook: <img style="float:right;" src="http://www.ewartshaw.com/images/facebook16.png" /></td>
										<td>http://facebook.com/<input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" name="face" value="<?php echo $h_edit['facebook']; ?>"/></td>
									</tr>
									<tr>
										<td>Twitter: <img style="float:right;" src="http://incubacen.exactas.uba.ar/wp-content/themes/toommorel-lite/images/twitter_32.png" /></td>
										<td>http://twitter.com/<input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" name="twit" value="<?php echo $h_edit['cms_twitter']; ?>"/></td>
									</tr>
									<tr>
										<td>IP: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/ip.png" /></td>
										<td><b><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['ip_last']; ?>" disabled="true" /></b></td>
									</tr>
									<tr>
										<td>Diamantes: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/diamantes.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="number" min="-99999999" max="99999999" class="form-control" id="input-text" name="diamantes" maxlength="8" value="<?php echo $h_edit['seasonal_currency']; ?>" /></td>
									</tr>
									<tr>
										<td>Cr&eacute;ditos: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/creditos.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="number" min="-99999999" max="99999999" class="form-control" id="input-text" name="creditos" maxlength="8" value="<?php echo $h_edit['credits']; ?>" /></td>
									</tr>
									<tr>
										<td>Duckets: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/duckets.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="number" min="-99999999" max="99999999" class="form-control" id="input-text" name="duckets" maxlength="8" value="<?php echo $h_edit['activity_points']; ?>" /></td>
									</tr>
									<tr>
										<td>Referidos: <img style="float:right;" src="<?php echo HK; ?>/templates/images/icons/referidos.gif" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" value="<?php echo $h_edit['cms_refers']; ?>" disabled="true" /></td>
									</tr>
									<tr>
										<td>V&iacute;deo: <img style="float:right;" src="http://www.sewanee.edu/media/sewanee-today/site-assets/youtube-16x16.png" /></td>
										<td><input style="width:260%;margin-left:5px;border:1px solid gray;margin-bottom:10px;" type="text" class="form-control" id="input-text" name="video" value="<?php echo $h_edit['cms_video']; ?>"/></td>
									</tr>
								</table>
								<input name="save" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
			
				<div class="col-lg-4">
					<div class="panel border-1 border-orange-500">
						<div class="panel-title bg-orange-500">
							<div class="panel-head color-white"><i class="fa fa-user"></i> <?php echo $h_edit['username']; ?></div>
						</div>
						<div class="panel-body" style="padding:20px;height:150px;width:100%;background-image: url('<?php echo $h_edit['cms_pbackground']; ?>');">
							<table>
								<td>
									<img style="height:100px;width:100px;border-radius:3px;border:1px solid white;" src="<?php echo $h_edit['cms_pprofile']; ?>" /></div>
								</td>
										<td>
										<div id="box_p">
										<table>
											<tr>
												<td width="10">
												<img src="<?php echo AVATARIMAGE; ?><?php echo $h_edit['look']; ?>&direction=2&head_direction=3&gesture=sml&action=wav&size=n" width="64" height="110"/>
												</td>
												<td>
													<div style="background: rgba(0, 0, 0, 0.8);padding:5px;border-radius:5px;color:white;"><b>Nombre:</b> <?php echo $h_edit['username']; ?></div>
													<br>
													<div style="background: rgba(0, 0, 0, 0.8);padding:5px;border-radius:5px;color:white;"><b>Misión:</b> <?php echo $h_edit['motto']; ?></div>
												</td>
											</tr>
										</table>
										</div>
										</td>
							</table>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-lg-6">
					<div class="panel border-1 border-orange-500">
						<div class="panel-title bg-orange-500">
							<div class="panel-head color-white"><i class="fa fa-search"></i> Buscar a un Usuario</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Busca al usuario a editar</p>
								<div class="form-group">
									<input type="text" class="form-control" id="input-text" name="palabra" placeholder="Nombre de Usuario">
								</div>
								<input name="buscador" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-0" value="Buscar">
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<?php require_once 'templates/facebook.tpl'; ?>
				</div>
				<?php } ?>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>