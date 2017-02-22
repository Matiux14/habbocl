<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Promos');
	$TplClass->SetParam('zone', 'Promos');
	$Functions->LoggedHk("true");
	
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
	if($_POST['addpromo']){
		if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['longcontent']) && isset($_POST['image'])){
			$title = $Functions->FilterText($_POST['title']);
			$content = $_POST['content'];
			$longcontent = $_POST['longcontent'];
			$image = $Functions->FilterText($_POST['image']);
			if(empty($title) || empty($image) || empty($content)){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/promos.php");
			}else{
				$dbQuery= array();
				$dbQuery['title'] = $title;
				$dbQuery['story'] = $content;
				$dbQuery['longstory'] = $longcontent;
				$dbQuery['image'] = $image;
				$dbQuery['author'] = $_SESSION['username'];
				$dbQuery['time'] = time();
				$query = $db->insertInto('cms_slider', $dbQuery);
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Promos', 'Ha creado el Promo ".$title."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Promo creado correctamente";
				header("LOCATION: ". HK ."/promos.php");
			}
		}
	}
	if($_POST['editpromo']){
		if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['longcontent']) && isset($_POST['image'])){
			$title = $Functions->FilterText($_POST['title']);
			$content = $_POST['content'];
			$longcontent = $_POST['longcontent'];
			$image = $Functions->FilterText($_POST['image']);
			if(empty($_POST['title']) || empty($_POST['content']) || empty($_POST['image'])){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/promos.php");
			}else{
				$db->query("UPDATE cms_slider SET title = '{$title}', story = '{$content}', image = '{$image}', longstory = '{$longcontent}', author = '{$_SESSION['username']}', time = '".time()."' WHERE id = '{$id}' LIMIT 1");	
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Promos', 'Ha editado el Promo ".$title."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Promo editado correctamente";
				header("LOCATION: ". HK ."/promos.php");
			}				
		}
	}
	if($action == "err" && !empty($id)){
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Promos', 'Ha borrado un Promo', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			$db->query("DELETE FROM cms_slider WHERE id = '{$id}' LIMIT 1");
			$_SESSION['GOOD_RETURN'] = "Promo borrado correctamente";
			header("LOCATION: ". HK ."/promos.php");						
	}
	
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<?php global $db;
					if($action == "edit" && !empty($id)){ 
					$hj = $db->query("SELECT * FROM cms_slider WHERE id = '". $id ."'");
					$h_edit = $hj->fetch_array();		
				?>
				<div class="col-lg-6">
					<div class="panel border-1 border-blue-500">
						<div class="panel-title bg-blue-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Editar un Promo (ID <?php echo $h_edit['id']; ?>)</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para agregar un Promo</p>
								<div class="form-group">
									<label for="input-text" class="control-label">T&iacute;tulo</label>
									<input type="text" class="form-control" id="input-text" name="title" placeholder="T&iacute;tulo de la noticia" value="<?php echo $h_edit['title']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Descripci&oacute;n</label>
									<input type="text" class="form-control" id="input-text" name="content" placeholder="De qué habla la noticia" value="<?php echo $h_edit['story']; ?>">
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
									<textarea name="longcontent" style="width:100%"><?php echo $h_edit['longstory']; ?></textarea>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Imagen</label>
									<input type="text" class="form-control" id="input-text" name="image" placeholder="Imagen de 160x60 px" value="<?php echo $h_edit['image']; ?>">
								</div>
								<input name="editpromo" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-lg-6">
					<div class="panel border-1 border-blue-500">
						<div class="panel-title bg-blue-500">
							<div class="panel-head color-white"><i class="fa fa-plus-square"></i> Crear un Promo</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para agregar un Promo</p>
								<div class="form-group">
									<label for="input-text" class="control-label">T&iacute;tulo</label>
									<input type="text" class="form-control" id="input-text" name="title" placeholder="T&iacute;tulo de la noticia">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Descripci&oacute;n</label>
									<input type="text" class="form-control" id="input-text" name="content" placeholder="De qué habla la noticia">
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
									<textarea name="longcontent" style="width:100%"></textarea>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Imagen</label>
									<input type="text" class="form-control" id="input-text" name="image" placeholder="Imagen de 160x60 px">
								</div>
								<input name="addpromo" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Guardar">
							</form>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="col-lg-4">
					<div class="panel border-1 border-blue-300">
						<div class="panel-title bg-blue-300">
							<div class="panel-head color-white"><i class="fa fa-bars"></i> Promos del Hotel</div>
						</div>
						<div class="panel-body" style="max-height:800px;display: block;overflow: auto;">
							<?php global $db;
								$result = $db->query("SELECT * FROM cms_slider ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){
										echo '<li style="font-size:13px;">&#9758; '.$data['title'].' &#187; <div style="float:right;"><a href="'. HK .'/promos.php?action=edit&id='.$data['id'].'"><b><i class="fa fa-pencil-square-o"></i> Editar</b></a> | <a href="'. HK .'/promos.php?action=err&id='.$data['id'].'"><b><i class="fa fa-trash-o"></i> Borrar</b></a></div></li><p><b>Autor:</b> '.$data['author'].'<hr>';
										unset($k);
									}
									echo '</ul>';
									
								}else{
									echo '<b style="color:red;">No hay Promos creados</i>';
								}
							?>
						</div>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="panel border-1 border-blue-200">
						<div class="panel-title bg-blue-200">
							<div class="panel-head color-white"><i class="fa fa-bars"></i> Im&aacute;genes</div>
						</div>
						<div class="panel-body" style="max-height:800px;display: block;overflow: auto;">
							<p class="text-light text-center margin-bottom-20">Arrastra la imagen al campo 'Imagen'</p>
							<img src="<?php echo CDN;?>images/me/news/promos/1.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/2.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/3.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/4.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/5.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/6.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/7.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/8.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/9.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/10.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/11.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/12.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/13.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/14.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/15.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/16.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/17.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/18.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/19.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/20.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/21.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/22.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/23.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/24.png" style="height:50px; widht:80px;" >
							<img src="<?php echo CDN;?>images/me/news/promos/25.png" style="height:50px; widht:80px;" >
						</div>
					</div>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>