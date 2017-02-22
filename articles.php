<?php
	ob_start();
	require_once 'global.php';

	$TplClass->SetParam('title', 'Noticias');
	$TplClass->SetParam('active2', active);
	$Functions->Logged("true");

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
//FUNCIONES NEWS
	$do = $Functions->FilterText($_GET['do']);
	$key = $Functions->FilterText($_GET['key']);
	$getid = $Functions->FilterText($_GET['id']);
	$info = $db->query("SELECT * FROM cms_comments_news WHERE type = 'news' && posted_in = '{$getid}'");
	$cntr = $info->num_rows;
	if(empty($getid)){
		$news_new = $db->query("SELECT * FROM cms_slider ORDER BY id DESC LIMIT 1");
		$news_info = $news_new->fetch_array();
		$getid = $news_info['id'];
	}else{
		$news_new = $db->query("SELECT * FROM cms_slider WHERE id = '{$getid}' LIMIT 1");
		$news_info = $news_new->fetch_array();
	}
	if($_POST['enviar']){
		if(empty($_POST['comentario'])){
			$_SESSION['ERROR_RETURN'] = "Has dejado campos vac&iacute;os";
			header("LOCATION: ". PATH ."/articles/".$getid."");
		}else{
			$comentario = $Functions->FilterText($_POST['comentario']);
			$security = $db->query("SELECT * FROM cms_comments_news WHERE username = '{$_SESSION['username']}' && type = 'news' ORDER by id DESC LIMIT 1");
			$sec = $security->fetch_array();
			if($security->num_rows > 0){
				if($sec['time'] >= time() - 180){
					$_SESSION['ERROR_RETURN'] = "Debes esperar 3 min. para hacer otra publicaci&oacute;n";
					header("LOCATION: ". PATH ."/articles/".$getid."");
				}else{
					$sql = $db->query("INSERT INTO cms_comments_news (username, comentario, type, posted_on, posted_in, time) VALUES ('". $_SESSION['username'] ."', '{$_POST['comentario']}', 'news', '".date("Y-m-d ")."', '{$getid}', '".time()."')");
					if($sql){
						$_SESSION['GOOD_RETURN'] = "Has dejado un comentario correctamente";
						header("LOCATION: ". PATH ."/articles/".$getid."");
					}else{
						$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
						header("LOCATION: ". PATH ."/articles/".$getid."");
					}
				}
			}else{
				$sql = $db->query("INSERT INTO cms_comments_news (username, comentario, type, posted_on, posted_in, time) VALUES ('". $_SESSION['username'] ."', '{$_POST['comentario']}', 'news', '".date("Y-m-d ")."', '{$getid}', '".time()."')");
				if($sql){
					$_SESSION['GOOD_RETURN'] = "Has dejado un comentario correctamente";
					header("LOCATION: ". PATH ."/articles/".$getid."");
				}else{
					$_SESSION['ERROR_RETURN'] = "Ha ocurrido un error indeterminado";
					header("LOCATION: ". PATH ."/articles/".$getid."");
				}
			}
		}
	}
	if($do == "dele" && !empty($key)){
		$db->query("INSERT INTO cms_stafflogs (username, action, message, rank, userid, timestamp) VALUES ('". $_SESSION['username'] ."','Borrar Comentarios (Noticias)', 'Ha borrado un comentario', '". $user['rank'] ."', '". $user['id'] ."', '".date("Y-m-d ")."')");
		$db->query("DELETE FROM cms_comments_news WHERE id = '{$key}' && type = 'news' LIMIT 1");
		$_SESSION['GOOD_RETURN'] = "Comentario borrado correctamente";
		header("LOCATION: ". PATH ."/articles.php?id=".$getid."");						
	}
//END FUNCIONES NEWS	
	$TplClass->AddTemplate("Header", "header");
?>
	<div class="secondary-nav" style="background-image: url('/yezz/images/community.png'); background-repeat: no-repeat; background-position: 21% 95%;">
		<div class="container">
			<div class="row">
				<div class="col-md-6" style="margin-top: 10px;margin-left: 4%;">
					<a href="/community/staff" class="secondnav-link">Equipo Administrativo</a><a href="/community/alfas" class="secondnav-link">Equipo Alfa</a><a href="/articles.php" class="secondnav-link">Noticias</a>
				</div>
			</div>
		</div>
	</div>
<hr class="invisible">

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h3 class="box-title">Más noticias</h3>
				<div class="box-content">
			<?php
							$result = $db->query("SELECT * FROM cms_slider ORDER BY id DESC");
							if($result->num_rows > 0){
								echo '<ul style="padding: 0px 4px;">';
								while($data = $result->fetch_array()){
									if($data['id'] == $getid){
										$k = " style='color:grey;'";
									}
									echo '
<a class="light-link" href="/articles/'.$data['id'].'">&bull;> '.$data['title'].' &raquo;</a>
					<br>';
									unset($k);
								}
								echo '';
							}else{
								echo '<center><b style="color:red">No hay noticias</b></center>';
							}
						?>				</div>
			</div>

			
			<div class="col-md-8">
				<div class="article-header" style="background-image: url('<?php echo $news_info['image']; ?>')">
					<h3><?php echo $news_info['title']; ?></h3>
					<p>Publicado el <?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $news_info['time'])); ?> por <b><a class="light-link"><?php echo $news_info['author']; ?></a></b></p>
				</div>

				<h5 style="margin-top 10px;">Resumen</h5>
				<p style="line-height: 1;"><i><?php echo $news_info['story']; ?> </i></p>

				<p><?php echo $news_info['longstory']; ?></p>


				<h3 class="box-title">Comentarios (<?php echo $cntr; ?>)</h3>
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
					<div class="col-md-12">
					<h3 class="box-title">Comentarios</h3>
					<div class="box-content">

				<?php global $db;
							$comentarios = $db->query("SELECT * FROM cms_comments_news WHERE posted_in = '{$getid}' ORDER BY id DESC");
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
													echo '<u style="font-size:12px; color:red;float:right;"><i><a href="'. PATH .'/articles/'.$coment['posted_in'].'&do=dele&key='.$coment['id'].'"><img src="/yezz/img/emojis/eliminar.png" width="24" height="24"></a></i></u>';
												}
											?><?php 
											if($userrinf['rank'] == 2){
												echo '<img style="margin-top: 0px;float:right;" src="'.BADGEURL.'VIP.gif">';
											}elseif($userrinf['rank'] == 4){
												echo '<img style="margin-top: 0px;float:right;" src="'.BADGEURL.'AMB.gif">';
											}elseif($userrinf['rank'] == 5){
												echo '<img style="margin-top: 0px;float:right;" src="'.BADGEURL.'MOD.gif">';
											}elseif($userrinf['rank'] >= 6 AND $userrinf['rank'] <= 9){
												echo '<img style="margin-top: 0px;float:right;" src="'.BADGEURL.'ADM.gif">';
											}elseif($userrinf['rank'] >= 10){
												echo '<img style="margin-top: 0px;float:right;" src="'.BADGEURL.'ADM.gif">';
											}
											?><span class="emoji-inner" style="background: url(chrome-extension://immhpnclomdloikkpcefncmfgjbkojmh/emoji-data/sheet_apple_64.png);background-position:75% 45%;background-size:4100%" title="no_entry_sign"></span>
					<b style="font-size: 20px; margin-left: 10px;"><a href="/home/<?php echo utf8_encode($userrinf ['id']); ?>" class="light-link"><?php echo utf8_encode($coment['username']); ?></a></b><br>
					<div class="box-inner-footer" style="margin-top: 1px;">
						<?php echo $emoji ?>
					</div><br>
					<?php }}}else{echo "<center><b style='color:red'>No hay comentarios</b></center>";}?>
				</div>
			</div>
			</div>
	
		</div>
	</div>

<?php
//COLUMNA FOOTER	
	$TplClass->AddTemplate("Data", "footer");
	ob_end_flush(); 
?>
