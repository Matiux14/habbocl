<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Configuraci&oacute;n Inicial');
	$TplClass->SetParam('zone', 'Configuraci&oacute;n Inicial');
	$Functions->LoggedHk("true");
	$Functions->LoggedHkADMIN("true");
	
	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();

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
	if(isset($_POST['iconfig'])){
		if(empty($_POST['creditstart']) || empty($_POST['ducketstart']) || empty($_POST['diamondstart']) || empty($_POST['look']) || empty($_POST['motto']) || empty($_POST['id_room'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/config.php");
		}else{
			$sql = $db->query("ALTER TABLE `users` CHANGE `credits` `credits` INT(11) NOT NULL DEFAULT '". $Functions->FilterText($_POST['creditstart']) ."'"); 
			$db->query("ALTER TABLE `users` CHANGE `activity_points` `activity_points` INT(11) NOT NULL DEFAULT '". $Functions->FilterText($_POST['ducketstart}']) ."'"); 
			$db->query("ALTER TABLE `users` CHANGE `seasonal_currency` `seasonal_currency` INT(11) NOT NULL DEFAULT '". $Functions->FilterText($_POST['diamondstart']) ."'"); 
			$db->query("ALTER TABLE `users` CHANGE `look` `look` VARCHAR(160) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '". $Functions->FilterText($_POST['look']) ."'");
			$db->query("ALTER TABLE `users` CHANGE `motto` `motto` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '". $Functions->FilterText($_POST['motto']) ."'");
			$db->query("ALTER TABLE `users` CHANGE `home_room` `home_room` INT(10) UNSIGNED NOT NULL DEFAULT '". $Functions->FilterText($_POST['id_room']) ."'");
			$db->query("UPDATE users SET home_room = '". $Functions->FilterText($_POST['id_room']) ."'");
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Configuraci&oacute;n del Hotel', 'Ha Actualizado la configuraci&oacute;n incial del Hotel', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			if($sql){
				$_SESSION['GOOD_RETURN'] = "La Configuraci&oacute;n Incial ha sido Actualizada Correctamente";
				header("LOCATION: ". HK ."/config.php");
			}else{
				$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
				header("LOCATION: ". HK ."/config.php");
			}
		}
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel">
						<div class="panel-title bg-blue-grey-800 color-white">
							<div class="panel-head"><i class="fa fa-cog"></i> Configuraci&oacute;n de Usuarios</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Edita los datos iniciales de los usuarios por registrase. Nota: El 0 no vale; si deseas asignar un 0 hazlo manualmente desde la Base de Datos.</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Cr&eacute;ditos Iniciales</label>
									<input type="text" class="form-control" id="input-text" name="creditstart" placeholder="Cr&eacute;ditos Iniciales">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Duckets Iniciales</label>
									<input type="text" class="form-control" id="input-text" name="ducketstart" placeholder="Duckets Iniciales">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Diamantes Iniciales</label>
									<input type="text" class="form-control" id="input-text" name="diamondstart" placeholder="Diamantes Iniciales">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Look de Reg&iacute;stro</label>
									<input type="text" class="form-control" id="input-text" name="look" placeholder="Look de Reg&iacute;stro">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Misi&oacute;n de Reg&iacute;stro</label>
									<input type="text" class="form-control" id="input-text" name="motto" placeholder="Misi&oacute;n de Reg&iacute;stro">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Sala central (de bienvenida)</label>
									<input type="text" class="form-control" id="input-text" name="id_room" placeholder="Sala central (de bienvenida)">
								</div>
								<input name="iconfig" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
					
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<?php require_once 'templates/facebook.tpl'; ?>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>