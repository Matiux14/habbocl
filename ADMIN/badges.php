<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Dar Placas');
	$TplClass->SetParam('zone', 'Dar Placa');
	$Functions->LoggedHk("true");
	
	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	$do = $Functions->FilterText($_GET['do']);
	$key = $Functions->FilterText($_GET['key']);

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
	if(isset($_POST['givebadge'])){
		$check = $db->query("SELECT * FROM users WHERE username = '".$Functions->FilterText($_POST['name'])."' LIMIT 1");
		$row = $check->fetch_array();
		$repeat = $db->query("SELECT * FROM users_badges WHERE user_id = '". $row['id'] ."' && badge_id = '".$Functions->FilterText($_POST['badge'])."' LIMIT 1");
		if(empty($_POST['name']) || empty($_POST['badge'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/badges.php");
		}elseif($repeat->num_rows > 0){
			$_SESSION['ERROR_RETURN'] = "El Usuario ya cuenta con la Placa";
			header("LOCATION: ". HK ."/badges.php");
		}else{
			if($check->num_rows > 0){
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Dar Placa', 'Le ha dado la placa ".$Functions->FilterText($_POST['badge'])." a ".$Functions->FilterText($_POST['name'])."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$db->query("INSERT INTO users_badges (user_id, badge_id) VALUES ('". $row['id'] ."', '{$Functions->FilterText($_POST['badge'])}')");
				$_SESSION['GOOD_RETURN'] = "Placa entregada correctamente";
				header("LOCATION: ". HK ."/badges.php");
			}else {
				$_SESSION['ERROR_RETURN'] = "El usuario no ex&iacute;ste";
				header("LOCATION: ". HK ."/badges.php");
			}
		}
	}
	if(isset($_POST['searchbadge'])){ 
		$buscar = $Functions->FilterText($_POST['nameq']);
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Quitar Placas', 'Ha escaneado a ".$buscar."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		if(empty($buscar)){
			$_SESSION['ERROR_RETURN'] = "Debes insertar un nombre de usuario";
				header("LOCATION: ". HK ."/badges.php");
		}
	}
	if($do == "dele" && !empty($key)){
		$buscar = $Functions->FilterText($_POST['nameq']);
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Quitar Placas', 'Ha retirado una placa a ".$buscar."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM users_badges WHERE id = '{$key}' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Placa retirada correctamente";
		header("LOCATION: ". HK ."/badges.php");					
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel border-1 border-blue-500">
						<div class="panel-title bg-blue-500">
							<div class="panel-head color-white"><i class="fa fa-shield"></i> Dar Placa</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para dar una Placa</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Usuario</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Usuario a dar la Placa" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Placa</label>
									<input type="text" class="form-control" id="input-text" name="badge" placeholder="C&oacute;digo de la Placa a recibir" value="">
								</div>
								<input name="givebadge" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Enviar">
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel border-1 border-red-500">
						<div class="panel-title bg-red-500">
							<div class="panel-head color-white"><i class="fa fa-close"></i> Quitar Placa</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para quitarle una Placa a un usuario</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Usuario</label>
									<input type="text" class="form-control" id="input-text" name="nameq" placeholder="Usuario a Buscar" value="">
								</div>
								<input name="searchbadge" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Buscar">
							</form>
							<?php	if(isset($_POST['searchbadge'])){ 
										$buscar = $Functions->FilterText($_POST['nameq']);
										$busc = $db->query("SELECT * FROM users WHERE username = '$buscar'");
										if($busc->num_rows > 0){
											if($user['rank'] >= 7){?>
												<div class="slimScrollDiv" style="position:relative;overflow:hidden;width:auto;height:300px;">
													<ul class="media-list panel-scroll media-content media-striped" style="overflow: auto; width: 100%; height: 430px;">
														<?php echo "<br><b>Placas de ".$buscar.":</b><br>";
														while($inf = $busc->fetch_array()){
															$find = $db->query("SELECT * FROM users_badges WHERE user_id = '$inf[id]' ORDER by id DESC");
															while($us = $find->fetch_array()){?>
																<li class="media">
																	<a class="pull-left" href="#">
																		<img class="media-object" src="<?php echo BADGEURL . $us['badge_id']; ?>.gif" style="margin-top:30px">
																	</a>
																	<div class="media-body">
																		<div class="clearfix">
																			<a href="#" class="media-heading">C&oacute;digo de la Placa</a>
																		</div>
																		<p class="box"><?php echo $us['badge_id']; ?></p>
																	</div>
																	<div class="media-footer"><div class="pull-right media-tools"><a href="<?php echo HK; ?>/badges.php?do=dele&key=<?php echo $us['id']; ?>"><i class="fa fa-trash"></i> Eliminar</a></div></div>
																</li>
												<?php 		}	
														} ?>
													</ul>
												</div>
										<?php		}else{echo '<br><b style="color:red">Herramienta solo para Rango 7 en adelante</b><br>';}
										}else{ 
											echo '<br><b style="color:red">No se encontraron resultados para <i style="color:black;">'.$buscar.'</i></b><br>';
										}
									}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>