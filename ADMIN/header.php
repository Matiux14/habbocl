<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Header');
	$TplClass->SetParam('zone', 'Header');
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
	if($_POST['hadd']){
		if(isset($_POST['name']) && isset($_POST['style']) && isset($_POST['zona']) && isset($_POST['color'])){
			$name = $Functions->FilterText($_POST['name']);
			$style = $Functions->FilterText($_POST['style']);
			$zona = $Functions->FilterText($_POST['zona']);
			$color = $Functions->FilterText($_POST['color']);
			if(empty($name) || empty($zona) || empty($color)){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/header.php");
			}else{
				$dbQuery= array();
				$dbQuery['name'] = $name;
				$dbQuery['new'] = $style;
				$dbQuery['zone'] = $zona;
				$dbQuery['color'] = $color;
				$query = $db->insertInto('cms_header', $dbQuery);
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha agregado la pestaña ".$name."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Pestaña agregada correctamente";
				header("LOCATION: ". HK ."/header.php");
			}
		}
	}
	if($_POST['hedit']){
		if(isset($_POST['name']) && isset($_POST['style']) && isset($_POST['zona']) && isset($_POST['color'])){
			$name = $Functions->FilterText($_POST['name']);
			$style = $Functions->FilterText($_POST['style']);
			$zona = $Functions->FilterText($_POST['zona']);
			$color = $Functions->FilterText($_POST['color']);
			$db->query("UPDATE cms_header SET name = '{$name}', new = '{$style}', zone = '{$zona}',color = '{$color}' WHERE id = '{$id}' LIMIT 1");
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha editado la pestaña ".$name."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			$_SESSION['GOOD_RETURN'] = "Pestaña editada correctamente";
			header("LOCATION: ". HK ."/header.php");									
		}
	}
	if($action == "err" && !empty($id)){
		$sql = $db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha borrado una pestaña', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_header WHERE id = '{$id}' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Pestaña borrada correctamente";
		header("LOCATION: ". HK ."/header.php");						
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
					$hj = $db->query("SELECT * FROM cms_header WHERE id = '". $id ."'");
					$h_edit = $hj->fetch_array();		
				?>
				<div class="col-lg-6">
					<div class="panel border-1 border-blue-500">
						<div class="panel-title bg-blue-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Edita una Secci&oacute;n de la CMS (ID: <?php echo $id; ?>)</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para editar una pestaña a la CMS</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre</label>
									<input type="text" class="form-control" id="input-text" name="name" value="<?php echo $h_edit['name']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Estilo:</label>
									<select name="style" style="width:auto;height:30px;color:#999999;border: 1px solid #EEEEEE;" class="btn dropdown-toggle selectpicker btn-default">
										<option value="<?php echo $h_edit['new']; ?>"  selected>Estilo</option>
										<option value="0">Normal</option>
										<option value="1">Nuevo</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Zona</label>
									<input type="text" class="form-control" id="input-text" name="zona" value="<?php echo $h_edit['zone']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Color:</label>
									<select name="color" style="width:auto;height:30px;color:#999999;border: 1px solid #EEEEEE;" class="btn dropdown-toggle selectpicker btn-default">
										<option value="<?php echo $h_edit['color']; ?>"  selected>Color</option>
										<option value="blue">Azul</option>
										<option value="orange">Naranja</option>
										<option value="red">Rojo</option>
										<option value="violet">Violeta</option>
										<option value="green">Verde</option>
									</select>
								</div>
								<input name="hedit" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
							
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-lg-6">
					<div class="panel border-1 border-blue-500">
						<div class="panel-title bg-blue-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Agrega una Secci&oacute;n a la CMS</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para insertar una pestaña a la CMS</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Texto de la TAB">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Estilo:</label>
									<select name="style" style="width:auto;height:30px;color:#999999;border: 1px solid #EEEEEE;" class="btn dropdown-toggle selectpicker btn-default">
										<option value="0" selected>Estilo</option>
										<option value="0">Normal</option>
										<option value="1">Nuevo</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Zona</label>
									<input type="text" class="form-control" id="input-text" name="zona" placeholder="A dónde llevará al dar clic">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Color:</label>
									<select name="color" style="width:auto;height:30px;color:#999999;border: 1px solid #EEEEEE;" class="btn dropdown-toggle selectpicker btn-default">
										<option selected>Color</option>
										<option value="blue">Azul</option>
										<option value="orange">Naranja</option>
										<option value="red">Rojo</option>
										<option value="violet">Violeta</option>
										<option value="green">Verde</option>
									</select>
								</div>
								<input name="hadd" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
							
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="col-lg-4">
					<div class="panel border-1 border-blue-300">
						<div class="panel-title bg-blue-300">
							<div class="panel-head color-white"><i class="fa fa-bars"></i> Pestañas del Hotel</div>
						</div>
						<div class="panel-body" style="max-height:430px;display: block;overflow: auto;">
							<?php global $db;
								$result = $db->query("SELECT * FROM cms_header ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){
										echo '<li style="font-size:13px;">&#9758; '.$data['name'].' &#187; <div style="float:right;"><a href="'. HK .'/header.php?action=edit&id='.$data['id'].'"><b><i class="fa fa-pencil-square-o"></i> Editar</b></a> | <a href="'. HK .'/header.php?action=err&id='.$data['id'].'"><b><i class="fa fa-trash-o"></i> Borrar</b></a></div></li><hr>';
										unset($k);
									}
									echo '</ul>';
									
								}else{
									echo '<center><b style="color:red;">No hay Tabs creados</b></center>';
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