<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', $_SESSION['username']);
	$TplClass->SetParam('active1', active);
	$Functions->Logged("true");
	$TplClass->SetParam('HKLINK', '');

	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	if($user['rank'] >= MINRANK){
		$TplClass->SetParam('HKLINK', '<a href='.HK.'>ACP</a>');
	}if(empty($getid)){
		$perfil = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
		$userhome = $perfil->fetch_array();
		$getid = $Functions->FilterText($userhome['id']);
	}else{
		$perfil = $db->query("SELECT * FROM users WHERE id = '{$getid}' LIMIT 1");
		$userhome = $perfil->fetch_array();
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
?>
			<hr class="invisible">

	<div class="container">
		<div class="row">
			<div class="col-md-12">	
<h3 class="box-title">¿Encontraste un problema?</h3>
				<div class="box-content">
			<?php	//COLUMNA error	
	$TplClass->AddTemplate("Data", "error");
	ob_end_flush(); 
?>
				<h7>Por favor, introduce de forma breve y concreta el error o inconforme:</h7>
<form method="post" action="/functions.php" id="forgotten-pw-form">									
										<tr>
											<td>
											<textarea class="form-control form-control-lg" type="text" id="change-password-email-address" name="BugReporter" maxlength="1000"></textarea>
											</td>
										</tr><br><center>
										<a href="/" class="btn btn-danger" style="margin-left: 1%;" id="change-password-cancel-link">Cancelar</a>
										<input class="btn btn-success" type="submit" id="change-password-cancel-link" value="Enviar" />
										</center></form>
											
					</div></div></div></div>
<?php
	$TplClass->AddTemplate("Data", "footer");
?>
