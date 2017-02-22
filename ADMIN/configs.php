<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Configuraci&oacute;n del Hotel');
	$TplClass->SetParam('zone', 'Configuraci&oacute;n del Hotel');
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
	$data = $result->fetch_array();
	$SHORTNAME = $data['hotelname'];
	$FACE = $data['facebook'];
	$LOGO = $data['logo'];
	
	if(isset($_POST['gconfig'])){
		$db->query("UPDATE cms_settings SET hotelname = '". $Functions->FilterText($_POST['hotelname']) ."', facebook = '". $Functions->FilterText($_POST['fb']) ."', logo = '". $Functions->FilterText($_POST['logo']) ."', host = '". $Functions->FilterText($_POST['host']) ."', port = '". $Functions->FilterText($_POST['port']) ."', external_variables = '". $Functions->FilterText($_POST['extvar']) ."', external_texts = '". $Functions->FilterText($_POST['exttext']) ."', productdata = '". $Functions->FilterText($_POST['prod']) ."', furnidata = '". $Functions->FilterText($_POST['furn']) ."', flash_client_url = '". $Functions->FilterText($_POST['flash']) ."', habbo_swf = '". $Functions->FilterText($_POST['habboswf']) ."', id_paygol = '". $Functions->FilterText($_POST['pay']) ."', design = '". $Functions->FilterText($_POST['diseno']) ."' WHERE id = '1'");
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Configuraci&oacute;n General del Hotel', 'Ha Actualizado la configuraci&oacute;n General del Hotel', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$_SESSION['GOOD_RETURN'] = "La Configuraci&oacute;n General ha sido Actualizada Correctamente";
		header("LOCATION: ". HK ."/configs.php");
	}
	
	if(isset($_POST['REG'])){
		if($data['registros'] == 1){
			$var = 0;
		}else{$var = 1;}
		$action = $db->query("UPDATE cms_settings SET registros = '{$var}' WHERE id = '1' LIMIT 1");
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Configuraci&oacute;n General del Hotel', 'Ha Cambiado la configuraci&oacute;n de los Reg&iacute;stros', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		if($action){
			$_SESSION['GOOD_RETURN'] = "Registros modificados Correctamente";
			header("LOCATION: ". HK ."/configs.php");
		}else{
			$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
			header("LOCATION: ". HK ."/configs.php");
		}
	}
	if(isset($_POST['MOD'])){
		if($data['reg_mod'] == 1){
			$var = 0;
		}else{$var = 1;}
		$action = $db->query("UPDATE cms_settings SET reg_mod = '{$var}' WHERE id = '1' LIMIT 1");
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Configuraci&oacute;n General del Hotel', 'Ha Cambiado la configuraci&oacute;n de los Reg&iacute;stros con Prefijo MOD', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		if($action){
			$_SESSION['GOOD_RETURN'] = "Registros con Prefijo MOD modificados Correctamente";
			header("LOCATION: ". HK ."/configs.php");
		}else{
			$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
			header("LOCATION: ". HK ."/configs.php");
		}
	}
	if(isset($_POST['IP'])){
		if($data['reg_ip'] == 1){
			$var = 0;
		}else{$var = 1;}
		$action = $db->query("UPDATE cms_settings SET reg_ip = '{$var}' WHERE id = '1' LIMIT 1");
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Configuraci&oacute;n General del Hotel', 'Ha Cambiado la configuraci&oacute;n de los Reg&iacute;stros por IP', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		if($action){
			$_SESSION['GOOD_RETURN'] = "Registros por IP modificados Correctamente";
			header("LOCATION: ". HK ."/configs.php");
		}else{
			$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
			header("LOCATION: ". HK ."/configs.php");
		}
	}
	if(isset($_POST['MANT'])){
		if($data['mantenimiento'] == 1){
			$var = 0;
		}else{$var = 1;}
		$action = $db->query("UPDATE cms_settings SET mantenimiento = '{$var}' WHERE id = '1' LIMIT 1");
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Configuraci&oacute;n General del Hotel', 'Ha puesto un Mantenimiento', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		if($action){
			$_SESSION['GOOD_RETURN'] = "Mantenimiento modificado Correctamente";
			header("LOCATION: ". HK ."/configs.php");
		}else{
			$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
			header("LOCATION: ". HK ."/configs.php");
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
							<div class="panel-head"><i class="fa fa-cogs"></i> Configuraci&oacute;n del Hotel</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Edita los datos de tu Hotel</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Reg&iacute;stros</label>
									<?php if($data['registros'] == 1){ echo '<input type="submit" name="REG" class="btn btn-dark bg-red-300 color-white margin-left-10" style="float:right;"value="Desactivar" />';}else{ echo '<input type="submit" name="REG" class="btn btn-dark bg-blue-300 color-white margin-left-10" style="float:right;"value="Activar" />';} ?>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Reg&iacute;stros con Prefijo MOD</label>
									<?php if($data['reg_mod'] == 1){ echo '<input type="submit" name="MOD" class="btn btn-dark bg-red-300 color-white margin-left-10" style="float:right;"value="Desactivar" />';}else{ echo '<input type="submit" name="MOD" class="btn btn-dark bg-blue-300 color-white margin-left-10" style="float:right;"value="Activar" />';} ?>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Reg&iacute;stros con la misma IP</label>
									<?php if($data['reg_ip'] == 1){ echo '<input type="submit" name="IP" class="btn btn-dark bg-red-300 color-white margin-left-10" style="float:right;"value="Desactivar" />';}else{ echo '<input type="submit" name="IP" class="btn btn-dark bg-blue-300 color-white margin-left-10" style="float:right;"value="Activar" />';} ?>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Mantenimiento</label>
									<?php if($data['mantenimiento'] == 1){ echo '<input type="submit" name="MANT" class="btn btn-dark bg-red-300 color-white margin-left-10" style="float:right;"value="Desactivar" />';}else{ echo '<input type="submit" name="MANT" class="btn btn-dark bg-blue-300 color-white margin-left-10" style="float:right;"value="Activar" />';} ?>
								</div>
								
								<hr>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre del Hotel</label>
									<input type="text" class="form-control" id="input-text" placeholder="Nombre del Hotel" name="hotelname" value="<?php echo $data['hotelname']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Facebook del Hotel</label>
									<input type="text" class="form-control" id="input-text" placeholder="Facebook del Hotel" name="fb" value="<?php echo $data['facebook']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Logo</label>
									<input type="text" class="form-control" id="input-text" placeholder="Logo del Hotel" name="logo" value="<?php echo $data['logo']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">ID de tu PayGol</label>
									<input type="text" class="form-control" id="input-text" placeholder="ID de tu Servicio PayGol" name="pay" value="<?php echo $data['id_paygol']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Host</label>
									<input type="text" class="form-control" id="input-text" placeholder="Host" name="host" value="<?php echo $data['host']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Puerto</label>
									<input type="text" class="form-control" id="input-text" placeholder="Puerto del Client" name="port" value="<?php echo $data['port']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">External Variables</label>
									<input type="text" class="form-control" id="input-text" placeholder="External Variables" name="extvar" value="<?php echo $data['external_variables']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">External Texts</label>
									<input type="text" class="form-control" id="input-text" placeholder="External Texts" name="exttext" value="<?php echo $data['external_texts']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Productdata</label>
									<input type="text" class="form-control" id="input-text" placeholder="Productdata" name="prod" value="<?php echo $data['productdata']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Furnidata</label>
									<input type="text" class="form-control" id="input-text" placeholder="Furnidata" name="furn" value="<?php echo $data['furnidata']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Flash Client URL</label>
									<input type="text" class="form-control" id="input-text" placeholder="Flash Client" name="flash" value="<?php echo $data['flash_client_url']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Habbo SWF</label>
									<input type="text" class="form-control" id="input-text" placeholder="Habbo.SWF" name="habboswf" value="<?php echo $data['habbo_swf']; ?>">
								</div>
								<input name="gconfig" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
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