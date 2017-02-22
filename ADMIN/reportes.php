<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Reportes');
	$TplClass->SetParam('zone', 'Reportes');
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
	if($do == "dele" && !empty($key)){
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Borrar Reportes', 'Ha borrado un Reporte', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_comments WHERE id = '{$key}' && type = 'bug' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Reporte borrado correctamente";
		header("LOCATION: ". HK ."/reportes.php");					
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
					<div class="panel border-1 border-red-500">
						<div class="panel-title bg-red-500">
							<div class="panel-head color-white"><i class="fa fa-bug"></i> Reportes</div>
						</div>
						<div class="panel-body no-border no-padding">
							<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 430px;">
								<ul class="media-list panel-scroll media-content media-striped" style="overflow: auto; width: 100%; height: 430px;">
									<?php global $db;
										$msg = $db->query("SELECT * FROM cms_comments  WHERE type = 'bug'");
										if($msg->num_rows > 0){
											while($mnsg = $msg->fetch_array()){
												$userreporter = $db->query("SELECT * FROM users  WHERE username = '{$mnsg['username']}' LIMIT 1");
												while($infouser = $userreporter->fetch_array()){?>
													<li class="media">
														<a class="pull-left" href="#">
															<img class="media-object img-circle width-60 height-60" src="/yezz/images/dftl_perfil.png" alt="image">
														</a>
														<div class="media-body">
															<div class="clearfix">
																<a href="#" class="media-heading"><?php echo $mnsg['username']; ?></a>
																<span class="media-item"><?php echo $mnsg['posted_on']; ?></span>
															</div>
															<p class="box"><?php echo $mnsg['comentario']; ?></p>
														</div>
														<?php if($user['rank'] >= 9){ echo'<div class="media-footer"><div class="pull-right media-tools"><a href="'. HK .'/reportes.php?do=dele&key='.$mnsg['id'].'"><i class="fa fa-check-circle"></i> Dar por Resuelto</a></div></div>';}?>
													</li>
									<?php 		} 
											} 
										}else{echo "<center><b style='color:red;'><br>No hay Reportes</b></center>";}?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
					<?php require_once 'templates/facebook.tpl'; ?>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>