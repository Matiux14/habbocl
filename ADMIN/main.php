<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Administraci&oacute;n');
	$TplClass->SetParam('zone', 'Bienvenido');
	$Functions->LoggedHk("true");
	
	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	
	$a = $db->query("SELECT * FROM users WHERE rank >= 3");
	$cntranks = $a->num_rows;
	
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
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="panel bg-teal-500">
						<div class="panel-body padding-15-20">
							<div class="clearfix">
								<div class="pull-left">
									<div class="color-white font-size-26 font-roboto font-weight-600" data-toggle="counter" data-start="0" data-from="0" data-to="1230" data-speed="500" data-refresh-interval="10"><?php echo $Functions->GetCount('users'); ?></div>
									<div class="display-block color-teal-50 font-weight-600"><i class="fa fa-plus"></i> USUARIOS REGISTRADOS</div>
								</div>
								<div class="pull-right">
									<i class="font-size-36 color-teal-100 fa fa-user-plus"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
							
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="panel bg-green-400">
						<div class="panel-body padding-15-20">
							<div class="clearfix">
								<div class="pull-left">
									<div class="color-white font-size-26 font-roboto font-weight-600" data-toggle="counter" data-start="0" data-from="0" data-to="5613" data-speed="500" data-refresh-interval="10"><?php echo $Functions->GetOns(); ?></div>
									<div class="display-block color-green-50 font-weight-600"><i class="fa fa-plus"></i> USUARIOS ONLINE</div>
								</div>
								<div class="pull-right">
									<i class="font-size-36 color-green-100 fa fa-users"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
							
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="panel bg-red-400">
						<div class="panel-body padding-15-20">
							<div class="clearfix">
								<div class="pull-left">
									<div class="color-white font-size-26 font-roboto font-weight-600" data-toggle="counter" data-start="0" data-from="0" data-to="343" data-speed="500" data-refresh-interval="10"><?php echo $Functions->GetCount('bans'); ?></div>
									<div class="display-block color-red-50 font-weight-600"><i class="fa fa-plus"></i> USUARIOS BANEADOS</div>
								</div>
								<div class="pull-right">
									<i class="font-size-36 color-red-100 fa fa-user-times"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
							
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="panel bg-blue-400">
						<div class="panel-body padding-15-20">
							<div class="clearfix">
								<div class="pull-left">
									<div class="color-white font-size-26 font-roboto font-weight-600" data-toggle="counter" data-start="0" data-from="0" data-to="343" data-speed="500" data-refresh-interval="10"><?php echo $cntranks; ?></div>
									<div class="display-block color-blue-50 font-weight-600"><i class="fa fa-plus"></i> USUARIOS CON RANGO</div>
								</div>
								<div class="pull-right">
									<i class="font-size-36 color-blue-100 fa fa-user"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="panel">
						<div class="panel-title">
							<div class="panel-head"><i class="fa fa-info-circle"></i> Informaci&oacute;n</div>
						</div>
						<div class="panel-body" style="padding:10px;width:100%;">
							<p style="text-align:justify">
								<img src="<?php echo CDN; ?>/images/index/frank2.gif" style="float:right;">
								Bienvenido al nuevo Panel de Administraci&oacute;n de YeezyCMS. Este panel est&aacute; 
								complementado para configurar y personalizar el sistema y el interno del hotel. 
								Cada acci&oacute;n es este panel ser&aacute; monitoreada y guardada en los LOGS, que 
								pueden ser revisados unicamente por los administradores. Recomendamos no hacer ningun 
								da&ntilde;o al hotel o se aplicar&aacute;n medidas dr&aacute;sticas. 
							</p>
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