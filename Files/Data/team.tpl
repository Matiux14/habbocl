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
			<div class="col-md-6">
				<h3>Equipo de {SHORTNAME}</h3>
				
				
				
				<?php 	global $db;
					$dd = $db->query("SELECT * FROM ranks WHERE id >= 5 AND id <= ".MAXRANK." ORDER BY id DESC");
					while($rank = $dd->fetch_array()){
					echo '<h3 class="box-title" style="background-color: '.$rank['color'].' !important;">'.$rank['name'].'</h3>
					<div class="box-content" style="background-color: '.$rank['color2'].' !important;">
								';	
                   
									$userquery = $db->query("SELECT * FROM users WHERE rank = '". $rank['id'] ."' ORDER BY rank DESC");
									while($userstaff = $userquery->fetch_array()){
										if($userstaff['cms_staffocult'] == 0){
											$userquery2 = $db->query("SELECT * FROM user_badges WHERE user_id = '". $userstaff['id'] ."' ORDER BY id DESC LIMIT 1 ");
											while($userstaffb = $userquery2->fetch_array()){ 
												setlocale(LC_TIME,"spanish");
												echo '
												<div class="user" style="background: url(https://habbo.com/habbo-imaging/avatarimage?figure='.$userstaff['look'].'&direction=2&head_direction=2&gesture=sml&size=l) no-repeat; background-position-y: -60px;background-position-x: -20px;">
												<img style="float:left;margin-left:95%;margin-top:-10px;" src="'. BADGEURL .''.$userstaffb['badge_id'].'.gif">
                       <b style = "margin-left: 100px;" ><a href = "/home/'. $userstaff['id'] .'" class="light-link" >'.utf8_encode($userstaff['username']).'</a></b> 
					   <img src="/yezz/img/emojis/'.$userstaff['online'].'.png" width="20" height="20">&nbsp;&nbsp;</b>
					   <br><p style="margin-left: 100px; margin-top: -10px;">Posición: <b>'.$rank['Descripcion'].'</b></p></div>
	
														'; 
											}
										}
									}echo '</div>';}?>
				
			</div>
			<div class="col-md-6">
				<h3 class="box-title">Información</h3>
				<div class="box-content">
					<p>Estos son los miembros del personal {SHORTNAME}, que ayudan a mantener {SHORTNAME} en orden y al día</p>
					<p>El equipo del hotel lleva placas especiales por las cuales podr&aacute;s reconocerlos. Ellos est&aacute;n aqu&iacute; para ayudarte en lo que necesites y si necesitas su ayuda solo debes buscarlos en alguna sala o contactarlos a trav&eacute;s de la consola o la herramienta de ayuda del hotel. 
					<img style="float: right;" src="http://rs295.pbsrc.com/albums/mm127/J-E-R-B-/staff.gif~c200" alt="" />
<p>Si quieres formar parte del equipo, tu comportamiento y actit&uacute;d deber&aacute; ser evaluada por un Administrador, esto cuenta la conexi&oacute;n que tienes dentro del hotel, tu participaci&oacute;n en los concursos, ayuda a los usuarios, evaluamiento de escritura, y obviamente ser activo.</p>
				</div>
			</div>
			<div class="col-md-offset-12">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- [BW] - Column -->
				<ins class="adsbygoogle"
					 style="display:inline-block;width:160px;height:600px"
					 data-ad-client="ca-pub-2111633042687069"
					 data-ad-slot="9515947469"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
	</div>
