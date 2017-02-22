<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Subir Rares a la Tienda');
	$TplClass->SetParam('zone', 'Subir Rares a la Tienda');
	$Functions->LoggedHk("true");
	$Functions->LoggedHkADMIN("true");
	
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
	if(isset($_POST['subirrare'])){
		$code = $Functions->FilterText($_POST['code']);
		$name = $Functions->FilterText($_POST['name']);
		$price = $Functions->FilterText($_POST['price']);
		$repeat = $db->query("SELECT * FROM cms_rares WHERE code = '".$code."'");
		if(empty($_POST['code']) || empty($_POST['name']) || empty($_POST['price'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". HK ."/uprares.php");
		}elseif($repeat->num_rows > 0){
			$_SESSION['ERROR_RETURN'] = "Ya existe un rare con el mismo ID";
			header("LOCATION: ". HK ."/uprares.php");
		}else{
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Agregar Rare (Tienda)', 'Ha agregado el Rare ".$name." a ".$price." Diamantes', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			$db->query("INSERT INTO cms_rares (code, price, item_name) VALUES ('".$code."', '".$price."', '".$name."')");
			$_SESSION['GOOD_RETURN'] = "Rare agregado correctamente";
			header("LOCATION: ". HK ."/uprares.php");
		}
	}
	if($_POST['saverare']){
		if(isset($_POST['code']) && isset($_POST['name']) && isset($_POST['price'])){
			$code = $Functions->FilterText($_POST['code']);
			$name = $Functions->FilterText($_POST['name']);
			$price = $Functions->FilterText($_POST['price']);
			if(empty($_POST['code']) || empty($_POST['name']) || empty($_POST['price'])){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/uprares.php");
			}else{
				$db->query("UPDATE cms_rares SET code = '{$code}', price = '{$price}', item_name = '{$name}' WHERE id = '{$id}' LIMIT 1");	
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Editar un Rare', 'Ha editado el rare ".$name."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Rare editado correctamente";
				header("LOCATION: ". HK ."/uprares.php");			
			}
		}
	}
	if($do == "dele" && !empty($key)){
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Borrar Rare (Tienda)', 'Ha retirado un rare de la tienda', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_rares WHERE id = '{$key}' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Rare retirado correctamente";
		header("LOCATION: ". HK ."/uprares.php");					
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
			<?php global $db;
					if($action == "edit" && !empty($id)){ 
					$hj = $db->query("SELECT * FROM cms_rares WHERE id = '". $id ."'");
					$h_edit = $hj->fetch_array();		
				?>
				<div class="col-lg-6">
					<div class="panel border-1 border-pink-500">
						<div class="panel-title bg-pink-500">
							<div class="panel-head color-white"><i class="fa fa-plus"></i> Editar un Rare (<?php echo $h_edit['item_name']; ?>)</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para editar un Rare a la Tienda de la web</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Item_ID</label>
									<input type="text" class="form-control" id="input-text" name="code" placeholder="C&oacute;digo del item" value="<?php echo $h_edit['code']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Nombre de la Imagen (/gallery/images/tienda/rares/...)" value="<?php echo $h_edit['item_name']; ?>">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Precio</label>
									<input type="text" class="form-control" id="input-text" name="price" placeholder="Precio en Diamantes" value="<?php echo $h_edit['price']; ?>">
								</div>
								<img style="float:right" src="<?php echo CDN; ?>images/tienda/rares/<?php echo $h_edit['item_name']; ?>.gif" alt="image">
								<input name="saverare" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Editar">
							</form>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-lg-6">
					<div class="panel border-1 border-pink-500">
						<div class="panel-title bg-pink-500">
							<div class="panel-head color-white"><i class="fa fa-plus"></i> Agregar Rares</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para subir un Rare a la Tienda de la web</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Item_ID</label>
									<input type="text" class="form-control" id="input-text" name="code" placeholder="C&oacute;digo del item" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Nombre</label>
									<input type="text" class="form-control" id="input-text" name="name" placeholder="Nombre de la Imagen (/gallery/images/tienda/rares/...)" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Precio</label>
									<input type="text" class="form-control" id="input-text" name="price" placeholder="Precio en Diamantes" value="">
								</div>
								<input name="subirrare" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Agregar">
							</form>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="panel border-1 border-pink-500">
						<div class="panel-title bg-pink-500">
							<div class="panel-head color-white"><i class="fa fa-cart-arrow-down"></i> Rares en la Tienda</div>
						</div>
						<div class="panel-body no-border no-padding">
							<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 430px;">
								<ul class="media-list panel-scroll media-content media-striped" style="overflow: auto; width: 100%; height: 430px;">
									<?php global $db;
											$msg = $db->query("SELECT * FROM cms_rares");
											if($msg->num_rows > 0){
												while($mnsg = $msg->fetch_array()){ ?>
													<li class="media">
														<a class="pull-left" href="#">
															<img class="media-object  width-60 maxheight-60" src="<?php echo CDN; ?>images/tienda/rares/<?php echo $mnsg['item_name']; ?>.gif" alt="image">
														</a>
														<div class="media-body">
															<div class="clearfix">
																<a href="#" class="media-heading"><?php echo $mnsg['item_name']; ?></a>
															</div>
															<p class="box"><b><?php echo $mnsg['price']; ?></b> <img src="<?php echo CDN; ?>images/icons/crystal_offers.png" alt="image"></p>
														</div>
														<?php if($user['rank'] >= 9){ echo'<div class="media-footer"><div class="pull-right media-tools"><a href="'. HK .'/uprares.php?action=edit&id='.$mnsg['id'].'"><b><i class="fa fa-pencil-square-o"></i> Editar</b></a> <a href="'. HK .'/uprares.php?do=dele&key='.$mnsg['id'].'"><i class="fa fa-trash"></i> Eliminar</a></div></div>';} ?>
													</li>
									<?php } }else{echo "<center><b style='color:red;'><br>No hay Rares en la tienda</b></center>";}?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>