<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Subir Placas');
	$TplClass->SetParam('zone', 'Subir Placas');
	$Functions->LoggedHk("true");
	
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
	if(isset($_POST['guardar'])){ 
		$code = $Functions->FilterText($_POST['code']);
		$title = $Functions->FilterText($_POST['title']);
		$desc_b =$Functions->FilterText($_POST['desc_badge']);
		$nombrefoto1 = $_FILES['foto1']['name'];
		$ruta1 = $_FILES['foto1']['tmp_name'];
		if(empty($code) || empty($title) || empty($desc_b) || empty($nombrefoto1)){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/subir.php");
		}else{
			if(is_uploaded_file($ruta1)){ 
				if($_FILES['foto1']['type'] == 'image/gif'){
					$tips = 'gif';
					$type = array('image/gif' => 'gif');
					$name = $id.$nombrefoto1;
					$destino1 =  "../swf/c_images/album1584/".$name;//URL de tu carpeta album1584
					copy($ruta1,$destino1);
					
					$file = 'localhost/swf/gamedata/external_flash_texts.txt';//URL de tus external_flash_texts
					$fp = fopen($file, 'a');
					fwrite($fp, "\r\nbadge_name_".$code."=".$title."\r\n");
					fwrite($fp, "badge_desc_".$code."=".$desc_b);
					fclose($fp);
						
					$_SESSION['GOOD_RETURN'] = "Placa subida correctamente";
					header("LOCATION: ". HK ."/subir.php");
					
					$ruta_imagen = $destino1;
					$miniatura_ancho_maximo = 40;
					$miniatura_alto_maximo = 40;

					$info_imagen = getimagesize($ruta_imagen);
					$imagen_ancho = $info_imagen[0];
					$imagen_alto = $info_imagen[1];
					$imagen_tipo = $info_imagen['mime'];

					switch ( $imagen_tipo ){
					  case "image/gif":
						$imagen = imagecreatefromgif( $ruta_imagen );
						break;
					}
					$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
					imagefilledrectangle($lienzo, $imagesx());
					imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho_maximo, $miniatura_alto_maximo, $imagen_ancho, $imagen_alto);
					imagegif($lienzo, $destino1, 80);
				}else{
					$_SESSION['ERROR_RETURN'] = "Solo im&aacute;genes .GIF y de 40x40";
					header("LOCATION: ". HK ."/subir.php");
				}
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
					<div class="panel border-1 border-blue-500">
						<div class="panel-title bg-blue-500">
							<div class="panel-head color-white"><i class="fa fa-upload"></i> Subir una Placa</div>
						</div>
						<div class="panel-body">
							<form action="" method="post" enctype="multipart/form-data">
								<p class="text-light margin-bottom-20">Imagen GIF de 40x40 px</p>
								<div class="form-group">
									<label for="input-text" class="control-label">C&oacute;digo</label>
									<input type="text" class="form-control" id="input-text" name="code" placeholder="C&oacute;digo">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre o T&iacute;tulo</label>
									<input type="text" class="form-control" id="input-text" name="title" placeholder="Nombre de la Placa">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Descripci&oacute;n</label>
									<input type="text" class="form-control" id="input-text" name="desc_badge" placeholder="Descripci&oacute;n de la Placa">
								</div>
								<input class="btn btn-dark bg-light-blue-300 color-white margin-left-10" name="foto1" type="file" id="foto1" ><br>
								<input name="guardar" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Subir Placa">
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