<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Dar Recursos');
	$TplClass->SetParam('zone', 'Dar Recursos');
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
	if(isset($_POST['giverec'])){
		$check = $db->query("SELECT * FROM users WHERE username = '".$Functions->FilterText($_POST['name'])."' LIMIT 1");
		$row = $check->fetch_array();
		if(empty($_POST['name'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/resources.php");
		}elseif($_POST['credits'] >= 999999 || $_POST['duckets'] >= 999999 || $_POST['diamantes'] >= 999999){
			$_SESSION['ERROR_RETURN'] = "No puedes entregar cantidades grandes de recursos";
			header("LOCATION: ". HK ."/resources.php");
		}else{
			if($check->num_rows > 0){
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Dar Recursos', 'Le ha dado ".$Functions->FilterText($_POST['credits'])." cr&eacute;ditos, ".$Functions->FilterText($_POST['duckets'])." Duckets y ".$Functions->FilterText($_POST['diamantes'])." Diamantes a ".$Functions->FilterText($_POST['name'])."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$db->query("UPDATE users SET credits = credits + '{$Functions->FilterText($_POST['credits'])}', activity_points = activity_points + '{$Functions->FilterText($_POST['duckets'])}', seasonal_currency = seasonal_currency + '{$Functions->FilterText($_POST['diamantes'])}' WHERE username = '".$Functions->FilterText($_POST['name'])."' LIMIT 1");
				$_SESSION['GOOD_RETURN'] = "Recursos entregados correctamente";
				header("LOCATION: ". HK ."/resources.php");
			}else {
				$_SESSION['ERROR_RETURN'] = "El usuario no ex&iacute;ste";
				header("LOCATION: ". HK ."/resources.php");
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
					<div class="panel border-1 border-yellow-500">
						<div class="panel-title bg-yellow-500">
							<div class="panel-head color-white"><i class="fa fa-usd"></i> Dar Recursos</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para dar Recursos</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Usuario</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Usuario a dar recursos">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Cr&eacute;ditos</label>
									<input type="number" class="form-control" id="input-text" name="credits" maxlength="6" min="-999999" max="999999" placeholder="Cr&eacute;ditos a recibir" value="0">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Duckets</label>
									<input type="number" class="form-control" id="input-text" name="duckets" maxlength="6" min="-999999" max="999999" placeholder="Duckets a recibir" value="0">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Diamantes</label>
									<input type="number" class="form-control" id="input-text" name="diamantes" maxlength="6" min="-999999" max="999999" placeholder="Diamantes a recibir" value="0">
								</div>
								<input name="giverec" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Enviar">
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