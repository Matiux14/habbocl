<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Sub Navegaci&oacute;n');
	$TplClass->SetParam('zone', 'Sub Navegaci&oacute;n');
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
	if($_POST['snadd']){
		if(isset($_POST['name']) && isset($_POST['zona']) && isset($_POST['local'])){
			$name = $Functions->FilterText($_POST['name']);
			$zona = $Functions->FilterText($_POST['zona']);
			$local = $Functions->FilterText($_POST['local']);
			if(empty($name) || empty($zona) || empty($local)){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/subnavi.php");
			}else{
				$dbQuery= array();
				$dbQuery['name'] = $name;
				$dbQuery['zone'] = $zona;
				$dbQuery['TAB'] = $local;
				$query = $db->insertInto('cms_navi', $dbQuery);
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha agregado la sub-pestaña ".$name."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Sub Navegaci&oacute;n agregada correctamente";
				header("LOCATION: ". HK ."/subnavi.php");
			}
		}
	}
	if($_POST['snedit']){
		if(isset($_POST['name']) && isset($_POST['zona']) && isset($_POST['local'])){
			$name = $Functions->FilterText($_POST['name']);
			$zona = $Functions->FilterText($_POST['zona']);
			$local = $Functions->FilterText($_POST['local']);
			$db->query("UPDATE cms_navi SET name = '{$name}', zone = '{$zona}', TAB = '{$local}' WHERE id = '{$id}' LIMIT 1");
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha editado la sub-pestaña ".$name."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			$_SESSION['GOOD_RETURN'] = "Sub Navegaci&oacute;n editada correctamente";
			header("LOCATION: ". HK ."/subnavi.php");									
		}
	}
	if($action == "err" && !empty($id)){
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha borrado una sub-pestaña', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_navi WHERE id = '{$id}' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Subnavegaci&oacute;n borrada correctamente";
		header("LOCATION: ". HK ."/subnavi.php");						
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<div class="col-lg-10 col-md-6 col-sm-12 col-xs-12">
					<div class="panel">
						<div class="panel-title">
							<div class="panel-head"><i class="fa fa-info-circle"></i> Informaci&oacute;n</div>
						</div>
						<div class="panel-body" style="max-height:430px;display: block;overflow: auto;">
							<p style="text-align:justify">
								La <b>'Zona'</b> es muy importante tenerla en cuenta; ya que deber&aacute;s 
								poner la misma (frase, palabra, archivoPHP) en la cabecera del archivo creado previamente.
								<br>Ejemplo con el Archivo <b>me.php</b>:<br>
								<img src="<?php echo HK; ?>/templates/images/tip.png" /><br>
								Esto es para evitar problemas con la sub navegaci&oacute;n y se cumpla la funci&oacute;n 
								de selecci&oacute;n en las Tabs.
							</p>
						</div>
					</div>
				</div>
				<?php global $db;
					if($action == "edit" && !empty($id)){ 
					$hj = $db->query("SELECT * FROM cms_navi WHERE id = '". $id ."'");
					$h_edit = $hj->fetch_array();		
				?>
				<div class="col-lg-6">
					<div class="panel border-1 border-purple-500">
						<div class="panel-title bg-purple-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Edita una Sub Secci&oacute;n (ID: <?php echo $id; ?>)</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para editar una pestaña a la CMS</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre</label>
									<input type="text" class="form-control" id="input-text" name="name" value="<?php echo $h_edit['name']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Zona</label><p><i style="font-size:11px;">NOTA: Si la zona es IGUAL a la Zona de la TAB, el SubNavi aparacer&aacute; seleccionado.</i>
									<input type="text" class="form-control" id="input-text" name="zona" value="<?php echo $h_edit['zone']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Localizaci&oacute;n:</label>
									<select name="local" style="width:auto;height:30px;color:#999999;border: 1px solid #EEEEEE;" class="btn dropdown-toggle selectpicker btn-default">
										<option value="<?php echo $h_edit['TAB']; ?>" selected>Tab donde mostrarse</option>
										<?php global $db;
											$result = $db->query("SELECT * FROM cms_header ORDER BY id DESC");
											if($result->num_rows > 0){
												while($data = $result->fetch_array()){
													echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
												}
											}else{
												echo '<option>No hay Tabs Creados</option>';
											}
										?>
									</select>
								</div>
								<input name="snedit" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-lg-6">
					<div class="panel border-1 border-purple-500">
						<div class="panel-title bg-purple-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Agrega una Subsecci&oacute;n a una TAB</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para insertar una Subsecci&oacute;n a la CMS</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Texto de la TAB">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Zona</label><p><i style="font-size:11px;">NOTA: Si la zona es IGUAL a la Zona de la TAB, el SubNavi aparacer&aacute; seleccionado.</i>
									<input type="text" class="form-control" id="input-text" name="zona" placeholder="A dónde llevará al dar clic">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Localizaci&oacute;n:</label>
									<select name="local" style="width:auto;height:30px;color:#999999;border: 1px solid #EEEEEE;" class="btn dropdown-toggle selectpicker btn-default">
										<option selected>Tab donde mostrarse</option>
										<?php global $db;
											$result = $db->query("SELECT * FROM cms_header ORDER BY id DESC");
											if($result->num_rows > 0){
												while($data = $result->fetch_array()){
													echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
												}
											}else{
												echo '<option>No hay Tabs Creados</option>';
											}
										?>
									</select>
								</div>
								<input name="snadd" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
						<?php } ?>
				<div class="col-lg-4">
					<div class="panel border-1 border-purple-300">
						<div class="panel-title bg-purple-300">
							<div class="panel-head color-white"><i class="fa fa-bars"></i> Sub Secciones del Hotel</div>
						</div>
						<div class="panel-body" style="max-height:430px;display: block;overflow: auto;">
							<?php global $db;
								$result = $db->query("SELECT * FROM cms_navi ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){
										$tab = $db->query("SELECT * FROM cms_header WHERE id = ".$data['TAB']." ORDER BY id DESC");
										$ubc = $tab->fetch_array();
										echo '<li style="font-size:13px;">&#9758; '.$data['name'].' &#187; <div style="float:right;"><a href="'. HK .'/subnavi.php?action=edit&id='.$data['id'].'"><b><i class="fa fa-pencil-square-o"></i> Editar</b></a> | <a href="'. HK .'/subnavi.php?action=err&id='.$data['id'].'"><b><i class="fa fa-trash-o"></i> Borrar</b></a></div></li><p><b>Ubicado en:</b> '.$ubc['zone'].'<hr>';
										unset($k);
									}
									echo '</ul>';
									
								}else{
									echo '<b style="color:red;">No hay SubNavis creados</i>';
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