<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', 'Ajustes');
	$TplClass->SetParam('active1', active);
	$Functions->Logged("true");
	$TplClass->SetParam('HKLINK', '');


	$users = $db->query("SELECT rank FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	if($user['rank'] >= MINRANK){
		$TplClass->SetParam('HKLINK', '<a href='.HK.'>ACP</a>');
	}
	
	$TplClass->SetAll();

	if( $_SESSION['ERROR_RETURN'] ){
		$TplClass->SetParam('error', '<div class="alert alert-good alrt-dng" role="alert">&nbsp;&nbsp;<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.$_SESSION['ERROR_RETURN'].'</div> <br>');
		unset($_SESSION['ERROR_RETURN']);
	}
	
	if( $_SESSION['GOOD_RETURN'] ){
		$TplClass->SetParam('error', '<div class="alert alert-good alrt-dng" role="alert" style="background: #88B600;">&nbsp;&nbsp;<i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$_SESSION['GOOD_RETURN'].'</div> <br>');
		unset($_SESSION['GOOD_RETURN']);
	}
	
	$TplClass->AddTemplate("Header", "header");
	
//FUNCIONES DE LOS AJUSTES
	$tab  = "8";
	if($_GET['tab'] == "2"){
		$pagenum = "2";
		$pn = "Mi email";
		$png = "Cambia tu email";
	}elseif($_GET['tab'] == "3"){
		$pagenum = "3";
		$pn = "Mi contrase&ntilde;a";
		$png = "Cambia tu contrase&ntilde;a";
	}elseif($_GET['tab'] == "5"){
		$pagenum = "5";
		$pn = "Mi perfil";
		$png = "Configuración de tu Perfil";
	}elseif($_GET['tab'] == "4"){
		$pagenum = "4";
		$pg = "Vinculaci&oacute;n";
		$png = "Vincula tu cuenta!";
	}else{
		$pagenum = "1";
		$pn = "Mi Perfil";
		$png = "Cambiar tu perfil";
	}
	$page = $png;
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	if($pagenum == "2"){
		if(isset($_POST['save'])){
			$emaila = $Functions->FilterText($_POST['emaila']);
			$emailn = $Functions->FilterText($_POST['emailn']);
			$email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $emailn);
			if(empty($emaila) || empty($emailn)){
				$_SESSION['ERROR_RETURN'] = 'Rellena todos los campos';
				header("LOCATION: ". PATH ."/account/settings?tab=2&return");
			}elseif($emaila !== $Functions->Get('mail')){
				$_SESSION['ERROR_RETURN'] = 'El email que pusiste no es igual al actual';
				header("LOCATION: ". PATH ."/account/settings?tab=2&return");
			}elseif($Functions->ComprobateExist($emailn)){
				$_SESSION['ERROR_RETURN'] = 'Ese email ya esta en uso';
				header("LOCATION: ". PATH ."/account/settings?tab=2&return");
			}elseif($email_check !== 1){
				$_SESSION['ERROR_RETURN'] = 'Inserta un nuevo email v&aacute;lido';
				header("LOCATION: ". PATH ."/account/settings?tab=2&return");
			}else{
				$db->query("UPDATE users SET mail = '{$emailn}' WHERE id = '{$Functions->Get('id')}' LIMIT 1");													
				$_SESSION['GOOD_RETURN'] = 'Actualizado con &eacute;xito';
				header("LOCATION: ". PATH ."/account/settings?tab=2&return");
			}
		}
	}
	if($pagenum == "3"){
		if(isset($_POST['save'])){
			$pp = $Functions->FilterText($_POST['ppassword']);
			$pnp = $Functions->FilterText($_POST['pnpass']);
			$prp = $Functions->FilterText($_POST['pnrp']);
			$orpassword = $Functions->Hash($Functions->Get('username'), $pp);
			$newpassword = $Functions->Hash($Functions->Get('username'), $pnp);
			if($orpassword !== $Functions->Get('password')){
				$_SESSION['ERROR_RETURN'] = 'Tu contrase&ntilde;a actual no coincide';
				header("LOCATION: ". PATH ."/account/settings?tab=3&return");
			}else{
				if(strlen($pnp) < 6 || strlen($pnp) > 32){
				$_SESSION['ERROR_RETURN'] = 'Inserta una contraseña v&aacute;lida';
				header("LOCATION: ". PATH ."/account/settings?tab=3&return");
				}else{
					if($pnp !== $prp){
					$_SESSION['ERROR_RETURN'] = 'Las contrase&ntilde;as no son iguales';
					header("LOCATION: ". PATH ."/account/settings?tab=3&return");
					}else{
						$db->query("UPDATE users SET password = '{$newpassword}' WHERE id = '{$Functions->Get('id')}' LIMIT 1");
						$_SESSION['password'] = $newpassword;
						$_SESSION['GOOD_RETURN'] = 'Actualizado con &eacute;xito';
						header("LOCATION: ". PATH ."/account/settings?tab=3&return");
					}
				}
			}
		}
	}
	if($pagenum == "1"){
		if(isset($_POST['save'])){
			$m = $Functions->FilterText($_POST['motto']);
			$fr = $Functions->FilterText($_POST['friendRequestsAllowed']);
			if($fr){
				$fr = "0";
			}else{
				$fr = "1";
			}
			$so = $Functions->FilterText($_POST['showOnlineStatus']);
			if($so == "0"){
				$so = "0";
			}else{
				$so = "1";
			}
			$ff = $Functions->FilterText($_POST['followFriendMode']);
			if($ff == "1"){
				$ff = "0";
			}else{
				$ff = "1";
			}
			$db->query("UPDATE users SET block_newfriends = '{$fr}', motto = '{$m}', hide_online = '{$so}', hide_inroom = '{$ff}' WHERE id = '{$Functions->Get('id')}' LIMIT 1");
			$_SESSION['GOOD_RETURN'] = 'Actualizado con &eacute;xito';
			header("LOCATION: ". PATH ."/account/settings?tab=1&return");
		}
	}
	if($pagenum == "5"){
		if(isset($_POST['save'])){
			$fb = $Functions->FilterText($_POST['fb']);
			$tw = $Functions->FilterText($_POST['tw']);
			$ptd = $Functions->FilterText($_POST['ptd']);
			$prf = $Functions->FilterText($_POST['prf']);
			$vid = $Functions->FilterText($_POST['vid']);
			$addons = $Functions->FilterText($_POST['addons']);
			$db->query("UPDATE users  SET facebook = '{$fb}', cms_twitter = '{$tw}', cms_pbackground = '{$ptd}', cms_pprofile = '{$prf}', cms_video = '{$vid}', cms_style = '{$addons}' WHERE id = '{$Functions->Get('id')}' LIMIT 1");
			$_SESSION['GOOD_RETURN'] = 'Perfil Actualizado con &eacute;xito';
			header("LOCATION: ". PATH ."/account/settings?tab=5&return");
		}		
	}
//END FUNCIONES	
?>
<hr class="invisible">

	<div class="container">
		<div class="row">
		
		
		
		
			<div class="col-md-4">
				<h3 class="box-title">Ajustes</h3>
				<div class="box-content">
					<ul class="list-group list-group-flush p-x">
						<li class="list-group-item"><b style="margin-left: -35px;">&#9758;</b><b style="margin-left: 15px;"><a href="/account/settings?tab=1" class="light-link"> MIS AJUSTES</a></b></li>
						<li class="list-group-item"><b style="margin-left: -35px;">&#9758;</b><b style="margin-left: 15px;"><a href="/account/settings?tab=2" class="light-link"> EMAIL Y VERIFICACI&Oacute;N</a></b></li>
						<li class="list-group-item"><b style="margin-left: -35px;">&#9758;</b><b style="margin-left: 15px;"><a href="/account/settings?tab=3" class="light-link"> MI CONTRASE&Ntilde;A</a></b></li>
						<li class="list-group-item"><b style="margin-left: -35px;">&#9758;</b><b style="margin-left: 15px;"><a href="/account/settings?tab=5" class="light-link"> MI PERFIL</a></b></li>

						</ul>
				</div>
			</div>
			
			
			
			
			
			
			<?php if($pagenum == "3"){ ?>
			<div class="col-md-8">
<?php
//COLUMNA error	
	$TplClass->AddTemplate("Data", "error");
?>
				<h3 class="box-title">Cambia tu contrase&ntilde;a</h3>
				<form action="<?php echo PATH; ?>/account/settings?save=true&tab=3" method="post" id="profileForm">
                  <div class="box-content">
				  
				  <h5>Contrase&ntilde;a Actual:</h5>
					<div class="form-group has-icon-left form-control-password">
					
					<label class="sr-only" for="inputPass">Contrase&ntilde;a Actual</label>
					<input class="form-control form-control-lg" type="password" name="ppassword" size="32" maxlength="32" value="" id="avatarmotto" />
					</div>
					
					<h5>Nueva Contrase&ntilde;a:</h5>
					<div class="form-group has-icon-left form-control-password">
					<label class="sr-only" for="inputPass">Nueva Contrase&ntilde;a:</label>
					<input class="form-control form-control-lg" type="password" name="pnpass" size="32" maxlength="32" value="" id="avatarmotto" />
				</div><h5>Repite la nueva Contrase&ntilde;a:</h5>
                   <div class="form-group has-icon-left form-control-password">
					<label class="sr-only" for="inputPass">Repite la nueva Contrase&ntilde;a</label>
					<input class="form-control form-control-lg" type="password" name="pnrp" size="32" maxlength="32" value="" id="avatarmotto" />
				</div>
				<div class="form-group">
                            <button type="submit" name="save" id="accept_button" class="btn btn-success btn-block">Guardar cambios</button>
                        </div>
				</form>
				
				
			</div>
			<?php }?>
			
			
						
						
						
						
						<?php if($pagenum == "5"){ ?>
			<div class="col-md-8">
<?php
//COLUMNA error	
	$TplClass->AddTemplate("Data", "error");
?>
				<h3 class="box-title">Ajustes de Perfil</h3>
				<form action="<?php echo PATH; ?>/account/settings?save=true&tab=5" method="post" id="profileForm">
                  <div class="box-content">
				  
				  <h5>Facebook:</h5><h7>http://facebook.com/</h7>
					<div class="form-group">
					<label class="sr-only" for="inputPass">Facebook</label>
					<input class="form-control form-control-lg" type="text" name="fb" size="32" maxlength="32" value="<?php echo $Functions->Get('facebook'); ?>" id="avatarmotto" />
					</div>
					
					
									  
				  <h5>Twitter:</h5><h7>http://twitter.com/</h7>
					<div class="form-group ">
					<label class="sr-only" for="inputPass">Twitter</label>
					<input class="form-control form-control-lg" type="text" name="tw" size="32" maxlength="32" value="<?php echo $Functions->Get('cms_twitter'); ?>" id="avatarmotto" />
					</div>
					
					
					
				  
				  <h5>Imagen de Fondo:</h5><h7><a target="_blank" href="https://www.google.com.mx/search?q=habbo+home+backgrounds&es_sm=93&source=lnms&tbm=isch&sa=X&ved=0CAcQ_AUoAWoVChMI_ICg-ImHyAIVAzo-Ch35uwDL&biw=1440&bih=799" class="light-link">Sugerencias</a></h7>
					<div class="form-group ">
					<label class="sr-only" for="inputPass">Imagen de Fondo</label>
					<input class="form-control form-control-lg" type="text" name="ptd" size="32" maxlength="1000" value="<?php echo $Functions->Get('cms_pbackground'); ?>" id="avatarmotto" />
					</div>
					
					
					<h5>País:</h5>
					<div class="form-group ">
					<label class="sr-only" for="inputPass">País</label>
					<input class="form-control form-control-lg" type="text" name="vid" size="32" maxlength="32" value="<?php echo $Functions->Get('cms_video'); ?>" id="avatarmotto" />
					</div>
					
					
					<h5>Biografía:</h5>
					<div class="form-group ">
					<label class="sr-only" for="inputPass">Biografía</label>
					<input class="form-control form-control-lg" type="text" name="prf" size="32" maxlength="1000" value="<?php echo $Functions->Get('cms_pprofile'); ?>" id="avatarmotto" />
					</div>
				
				<div class="form-group">
                            <button type="submit" name="save" id="accept_button" class="btn btn-success btn-block">Guardar cambios</button>
                        </div>
				</form>
				
				
			</div>
			<?php }?>
			
			
			
								<?php if($pagenum == "2"){ ?>
			<div class="col-md-8">
<?php
//COLUMNA error	
	$TplClass->AddTemplate("Data", "error");
?>
				<h3 class="box-title">Cambiar Email</h3>
							<form action="<?php echo PATH; ?>/account/settings?save=true&tab=2" method="post" id="profileForm">
                  <div class="box-content">
				  
				  <h5>Email Actual:</h5>
					<div class="form-group">
					<label class="sr-only" for="inputPass">Email Actual</label>
					<input class="form-control form-control-lg" type="text" name="emaila" size="32" maxlength="32" value="<?php echo $Functions->Get('mail'); ?>" id="avatarmotto" />
					</div>
					
					
									  
				  <h5>Nuevo Email:</h5>
					<div class="form-group ">
					<label class="sr-only" for="inputPass">Nuevo Email</label>
					<input class="form-control form-control-lg" type="text" name="emailn" size="32" maxlength="32" value="" id="avatarmotto" />
					</div>
					

					<div class="form-group">
                            <button type="submit" name="save" id="accept_button" class="btn btn-success btn-block">Guardar cambios</button>
                        </div>
				</form>
				
				
			</div>
			<?php }?>	
			
			
			
			
											<?php if($pagenum == "1"){ ?>
			<div class="col-md-8">
<?php
//COLUMNA error	
	$TplClass->AddTemplate("Data", "error");
?>
				<h3 class="box-title">Mis ajustes</h3>
                  <div class="box-content">
				  
				  <form action="/functions.php" method="post">
				  <h5>Cambio de nombre</h5><h7>Este cambio solo lo podrás una vez, así que piensa bien el nuevo apodo</h7>
					<div class="form-group">
					<label class="sr-only" for="inputPass">Cambio de nombre</label>
					<input id="pin" class="form-control form-control-lg" type="text" name="changename" size="32" maxlength="32" value="" id="avatarmotto" />
					</div>
					<h7>Confirma con tu Contrase&ntilde;a:</h7>
					<div class="form-group has-icon-left form-control-password">
					<label class="sr-only" for="inputPass">Confirma con tu Contrase&ntilde;a</label>
					<input class="form-control form-control-lg" type="password" name="pnpass" size="32" maxlength="32" value="" />
					</div>
					<div class="form-group">
                            <button id="accept_button" type="submit" class="btn btn-success btn-block">Cambiar nombre</button>
                        </div>
					</form><hr>
									<form action="<?php echo PATH; ?>/account/settings?save=true&tab=1" method="post" id="profileForm">

									  
				  <h5>Mi estado:</h5><h7>Tu estado podr&aacute; ser visto por todos, &iexcl;pi&eacute;nsalo bien!</h7>
					<div class="form-group ">
					<label class="sr-only" for="inputPass">Estado</label>
					<input class="form-control form-control-lg" type="text" name="motto" size="32" maxlength="60" value="<?php echo $Functions->Get('motto'); ?>" id="avatarmotto" />
					</div><?php
									if($Functions->Get('hide_online') == "1"){ $c2 = ' checked="checked"'; $c2_ = ""; }else{ $c2_ = ' checked="checked"'; $c2 = ""; }
								?>
					<h5>Estado de la conexi&oacute;n</h5>
								<h7>Elige qui&eacute;n puede ver si est&aacute;s conectado:</h7><br>
									<label><input type="radio" name="showOnlineStatus" value="1"<?php echo $c2; ?>/>Nadie</label>
									<label><input type="radio" name="showOnlineStatus" value="0"<?php echo $c2_; ?>/>Todos</label><hr class="invisible">

									<h5>Ajustes 'S&iacute;gueme'</h5>
								<h7>Elige qui&eacute;n puede seguirte de una Sala a otra:</h7><br>
								<?php
										if($Functions->Get('hide_inroom') == "1"){ $c3 = ' checked="checked"'; $c3_ = ""; }else{ $c3_ = ' checked="checked"'; $c3 = ""; }
									?>
									<label><input type="radio" name="followFriendMode" value="0" <?php echo $c3; ?>/>Nadie</label>
									<label><input type="radio" name="followFriendMode" value="1" <?php echo $c3_; ?> />Mis Amigos</label>
								

					<div class="form-group">
                            <button type="submit" name="save" id="accept_button" class="btn btn-success btn-block">Guardar cambios</button>
                        </div>
				</form>
				
				
			</div>
			<?php }?>	
			
			
			
			
		</div>
	</div>

<?php
//COLUMNA FOOTER	
	$TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>
