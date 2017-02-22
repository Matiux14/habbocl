<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Dar Rangos');
	$TplClass->SetParam('zone', 'Dar Rango');
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
	if($_POST['giverank']){
		$check = $db->query("SELECT * FROM users WHERE username = '".$Functions->FilterText($_POST['name'])."' LIMIT 1");
		$row = $check->fetch_array();
		$repeat = $db->query("SELECT * FROM users_badges WHERE user_id = '". $row['id'] ."' && badge_id = '".$Functions->FilterText($_POST['badge'])."' LIMIT 1");
		if(empty($_POST['pin']) || empty($_POST['name']) || empty($_POST['role']) || empty($_POST['badge'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/ranks.php");
		}elseif($repeat->num_rows > 0){
			$_SESSION['ERROR_RETURN'] = "El Usuario ya cuenta con la Placa ingresada";
			header("LOCATION: ". HK ."/ranks.php");
		}else{
			if($check->num_rows > 0){
				$db->query("UPDATE users SET cms_role = '{$Functions->FilterText($_POST['role'])}', rank = '{$Functions->FilterText($_POST['rankid'])}', cms_pin = '{$Functions->FilterText($_POST['pin'])}', cms_staffocult = '{$Functions->FilterText($_POST['ocult'])}' WHERE username = '{$_POST['name']}'");
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Dar Rango', 'Le ha dado rango ".$_POST['rankid']." a ".$_POST['name']."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$db->query("INSERT INTO users_badges (user_id, badge_id) VALUES ('". $row['id'] ."', '{$Functions->FilterText($_POST['badge'])}')");
				$_SESSION['GOOD_RETURN'] = "Rango entregado correctamente";
				header("LOCATION: ". HK ."/ranks.php");
			}else {
				$_SESSION['ERROR_RETURN'] = "El usuario no ex&iacute;ste";
				header("LOCATION: ". HK ."/ranks.php");
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
					<div class="panel border-1 border-green-500">
						<div class="panel-title bg-green-500">
							<div class="panel-head color-white"><i class="fa fa-user-plus"></i> Dar Rango</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para agregar un Rango</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Usuario</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Usuario a dar el rango" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Rango</label>
									<br><select class="form-control" name="rankid">
											<?php $que = $db->query("SELECT * FROM ranks ORDER BY id DESC"); while($qued = $que->fetch_array()){?>
											<option value="<?php echo $qued['id']; ?>"><?php echo $qued['name']; ?></option>
											<?php } ?>
										</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Pin</label>
									<input type="text" class="form-control" id="input-text" name="pin" placeholder="Pin de Acceso" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Role</label>
									<input type="text" class="form-control" id="input-text" name="role" placeholder="Trabajo a realizar" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Rango Oculto</label>
									<br><select value="0" class="form-control" name="ocult">
										<option value="0">No</option>
										<option value="1">S&iacute;</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Placa</label>
									<input type="text" class="form-control" id="input-text" name="badge" placeholder="Placa a recibir" value="">
								</div>
								<input name="giverank" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="panel border-1 border-green-300">
						<div class="panel-title bg-green-300">
							<div class="panel-head color-white"><i class="fa fa-shield"></i> Usuarios con Rango</div>
						</div>
						<div class="panel-body" style="max-height:800px;display: block;overflow: auto;">
							<?php global $db;
								$result = $db->query("SELECT * FROM users WHERE rank >= 3 ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){
										echo '<li style="font-size:13px;">'.$data['username'].' <div style="float:right;"> <b><i class="fa fa-shield"></i> Rango:</b> '.$data['rank'].'</div></li><hr>';
										unset($k);
									}
									echo '</ul>';
									
								}else{
									echo '<b style="color:red;">No hay Addons creados</i>';
								}
							?>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<?php require_once 'templates/facebook.tpl'; ?>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>