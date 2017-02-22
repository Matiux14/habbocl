<?php

	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', 'Perfil');
	$TplClass->SetParam('active1', active);
	$Functions->Logged("allow");
	$TplClass->SetParam('HKLINK', '');

	$users = $db->query("SELECT rank FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
	while($lastc = $resulta->fetch_array()){ $TplClass->SetParam( 'LASTC', $Functions->GetLast($lastc['last_online']) );}
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
	
//FUNCIONES DEL PERFIL
	$MYID = $Functions->GetID();
	$getid = $Functions->FilterText($_GET['p']);
	$usersh = $db->query("SELECT * FROM user_badges WHERE user_id = '{$getid}' ORDER by id ASC LIMIT 1");
	$badgeusrhome = $usersh->fetch_array();
	$usersh2 = $db->query("SELECT * FROM user_badges WHERE user_id = '{$getid}'");
	$badgesusrhome = $usersh2->fetch_array();
	$do = $Functions->FilterText($_GET['do']);
	$key = $Functions->FilterText($_GET['key']);
	if(empty($getid)){
		$perfil = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
		$userhome = $perfil->fetch_array();
		$getid = $Functions->FilterText($userhome['id']);
	}else{
		$perfil = $db->query("SELECT * FROM users WHERE id = '{$getid}' LIMIT 1");
		$userhome = $perfil->fetch_array();
	}
	if($_POST['enviar']){
		if(empty($_POST['comentario'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". PATH ."/home/".$getid."");
		}else{
			$comentario = $Functions->FilterText($_POST['comentario']);
			$security = $db->query("SELECT * FROM cms_comments WHERE username = '{$_SESSION['username']}' && type = 'profile' ORDER by id DESC LIMIT 1");
			$sec = $security->fetch_array();
			if($security->num_rows > 0){
				if($sec['time'] >= time() - 180){
					$_SESSION['ERROR_RETURN'] = "Debes esperar 3 min. para enviar otro mensaje";
					header("LOCATION: ". PATH ."/home/".$getid."");
				}else{
					$sql = $db->query("INSERT INTO cms_comments (username, comentario, type, posted_on, posted_in, time) VALUES ('". $_SESSION['username'] ."', '{$_POST['comentario']}', 'profile', '".date("Y-m-d ")."', '{$getid}', '".time()."')");
					if($sql){
						$_SESSION['GOOD_RETURN'] = "Has enviado el mensaje correctamente";
						header("LOCATION: ". PATH ."/home/".$getid."");
					}else{
						$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
						header("LOCATION: ". PATH ."/home/".$getid."");
					}
				}
			}else{
				$sql = $db->query("INSERT INTO cms_comments (username, comentario, type, posted_on, posted_in, time) VALUES ('". $_SESSION['username'] ."', '{$_POST['comentario']}', 'profile', '".date("Y-m-d ")."', '{$getid}', '".time()."')");
				if($sql){
					$_SESSION['GOOD_RETURN'] = "Has enviado el mensaje correctamente";
					header("LOCATION: ". PATH ."/home/".$getid."");
				}else{
					$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
					header("LOCATION: ". PATH ."/home/".$getid."");
				}
			}
		}
	}
	if($do == "dele" && !empty($key)){
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Borrar Comentarios (Perfil)', 'Ha borrado un comentario del perfil con id {$getid}', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_comments WHERE id = '{$key}' && type = 'profile' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Comentario borrado correctamente";
		header("LOCATION: ". PATH ."/home/".$getid."");					
	}
	//COLUMNA CENTRO
	$TplClass->Display('raven" style="background-image: url('. $userhome['cms_pbackground'] .');border:1px;border-radius:5px;"');

//END FUNCIONES	
?>
	<div class="secondary-nav" style="background-image: url('<?php echo AVATARIMAGE; ?><?php echo $userhome['look']; ?>&direction=2&head_direction=2&gesture=sml'); background-repeat: no-repeat; background-position: 21% 30%;">
		<div class="container">
			<div class="row">
				<div class="col-md-6" style="margin-top: 17px;margin-left: 6%;">
					<p style="color: #FFF; line-height: 1;"><b>Última conexión de <?php echo $userhome['username']; ?>:</b> <?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $userhome['last_online'])); ?></p>
				</div>
			</div>
		</div>
	</div>



<hr class="invisible">

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h3 class="box-title"><?php echo $userhome['username']; ?> </h3>
				<div class="col-md-12" style="margin-top: -38px;margin-left: 10%;">
					<p style="color: #fff; line-height: 0;"><b>Misión:</b> <?php echo $userhome['motto']; ?></p>
				</div>
				<div class="box-content" style="background-image: url('<?php echo AVATARIMAGE; ?><?php echo $userhome['look']; ?>&direction=2&head_direction=2&gesture=sml&size=l'); background-repeat: no-repeat; background-position-y: -50px;">
					<p style="margin-left: 20%; line-height: 1;"><i><span class="HabboUnicode"></span></i>
	<?php 	global $db;
								$result = $db->query("SELECT * FROM user_stats WHERE id = '{$getid}' ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){?>
					<br><img src="/yezz/images/habbo_coin_icon.png"> <?php echo $userhome['credits']; ?><br>
					<img src="/yezz/images/icon_duckets.png"> <?php echo $userhome['activity_points']; ?><br>
					<img src="/yezz/images/diamond-icon.png"> <?php echo $userhome['vip_points']; ?><br>
					<img src="/yezz/images/resp-icon.gif"> <?php echo $data['Respect']; ?><br>
						<img src="/yezz/images/trophy_gold.png"> <?php echo $data['AchievementScore']; ?></p>
							<?php  }}else{echo '';}?>

					<div class="box-inner-footer">
																		<?php if($userhome['online'] == 1){echo '<img src="/yezz/img/emojis/on.png" width="24" height="24">&nbsp;&nbsp;'.$userhome['username'].' esta <b>Conectad@</b>';}else{echo '<img src="/yezz/img/emojis/off.png" width="24" height="24">&nbsp;&nbsp;'.$userhome['username'].' esta <b>Desconectad@</b>';}?>
																</div>
				</div>
				<h3 class="box-title search-rooms">Salas de <?php echo $userhome['username']; ?></h3>
				<div class="box-content">
				
				
				<?php 	global $db;
								$result = $db->query("SELECT * FROM rooms WHERE owner = '{$getid}' ORDER BY id DESC");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){?>

					<div class="room" style="background: url('/yezz/images/room_models/<?php echo $data['model_name']; ?>.png') no-repeat;">
                        <b style="margin-left: 15%;"><span class="HabboUnicode"><?php echo $data['caption']; ?></span></b><br>
                        <p style="margin-left: 15%; margin-top: -15px;">Tags: <b><span class="HabboUnicode"><?php echo $data['tags']; ?></span></b></p>
                  </div>
				<?php  }}else{echo '<center><b style="color:red;">El usuario no cuenta con ninguna sala a&uacute;n</b></center>';}?>

				
				  
				</div>
				
				
				
				<h3 class="box-title my-friends">Amigos de  <?php echo $userhome['username']; ?></h3>
				<div class="box-content">
				
			</div>					<h3 class="box-title">Enviar mensaje a <?php echo $userhome['username']; ?></h3>
				<div class="box-content">
									<?php
//COLUMNA error	
	$TplClass->AddTemplate("Data", "error");
	ob_end_flush(); 
?>
				<form name="coment" id="coment" action="" method="post">
									<script type="text/javascript">
										function Emoticons(texto)
										{
											document.getElementById('commentsaa').value += ' '+texto;
										}
										function traspaso() 
										{ 
											document.forms['formulario']['comentario'].value=document.forms['formulario']['color'].value; 
										}
									</script>
									<div class="box-inner-footer" style="margin-top: 1px;"><tr>
										<td>
											<center>										
												<a onclick="Emoticons(':D');"><img src='/yezz/img/emojis/carita_sonriente.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':P');"><img src='/yezz/img/emojis/carita_lengua3.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*guino*');"><img src='/yezz/img/emojis/carita_guino.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':|');"><img src='/yezz/img/emojis/carita_plana2.png' width='24' height='24'></a>												
												<a onclick="Emoticons('x_x');"><img src='/yezz/img/emojis/carita_xx.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*risa*');"><img src='/yezz/img/emojis/carita_sonriente2.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*heart*');"><img src='/yezz/img/emojis/carita_corazon.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':poop:');"><img src='/yezz/img/emojis/carita_poop.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*triste*');"><img src='/yezz/img/emojis/carita_triste.png' width='24' height='24'></a>												
												<a onclick="Emoticons('XD');"><img src='/yezz/img/emojis/carita_sonriente3.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*lengua*');"><img src='/yezz/img/emojis/carita_lengua2.png' width='24' height='24'></a>												
												<a onclick="Emoticons(';P');"><img src='/yezz/img/emojis/carita_lengua1.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':O');"><img src='/yezz/img/emojis/carita_ooh.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*sexy*');"><img src='/yezz/img/emojis/carita_sonriente4.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':*');"><img src='/yezz/img/emojis/carita_kiss1.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*kiss*');"><img src='/yezz/img/emojis/carita_kiss.png' width='24' height='24'></a>												
												<a onclick="Emoticons('O_O');"><img src='/yezz/img/emojis/carita_ooh1.png' width='24' height='24'></a>												
												<a onclick="Emoticons('^_^');"><img src='/yezz/img/emojis/carita_sonriente5.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':@');"><img src='/yezz/img/emojis/carita_enojado.png' width='24' height='24'></a>												
												<a onclick="Emoticons('Q.Q');"><img src='/yezz/img/emojis/carita_triste2.png' width='24' height='24'></a>												
												<a onclick="Emoticons(':/');"><img src='/yezz/img/emojis/carita_triste1.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*love*');"><img src='/yezz/img/emojis/carita_ojos.png' width='24' height='24'></a>												
												<a onclick="Emoticons('-_-');"><img src='/yezz/img/emojis/carita_plana.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*angel*');"><img src='/yezz/img/emojis/carita_angel.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*lentes*');"><img src='/yezz/img/emojis/carita_lentes.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*applause*');"><img src='/yezz/img/emojis/carita_applause.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*god*');"><img src='/yezz/img/emojis/carita_god.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*strong*');"><img src='/yezz/img/emojis/carita_strong.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*decepcionado*');"><img src='/yezz/img/emojis/carita_decepcion.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*sinpalabras*');"><img src='/yezz/img/emojis/carita_sinpalabras.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*star*');"><img src='/yezz/img/emojis/carita_star.png' width='24' height='24'></a>												
												<a onclick="Emoticons('*contodo*');"><img src='/yezz/img/emojis/carita_golpe.png' width='24' height='24'></a>
												<a onclick="Emoticons('*angelbebe*');"><img src='/yezz/img/emojis/carita_angelbeb.png' width='24' height='24'></a>
												<a onclick="Emoticons('*boy*');"><img src='/yezz/img/emojis/carita_boy.png' width='24' height='24'></a>
												<a onclick="Emoticons('*bebe*');"><img src='/yezz/img/emojis/carita_bebe.png' width='24' height='24'></a>
												<a onclick="Emoticons('*hey*');"><img src='/yezz/img/emojis/boy_hey.png' width='24' height='24'></a>
												<a onclick="Emoticons('*x*');"><img src='/yezz/img/emojis/boy_x.png' width='24' height='24'></a>
												<a onclick="Emoticons('*girlhey*');"><img src='/yezz/img/emojis/girl_hey.png' width='24' height='24'></a>
												<a onclick="Emoticons('*girlx*');"><img src='/yezz/img/emojis/girl_x.png' width='24' height='24'></a>
												<a onclick="Emoticons('*viejo*');"><img src='/yezz/img/emojis/carita_viejo.png' width='24' height='24'></a>
												<a onclick="Emoticons('*arrecho*');"><img src='/yezz/img/emojis/carita_arrecho.png' width='24' height='24'></a>
												<a onclick="Emoticons('*choquedemanos*');"><img src='/yezz/img/emojis/hands.png' width='24' height='24'></a>
												<a onclick="Emoticons('*hands2*');"><img src='/yezz/img/emojis/hands2.png' width='24' height='24'></a>
												<a onclick="Emoticons('*hand*');"><img src='/yezz/img/emojis/hand.png' width='24' height='24'></a>
												<a onclick="Emoticons('*hand2*');"><img src='/yezz/img/emojis/hand2.png' width='24' height='24'></a>
												<a onclick="Emoticons('*fuck*');"><img src='/yezz/img/emojis/hand3.png' width='24' height='24'></a>
												<a onclick="Emoticons('*lol*');"><img src='/yezz/img/emojis/mecago_delarisa.png' width='24' height='24'></a>
												<a onclick="Emoticons('*fantasma*');"><img src='/yezz/img/emojis/fantasma.png' width='24' height='24'></a>
												<a onclick="Emoticons('*lengua*');"><img src='/yezz/img/emojis/lengua.png' width='24' height='24'></a>
												<a onclick="Emoticons('*sueño*');"><img src='/yezz/img/emojis/carita_sueño.png' width='24' height='24'></a>
												<a onclick="Emoticons('*extra*');"><img src='/yezz/img/emojis/carita_extra.png' width='24' height='24'></a>
												<a onclick="Emoticons('*diabla*');"><img src='/yezz/img/emojis/carita_diabla.png' width='24' height='24'></a>
												<a onclick="Emoticons('*mongolico*');"><img src='/yezz/img/emojis/carita_mongolico.png' width='24' height='24'></a>
											</center>
										</td></div>
										<tr>
											<td>
											<textarea class="form-control form-control-lg" name="comentario" id="commentsaa" maxlength="1000"></textarea>
											</td>
										</tr><br>
										<tr>
											<td>
						<input class="btn btn-success btn-block" type="submit" name="enviar" id="enviar" value="Enviar" />
						
						</td>
										</tr>	 
									</tr>
						 
						</form>
					</div>
					</div>
			<div class="col-md-6">
				<h3 class="box-title">Sobre <?php echo $userhome['username']; ?></h3>
				<div class="box-content">	
					<img src="/yezz/images/location.gif"> <?php echo $userhome['cms_video']; ?><br>
					<img src="/yezz/images/created-on.png"> <?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $userhome['account_created'])); ?><br><br>
					<h4>Redes sociales</h4>
					<img src="/yezz/images/twitter_icon.png"> <a class="light-link" href="http://twitter.com/<?php echo $userhome['cms_twitter']; ?>" target="_blank">@<?php echo $userhome['cms_twitter']; ?></a><br>
					<img src="/yezz/images/facebook_icon.png"> <a class="light-link" href="http://facebook.com/<?php echo $userhome['facebook']; ?>" target="_blank"><?php echo $userhome['facebook']; ?></a><br><br>

					<p style="line-height: 1;"><span class="HabboUnicode"><?php echo $userhome['cms_pprofile'] ?></span></p>
							
															</div>

				<h3 class="box-title my-badges">Placas de <?php echo $userhome['username']; ?></h3>
				<div class="box-content">
				<?php 	$query_user = $db->query("SELECT * FROM user_badges WHERE user_id = '{$getid}'");
									if($query_user->num_rows > 0){
										while($perfil = $query_user->fetch_array()){?>
					<img src="<?php echo BADGEURL . $perfil['badge_id']; ?>.gif">&nbsp;&nbsp;
					<?php  	}}else{echo '<center><b style="color:red;">El usuario no cuenta con ninguna Placa a&uacute;n</b></center>';}?>
				</div>
				<h3 class="box-title my-groups">Grupo(s) de <?php echo $userhome['username']; ?></h3>
				<div class="box-content">
					<?php 	$result = $db->query("SELECT * FROM groups WHERE owner_id = '{$getid}'");
									if($result->num_rows > 0){
									while($data = $result->fetch_array()){ ?>
					<div class="group" style="background: url('/habbo-imaging/badge/<?php echo $data['badge']; ?>.gif') no-repeat;">
                   <b style="margin-left: 60px;"><span class="HabboUnicode"><?php echo $data['name']; ?></span></b><br>
                   <p style="margin-left: 60px; margin-top: -15px;">Creado el: <b><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%d %b %Y", $data['created'])); ?></b></p>
              </div>
					<?php  	}}else{echo '<center><b style="color:red;">El usuario no cuenta con ningun gurupo aún</b></center>';}?>
				</div>
				
				
				
								<h3 class="box-title">Mensajes de <?php echo $userhome['username']; ?></h3>
					<div class="box-content">

				<?php global $db;
							$comentarios = $db->query("SELECT * FROM cms_comments WHERE posted_in = '{$getid}' ORDER BY id DESC");
							if($comentarios->num_rows > 0){
								while($coment = $comentarios->fetch_array()){
									$userinfo = $db->query("SELECT * FROM users WHERE username = '".$coment['username']."'");
									$emoji = $Functions->FilterTextEmoji($coment['comentario']);
									while($userrinf = $userinfo->fetch_array()){ ?>
				<img src="/yezz/images/circle-fill.png" width="40" height="40" alt="Avatar" class="img-circle" style="box-shadow: 0 0 0 4px #424753; background-color: #52B3D9;
    				background-image: url('<?php echo AVATARIMAGE; ?><?php echo $userrinf['look']; ?>&amp;direction=2&amp;head_direction=2&amp;gesture=sml');background-position: -12px -20px;background-repeat: no-repeat;">
					<?php 	global $db;
												$users2 = $db->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
												$user1 = $users2->fetch_array();	
												if($user1['rank'] >= 9){
													echo '<u style="font-size:12px; color:red;float:right;"><i><a href="'. PATH .'/home/'.$getid.'&do=dele&key='.$coment['id'].'"><img src="/yezz/img/emojis/eliminar.png" width="24" height="24"></a></i></u>';
												}
											?>
											<span class="emoji-inner" style="background: url(chrome-extension://immhpnclomdloikkpcefncmfgjbkojmh/emoji-data/sheet_apple_64.png);background-position:75% 45%;background-size:4100%" title="no_entry_sign"></span>
					<b style="font-size: 20px; margin-left: 10px;"><a href="/home/<?php echo utf8_encode($userrinf ['id']); ?>" class="light-link"><?php echo utf8_encode($coment['username']); ?></a></b><br>
					<div class="box-inner-footer" style="margin-top: 1px;">
						<?php echo $emoji ?>
					</div><br>
					<?php }}}else{echo "<center><b style='color:red'>No hay comentarios</b></center>";}?>
				</div>
				
				
			</div>
		</div>
	</div>

<?php
//COLUMNA FOOTER	
	$TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>
