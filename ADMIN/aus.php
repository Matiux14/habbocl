<?php
ob_start();
	require_once '../global.php';
	$TplClass->SetParam('title', 'Ausencias del Equipo');
	$TplClass->SetParam('zone', 'Ausencias del Equipo');
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
	if($_POST['ausentarme']){
		if(isset($_POST['dia']) && isset($_POST['mes']) && isset($_POST['ano']) && isset($_POST['dia2']) && isset($_POST['mes2']) && isset($_POST['ano2']) && isset($_POST['motivo'])){
			$dia = $Functions->FilterText($_POST['dia']);
			$mes = $Functions->FilterText($_POST['mes']);
			$ano = $Functions->FilterText($_POST['ano']);
			$dia2 = $Functions->FilterText($_POST['dia2']);
			$mes2 = $Functions->FilterText($_POST['mes2']);
			$ano2 = $Functions->FilterText($_POST['ano2']);
			$motivo = $Functions->FilterText($_POST['motivo']);
			if(empty($dia) || empty($mes) || empty($ano) || empty($dia2) || empty($mes2) || empty($ano2) || empty($motivo)){
				$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
				header("LOCATION: ". HK ."/aus.php");
			}else{
				$dbQuery= array();
				$dbQuery['username'] = $_SESSION['username'];
				$dbQuery['comentario'] = $motivo;
				$dbQuery['posted_on'] = date("Y-m-d ");
				$dbQuery['posted_in'] = '0';
				$dbQuery['type'] = 'aus';
				$dbQuery['time'] = time();
				$dbQuery['aus'] = $dia.'/'.$mes.'/'.$ano;
				$dbQuery['backaus'] = $dia2.'/'.$mes2.'/'.$ano2;
				$query = $db->insertInto('cms_comments', $dbQuery);
				$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Ausencias del Equipo', 'Ha decidido ausentarse desde el ".$dia.'/'.$mes.'/'.$ano." al ".$dia2.'/'.$mes2.'/'.$ano2."', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
				$_SESSION['GOOD_RETURN'] = "Ausencia agregada correctamente";
				header("LOCATION: ". HK ."/aus.php");
			}
		}
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
							<div class="panel-head color-white"><i class="fa fa-user-times"></i> Ausencias</div>
						</div>
						<div style="padding:3px;" class="panel-body">
							<div class="slimScrollDiv" style="position: relative; overflow: auto; width: auto; height:371px;">
								<table border="1" style="width:100%">
								  <tr>
									<th style="width:15%;"><center>Usuario</center></th>
									<th style="width:50%;"><center>Motivo de la Ausencia</center></th> 
									<th style="width:16.25%;"><center>Fecha de ida</center></th>
									<th style="width:16.25%;"><center>Fecha de Regreso</center></th>
								  </tr>
									<?php global $db;
										$busc = $db->query("SELECT * FROM cms_comments WHERE type = 'aus'");
										if($busc->num_rows > 0){
											while($info = $busc->fetch_array()){ ?>
												<tr>
													<td style="padding:5px;"><center><?php echo $info['username']; ?></center></td>
													<td style="padding:5px;"><?php echo $info['comentario']; ?></td> 
													<td><center><?php echo $info['aus']; ?></center></td>
													<td><center><?php echo $info['backaus']; ?></center></td>
												</tr>
									<?php } }else{ echo '<center><b style="color:red;">No hay Ausencias</b></center>'; } ?>
								</table>
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
					<div class="panel border-1 border-red-300">
						<div class="panel-title bg-red-300">
							<div class="panel-head color-white"><i class="fa fa-user-times"></i> Ausentarme</div>
						</div>
						<div class="panel-body">
							<form action="" method="post">
								<label for="datepicker" class="control-label">¿Cu&aacute;ndo te vas?</label><br>
								<select style="width:30%;height:30px;color:#999999;border: 1px solid #999999;" class="btn dropdown-toggle selectpicker btn-default" name="dia">
										<?php
										for ($i=1; $i<=31; $i++) {
											if ($i == date('j'))
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
								</select>
								<select style="width:30%;height:30px;color:#999999;border: 1px solid #999999;" class="btn dropdown-toggle selectpicker btn-default" name="mes">
										<?php
										for ($i=1; $i<=12; $i++) {
											if ($i == date('m'))
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
								</select>
								<select style="width:30%;height:30px;color:#999999;border: 1px solid #999999;" class="btn dropdown-toggle selectpicker btn-default" name="ano">
										<?php
										for($i=date('o'); $i>=1910; $i--){
											if ($i == date('o'))
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
								</select>
								<p class="help-block">D&iacute;a/Mes/Año</p><br>
								<label for="datepicker" class="control-label">¿Cu&aacute;ndo regresas?</label><br>
								<select style="width:30%;height:30px;color:#999999;border: 1px solid #999999;" class="btn dropdown-toggle selectpicker btn-default" name="dia2">
										<?php
										for ($i=1; $i<=31; $i++) {
											if ($i == date('j'))
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
								</select>
								<select style="width:30%;height:30px;color:#999999;border: 1px solid #999999;" class="btn dropdown-toggle selectpicker btn-default" name="mes2">
										<?php
										for ($i=1; $i<=12; $i++) {
											if ($i == date('m'))
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
								</select>
								<select style="width:30%;height:30px;color:#999999;border: 1px solid #999999;" class="btn dropdown-toggle selectpicker btn-default" name="ano2">
										<?php
										for($i=date('o'); $i>=1910; $i--){
											if ($i == date('o'))
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											else
												echo '<option value="'.$i.'">'.$i.'</option>';
										}?>
								</select>
								<p class="help-block">D&iacute;a/Mes/Año</p><br>
								<label for="datepicker" class="control-label">Motivo</label>
								<input type="text" class="form-control" id="input-text" name="motivo" placeholder="Raz&oacute;n de tu ausencia"><br>
								<input name="ausentarme" type="submit" class="btn btn-dark bg-blue-grey-800 color-white margin-left-0" value="Enviar">
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php require_once 'templates/footer.tpl'; ?>
		</body>
	</html>
<?php ob_end_flush(); ?>