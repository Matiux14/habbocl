<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Baneos');
	$TplClass->SetParam('zone', 'Banear');
	$Functions->LoggedHk("true");
	
	$users = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	$user = $users->fetch_array();
	$action = $Functions->FilterText($_GET['action']);
	$id = $Functions->FilterText($_GET['id']);
	
	if($user['rank'] <= 7){
		$_SESSION['ERROR_RETURN'] = "Herramienta solo para cargos altos";
		header("LOCATION: ". HK ."/");
		exit;
	}

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
	$data = $result->fetch_array();
	$SHORTNAME = $data['hotelname'];
	$FACE = $data['facebook'];
	$LOGO = $data['logo'];
	if($_POST['addban']){
		$check = $db->query("SELECT * FROM users WHERE username = '".$Functions->FilterText($_POST['user'])."' LIMIT 1");
		$row = $check->fetch_array();
		$checkb = $db->query("SELECT * FROM bans WHERE value = '".$Functions->FilterText($_POST['user'])."' || '".$Functions->FilterText($row['ip_last'])."' LIMIT 1");
		$actv = $checkb->fetch_array();
		if(isset($_POST['user']) && isset($_POST['time']) && isset($_POST['tipo']) && isset($_POST['razon'])){
			$time = $Functions->FilterText($_POST['time']);
			$razon = $Functions->FilterText($_POST['razon']);
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/bans.php");
			}else{
				if($actv['expire'] > time()){
					$_SESSION['ERROR_RETURN'] = "El usuario ya se encuentra Baneado";
					header("LOCATION: ". HK ."/bans.php");
				}else{
					if($check->num_rows > 0){
						$db->query("DELETE FROM bans WHERE value = '".$Functions->FilterText($_POST['user'])."' || '".$Functions->FilterText($row['ip_last'])."' LIMIT 1");
						if($row['rank'] >= $Functions->Get('rank')){
							$_SESSION['ERROR_RETURN'] = "No puedes banear a un superior o a ti mismo";
							header("LOCATION: ". HK ."/bans.php");
						}else{
							$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Baneos', 'Baneo a ". $row['username'] .", Raz&oacute;n: ".$razon."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
							if($_POST['tipo'] == "2"){
								$banuuu = $row['ip_last'];
								$baneee = "machine";
							}else{
								$banuuu = $Functions->FilterText($_POST['user']);
								$baneee = "user";
							}	
							$dbAdd= array();
							$dbAdd['id'] = NULL;
							$dbAdd['bantype'] = $baneee;
							$dbAdd['value'] = $banuuu;
							$dbAdd['reason'] = $razon;
							$dbAdd['expire'] = time() + $time;
							$dbAdd['added_by'] = $_SESSION['username'];
							$dbAdd['added_date'] = time();
							$query = $db->insertInto('bans', $dbAdd);
							//$db->query("INSERT INTO bans_access (user_id, ip, attempts) VALUES ('". $row['id'] ."', '". $row['ip_last'] ."', '1')");
							$_SESSION['GOOD_RETURN'] = "Usuario Baneado correctamente";
							header("LOCATION: ". HK ."/bans.php");		
						}
					}else{
						$_SESSION['ERROR_RETURN'] = "No puedes banear a este usuario";
						header("LOCATION: ". HK ."/bans.php");	
					
					}
				}
			}
		}
	if($action == "err" && !empty($id)){
			$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Desbaneos', 'Ha desbaneado a un usuario', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
			$db->query("DELETE FROM bans WHERE id = '{$id}' LIMIT 1");
			$_SESSION['GOOD_RETURN'] = "Baneo borrado correctamente";
				header("LOCATION: ". HK ."/bans.php");						
	}
	$TplClass->AddTemplateHK("templates", "header");
	ob_end_flush(); 
?>
	<html>
		<body>
			<div class="row">
			<div class="col-lg-12">
					<div class="panel border-1 border-red-300">
						<div class="panel-title bg-red-300">
							<div class="panel-head color-white"><i class="fa fa-user-times"></i> Baneos del Hotel</div>
						</div>
						<div class="panel-body" style="padding:3px;max-height:800px;display: block;overflow: auto;">
							<table border="1" style="width:100%">
								  <tr>
									<th style="padding:3px;"><center>Usuario</center></th>
									<th style="padding:3px;"><center>Estado</center></th> 
									<th style="padding:3px;"><center>Raz&oacute;n</center></th>
									<th style="padding:3px;"><center>Baneado por</center></th>
									<th style="padding:3px;"><center>IP</center></th>
									<th style="padding:3px;"><center>Desde</center></th>
									<th style="padding:3px;"><center>Hasta</center></th>
									<th style="padding:3px;"><center>IP-Ban</center></th>
									<th style="padding:3px;"><center>Quitar Ban</center></th>
								  </tr>
								<tbody>
									<?php global $db;	
										$get_bans = $db->query("SELECT * FROM bans ORDER BY id DESC");
										if($get_bans->num_rows > 0){
											while($row = $get_bans->fetch_array()){
												if($row['bantype'] == 'user'){
													$userdata = $db->query("SELECT * FROM users WHERE username = '".$row['value']."'");
													$users = $userdata->fetch_array();
													$ip_last = $users['ip_last'];
													$ip = 'No';
												}else{
													$ip_last = $row['value'];
													$ip = 'S&iacute;';
												}
												$minuten = $row['expire'] - time();
												if(time() >= $row['expire']){
													$stat = "Expirado";
													$color="green";
												}elseif(time() + 3600 >= $row['expire']){
													if(date('i', $minuten) > 0){
														$stat = "(Le restan ".date('i', $minuten)." minutos)";
														$color="red";
													}else{
														$stat = "(Le restan ".date('s', $minuten)." segundos)";
														$color="red";
													} 
												}else{
													$stat = "Activo";
													$color="red";
												} ?>
									<tr>
										<td style="width:10%;padding:3px;"><center><?php echo $row['value']; ?></center></td>
										<td style="width:8%;padding:3px;"><center><b style="color:<?php echo $color; ?>"><?php echo $stat; ?></b></center></td>
										<td style="width:20%;padding:3px;"><center><?php echo $row['reason']; ?></center></td>
										<td style="width:10%;padding:3px;"><center><?php echo $row['added_by']; ?></center></td>
										<td style="width:12%;padding:3px;"><center><?php echo $ip_last; ?></center></td>
										<td style="padding:3px;"><center><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $row['added_date'])); ?></center></td>
										<td style="padding:3px;"><center><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $row['expire'])); ?></center></td>
										<td style="width:3%;padding:3px;"><center><?php echo $ip; ?></center></td>
										<td style="width:3%;padding:3px;"><center><a href="<?php echo HK; ?>/bans.php?action=err&id=<?php echo $row['id']; ?>"><img src="<?php echo CDN; ?>/images/icons/del.gif"></a></center></td>
									</tr>
											<?php } }else{ echo "<center><b style='color:red;'>No hay usuarios baneados</b></center>"; }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel border-1 border-red-500">
						<div class="panel-title bg-red-500">
							<div class="panel-head color-white"><i class="fa fa-user-times"></i> Banea un Usuario</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<p class="text-light margin-bottom-20">Rellena todos los campos para agregar un Baneo</p>
								<div class="form-group">
									<label for="input-text" class="control-label">Usuario</label>
									<input type="text" class="form-control" id="input-text" name="user" placeholder="Usuario a Banear" value="">
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Duraci&oacute;n</label>
									<script type="text/javascript">function banPreset(val){document.getElementById('banlength').value = val;}</script>
									<input type="text" name="time" id="banlength" class="form-control" value="" placeholder="Tiempo en segundos"><br />
									<small>
										<a href="#addban" onclick="banPreset(3600);">1 hora,</a>
										<a href="#addban" onclick="banPreset(7200);">2 horas,</a>
										<a href="#addban" onclick="banPreset(10800);">3 horas,</a> 
										<a href="#addban" onclick="banPreset(14400);">4 horas,</a>
										<a href="#addban" onclick="banPreset(43200);">12 horas,<br><br></a> 
										<a href="#addban" onclick="banPreset(86400);">1 dia,</a> 
										<a href="#addban" onclick="banPreset(259200);">3 dias,<br><br></a> 
										<a href="#addban" onclick="banPreset(604800);">1 semana,</a> 
										<a href="#addban" onclick="banPreset(1209600);">2 semanas,<br><br></a> 
										<a href="#addban" onclick="banPreset(2592000);">1 mes,</a> 
										<a href="#addban" onclick="banPreset(7776000);">3 meses,<br><br></a> 
										<a href="#addban" onclick="banPreset(1314000);">1 a&ntilde;o,</a> 
										<a href="#addban" onclick="banPreset(2628000);">2 a&ntilde;os,</a> 
										<a href="#addban" onclick="banPreset(360000000);">> 10 a&ntilde;os</a>
									</small>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Banear por IP o User</label>
									<br><select class="form-control"name="tipo">
										<option value="1">Banear por nombre</option>
										<option value="2">Banear tambi&eacute;n por IP</option>
									</select>
								</div>
								<div class="form-group">
									<label for="input-text" class="control-label">Raz&oacute;n</label>
									<input type="text" class="form-control" id="input-text" name="razon" placeholder="Raz&oacute;n del Baneo" value="">
								</div>
								<input name="addban" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-10" value="Banear">
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