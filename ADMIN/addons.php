<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Addons');
	$TplClass->SetParam('zone', 'Addons');
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
	if($_POST['addadd']){
		if(isset($_POST['title']) && isset($_POST['phps']) && isset($_POST['content']) && isset($_POST['type']) && isset($_POST['color']) && isset($_POST['visible']) && isset($_POST['pos']) && isset($_POST['local'])){
			$title = $Functions->FilterText($_POST['title']);
			$phps = $Functions->FilterText($_POST['phps']);
			$content = $_POST['content'];
			$type = $Functions->FilterText($_POST['type']);
			$color = $Functions->FilterText($_POST['color']);
			$visible = $Functions->FilterText($_POST['visible']);
			$pos = $Functions->FilterText($_POST['pos']);
			$local = $Functions->FilterText($_POST['local']);
			if(empty($title) || empty($type) || empty($color) || empty($visible) || empty($pos) || empty($local)){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/addons.php");
			}else{
				$dbQuery= array();
				$dbQuery['title'] = $title;
				$dbQuery['content'] = $content;
				$dbQuery['contentPHP'] = $phps;
				$dbQuery['type'] = $type;
				$dbQuery['color'] = $color;
				$dbQuery['visible'] = $visible;
				$dbQuery['position'] = $pos;
				$dbQuery['zone'] = $local;
				$query = $db->insertInto('cms_addons', $dbQuery);
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha agregado el Addon ".$title."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Addon agregado correctamente";
				header("LOCATION: ". HK ."/addons.php");
			}
		}
	}
	if($_POST['addedit']){
		if(isset($_POST['title']) && isset($_POST['phps']) && isset($_POST['content']) && isset($_POST['type']) && isset($_POST['color']) && isset($_POST['visible']) && isset($_POST['pos']) && isset($_POST['local'])){
			$title = $Functions->FilterText($_POST['title']);
			$phps = $Functions->FilterText($_POST['phps']);
			$content = $_POST['content'];
			$type = $Functions->FilterText($_POST['type']);
			$color = $Functions->FilterText($_POST['color']);
			$visible = $Functions->FilterText($_POST['visible']);
			$pos = $Functions->FilterText($_POST['pos']);
			$local = $Functions->FilterText($_POST['local']);
			if(empty($title) || empty($content) || empty($type) || empty($color) || empty($pos) || empty($local)){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/addons.php");
			}else{
				$db->query("UPDATE cms_addons SET title = '{$title}', content = '{$content}', contentPHP = '{$phps}', type = '{$type}', color = '{$color}', visible = '{$visible}', position = '{$pos}', zone = '{$local}' WHERE id = '{$id}' LIMIT 1");	
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha editado el addon ".$title."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Addon editado correctamente";
				header("LOCATION: ". HK ."/addons.php");	
			}
		}
	}
	if($action == "err" && !empty($id)){
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Modificaci&oacute;n del Hotel', 'Ha borrado un addon', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_addons WHERE id = '{$id}' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Addon borrado correctamente";
		header("LOCATION: ". HK ."/addons.php");						
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<?php global $db;
					if($action == "edit" && !empty($id)){ 
					$hj = $db->query("SELECT * FROM cms_addons WHERE id = '". $id ."'");
					$h_edit = $hj->fetch_array();		
				?>
				<div class="col-lg-6">
					<div class="panel border-1 border-orange-500">
						<div class="panel-title bg-orange-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Edita un Addon (ID: <?php echo $id; ?>)</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para editar un Addon</p>
								<div class="form-group">
									<label for="input-text" class="control-label">T&iacute;tulo</label>
									<input type="text" class="form-control" id="input-text" name="title" value="<?php echo $h_edit['title']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Usar PHP</label><p><i style="font-size:11px;">NOTA: Si usas PHP tendr&aacute;s que crear un archivo en /Files/Data con tu contenido. Al hacer esto; el bloque "Contenido" no tendr&aacute; funcionalidad.</i>
									<br><select name="phps" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="<?php echo $h_edit['contentPHP']; ?>" selected>Usuar PHP</option>
										<option value="0">No</option>
										<option value="1">S&iacute;</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Contenido</label>
									<script type="text/javascript" src="http://tinymce.cachefly.net/4.2/tinymce.min.js"></script>
									<script type="text/javascript">
									tinymce.init({
										selector: "textarea",
										plugins: [
											"advlist autolink lists link image charmap print preview anchor",
											"searchreplace visualblocks code fullscreen",
											"insertdatetime media table contextmenu paste"
										],
										toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
									});
									</script>
									<textarea name="content" style="width:100%"><?php echo $h_edit['content']; ?></textarea>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Tipo</label><p><i style="font-size:11px;">NOTA: Addon = Diseño de addon por defecto. | Custom = T&uacute; diseñas el addon (usando < style >)</i>
									<br><select name="type" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="<?php echo $h_edit['type']; ?>" selected>Tipo</option>
										<option value="addon">Addon</option>
										<option value="custom">Custom</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Color</label>
									<br><select name="color" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="<?php echo $h_edit['color']; ?>" selected>Color</option>
										<option value="blue">Azul</option>
										<option value="white">Blanco</option>
										<option value="brown">Caf&eacute;</option>
										<option value="lime">Lima</option>
										<option value="green">Verde</option>
										<option value="red">Rojo</option>
										<option value="yellow">Amarillo</option>
										<option value="violet">Violeta</option>
										<option value="pink">Rosa</option>
										<option value="orange">Naranja</option>
										<option value="light_blue">Celeste</option>
									</select>
								</div>
								<div class="form-group" style="text-align:center;margin-top:-73px;">
									<label for="input-text" class="control-label">Visible</label>
									<br><select name="visible" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="<?php echo $h_edit['visible']; ?>" selected>Visible</option>
										<option value="1">S&iacute;</option>
										<option value="0">No</option>
									</select>
								</div>
								<div class="form-group" style="float:right;margin-top:-75px;">
									<label for="input-text" class="control-label">Posici&oacute;n</label>
									<br><select name="pos" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="<?php echo $h_edit['position']; ?>" selected>Posici&oacute;n</option>
										<option value="left">Izquierda</option>
										<option value="right">Derecha</option>
										<option value="center">Centrado</option>
										<option value="column-3">Tercera Columna</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Localizaci&oacute;n:</label>
									<select name="local" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="<?php echo $h_edit['zone']; ?>" selected>Pag. donde mostrarse</option>
										<?php global $db;
											$result = $db->query("SELECT * FROM cms_navi ORDER BY id DESC");
											if($result->num_rows > 0){
												while($data = $result->fetch_array()){
													echo '<option value="'.$data['zone'].'">'.$data['zone'].'</option>';
												}
											}else{
												echo '<option>No hay Tabs Creados</option>';
											}
										?>
									</select>
								</div>
								<input name="addedit" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-lg-6">
					<div class="panel border-1 border-orange-500">
						<div class="panel-title bg-orange-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Agrega un Addon</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para insertar un Addon</p>
								<div class="form-group">
									<label for="input-text" class="control-label">T&iacute;tulo</label>
									<input type="text" class="form-control" id="input-text" name="title" placeholder="T&iacute;tulo del Addon">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Usar PHP</label><p><i style="font-size:11px;">NOTA: Si usas PHP tendr&aacute;s que crear un archivo en /Files/Data con tu contenido. Al hacer esto; el bloque "Contenido" no tendr&aacute; funcionalidad.</i>
									<br><select name="phps" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="0" selected>No</option>
										<option value="1">S&iacute;</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Contenido</label>
									<script type="text/javascript" src="http://tinymce.cachefly.net/4.2/tinymce.min.js"></script>
									<script type="text/javascript">
									tinymce.init({
										selector: "textarea",
										plugins: [
											"advlist autolink lists link image charmap print preview anchor",
											"searchreplace visualblocks code fullscreen",
											"insertdatetime media table contextmenu paste"
										],
										toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
									});
									</script>
									<textarea name="content" style="width:100%"></textarea>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Tipo</label><p><i style="font-size:11px;">NOTA: Addon = Diseño de addon por defecto. | Custom = T&uacute; diseñas el addon (usando < style >)</i>
									<br><select name="type" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option selected>Tipo</option>
										<option value="addon">Addon</option>
										<option value="custom">Custom</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Color</label>
									<br><select name="color" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option selected>Color</option>
										<option value="blue">Azul</option>
										<option value="white">Blanco</option>
										<option value="brown">Caf&eacute;</option>
										<option value="lime">Lima</option>
										<option value="green">Verde</option>
										<option value="red">Rojo</option>
										<option value="yellow">Amarillo</option>
										<option value="violet">Violeta</option>
										<option value="pink">Rosa</option>
										<option value="orange">Naranja</option>
										<option value="light_blue">Celeste</option>
									</select>
								</div>
								<div class="form-group" style="text-align:center;margin-top:-73px;">
									<label for="input-text" class="control-label">Visible</label>
									<br><select name="visible" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option value="1" selected>Visible</option>
										<option value="1">S&iacute;</option>
										<option value="0">No</option>
									</select>
								</div>
								<div class="form-group" style="float:right;margin-top:-75px;">
									<label for="input-text" class="control-label">Posici&oacute;n</label>
									<br><select name="pos" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option selected>Posici&oacute;n</option>
										<option value="left">Izquierda</option>
										<option value="right">Derecha</option>
										<option value="center">Centrado</option>
										<option value="column-3">Tercera Columna</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Localizaci&oacute;n:</label>
									<select name="local" style="padding:5px;border-radius:2px;border-color:#EEEEEE;">
										<option selected>Pag. donde mostrarse</option>
										<?php global $db;
											$result = $db->query("SELECT * FROM cms_navi ORDER BY id DESC");
											if($result->num_rows > 0){
												while($data = $result->fetch_array()){
													echo '<option value="'.$data['zone'].'">'.$data['zone'].'</option>';
												}
											}else{
												echo '<option>No hay Tabs Creados</option>';
											}
										?>
									</select>
								</div>
								<input name="addadd" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
						<?php } ?>
				<div class="col-lg-4">
					<div class="panel border-1 border-orange-300">
						<div class="panel-title bg-orange-300">
							<div class="panel-head color-white"><i class="fa fa-bars"></i> Addons del Hotel</div>
						</div>
						<div class="panel-body" style="max-height:800px;display: block;overflow: auto;">
							<?php global $db;
								$result = $db->query("SELECT * FROM cms_addons ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){
										echo '<li style="font-size:13px;">&#9758; '.$data['title'].' &#187; <div style="float:right;"><a href="'. HK .'/addons.php?action=edit&id='.$data['id'].'"><b><i class="fa fa-pencil-square-o"></i> Editar</b></a> | <a href="'. HK .'/addons.php?action=err&id='.$data['id'].'"><b><i class="fa fa-trash-o"></i> Borrar</b></a></div></li><p><b>Ubicado en:</b> '.$data['zone'].'<hr>';
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
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>