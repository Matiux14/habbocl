	<div class="secondary-nav" style="background-image: url('{AVATARIMAGE}{LOOK}&direction=2&head_direction=2&gesture=sml'); background-repeat: no-repeat; background-position: 21% 30%;">
		<div class="container">
			<div class="row">
				<div class="col-md-6" style="margin-top: 17px;margin-left: 6%;">
					<p style="color: #FFF; line-height: 1;"><b>Última conexión:</b> {LASTC}</p>
				</div>
			</div>
		</div>
	</div>



<hr class="invisible">

		<div class="container">
		<div class="row">
			<div class="col-md-12">
															</div>
		</div>
		<div class="row">

			<div class="col-md-6">
                <h3>Artículos recientes</h3>
                
				<?php 	global $db;
												$result = $db->query("SELECT * FROM cms_slider ORDER BY id DESC LIMIT 1");
												if($result->num_rows > 0){
													while($data = $result->fetch_array()){?>
				<div class="news-latest" style="height: 237px; width: 100%; background-image: url('<?php echo $data['image']; ?>'); background-position: 30% 0; background-repeat: no-repeat;">
				<a class="light-link" href="/articles/<?php echo $data['id']; ?>"><h4 style="color: #FFF; text-transform: uppercase; padding: 20px 20px 0px 20px;"><?php echo $data['title']; ?></h4></a>
				<span style="color: #FFF; padding: 10px 20px 0px 20px;"><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $data['time'])); ?> | by <?php echo $data['author']; ?></span><br>
				<p style="color: #FFF; width: 400px; padding: 10px 20px 0px 20px;"><?php echo $data['story']; ?> </p>
			</div>
			
			
			<?php } }else{ echo '<i>No hay noticias</i>'; } ?>
			<?php 	global $db;
												$result = $db->query("SELECT * FROM cms_slider ORDER BY id DESC LIMIT 5");
												if($result->num_rows > 0){
													while($data = $result->fetch_array()){?>
                <div class="row" style="margin-top: 15px; margin-left: 0px;">
				<div class="col-md-4" style="height: 150px; background-image: url('<?php echo $data['image']; ?>'); background-position: 65% 0; background-repeat: no-repeat;"></div>
				<div class="col-md-8">
					<a href="/articles/<?php echo $data['id']; ?>"><h4 style="text-transform: uppercase;"><?php echo $data['title']; ?></h4></a>
					<span><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", $data['time'])); ?> | by <?php echo $data['author']; ?></span><br>
					<p><?php echo $data['story']; ?></p>
				</div>
			</div>
			
			
			
			<?php } }else{ echo '<i>No hay noticias</i>'; } ?>
			</div>
			<div class="col-md-6">
				<h3>Mi universo</h3>
				<h3 class="box-title my-purse">Monedero</h3>
				<div class="box-content">
					<ul class="list-group list-group-flush p-x">
						<li class="list-group-item" style="border-top: none;"><img src="/yezz/images/habbo_coin_icon.png">&nbsp;&nbsp;<b>{CREDITS}</b> Crédits</li>
						<li class="list-group-item"><img src="/yezz/images/icon_duckets.png">&nbsp;&nbsp; <b>{DUCKETS}</b> Duckets</li>
						<li class="list-group-item"><img src="/yezz/images/diamond-icon.png">&nbsp;&nbsp; <b>{DIAMONDS}</b> Diamants</li>
					</ul>
					<!--<div class="box-inner-footer vip-days" style="margin-top: 10px;">
						<a href="/store/vip" class="btn btn-success btn-sm">Devenir VIP</a>&nbsp;&nbsp;&nbsp;<span><b>Tu n'est pas VIP</b></span>
					</div>-->
				</div>
				<h3 class="box-title my-badges">Mis placas </h3>
				<div class="box-content">
				<?php 	$result = $db->query("SELECT * FROM user_badges WHERE user_id = '{$MYID}' ");
									if($result->num_rows > 0){
									while($data = $result->fetch_array()){ ?>
					<img src="<?php echo BADGEURL . $data['badge_id']; ?>.gif">&nbsp;&nbsp;
					<?php  	}}else{echo '<center><b style="color:red;">No cuentas con ninguna Placa a&uacute;n</b></center>';}?>
					<p class="info-text">Puedes ganar placas, participando en diversos eventos organizados por el personal, ó comprar en la tienda</p>
				  
				</div>
				<h3 class="box-title my-groups">Mis grupos</h3>
				<div class="box-content">
				<?php 	$result = $db->query("SELECT * FROM groups WHERE owner_id = '{$MYID}' ");
									if($result->num_rows > 0){
									while($data = $result->fetch_array()){ ?>
					<div class="group" style="background: url('/habbo-imaging/badge/<?php echo $data['badge']; ?>.gif') no-repeat;">
                   <b style="margin-left: 60px;"><span class="HabboUnicode"><?php echo $data['name']; ?></span></b><br>
                   <p style="margin-left: 60px; margin-top: -15px;">Creado el: <b><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%d %b %Y", $data['created'])); ?></b></p>
              </div>
					<?php  	}}else{echo '<center><b style="color:red;">No cuentas con ninguna Placa a&uacute;n</b></center>';}?>
			  
				</div>

								<h3 class="box-title radio-partner">Radio</h3>
				<div class="box-content"><center>
<embed pluginspage="http://www.adobe.com/go/getflashplayer"src="http://toplatino.net/players/toplatino.swf" width="160" height="240" wmode="transparent"type="application/x-shockwave-flash" allowscriptaccess="always"></embed>
				</center></div>
							</div>

		</div>
	</div>

