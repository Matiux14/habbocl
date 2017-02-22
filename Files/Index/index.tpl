 <div class="container">
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
                <h3>Conectarse</h3>
                <p style="margin-top: -20px;">¿Ya está inscrito? Puede conectarse a continuación</p>
				{ERROR}
                <form action="/submit.php" method="post" >

                
                <div class="form-group has-icon-left form-control-name">
                    <label class="sr-only" for="inputUsername">{SHORTNAME} Nombre</label>
                    <input class="form-control form-control-lg" placeholder="{SHORTNAME} Nombre" required="required" id="inputUsername" name="username" type="text">
                    
                </div>
                <div class="form-group has-icon-left form-control-password">
                    <label class="sr-only" for="inputPassword">Contraseña</label>
                    <input class="form-control form-control-lg" placeholder="Contraseña" required="required" autocomplete="off" id="inputPassword" name="password" type="password" value="">
                    
                    <p style="font-size: 13px; line-height: 1; padding: 10px; margin-bottom: -15px;"><a href="/forgot/password">¿Contraseña olvidada?</a></p>
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary btn-block">Entrar</button>
                </div>
                </form>

                <h3 class="box-title latest-users">Últimos registros</h3>
                <div class="box-content">
                    <div id="carousel-latest-users" class="carousel slide" data-ride="carousel" data-interval="0">
                        <div class="carousel-inner" role="listbox">
						<?php 	global $db;
						$usreg = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 3");
						if($usreg->num_rows > 0){
							while($us = $usreg->fetch_array()){?>

						<div class="carousel-item active">
						<blockquote class="blockquote"><div class="row" style="margin-top: 0px; margin-left: 10px;">
												<div class="col-md-13" style="height: 150px; background-image: url('<?php echo $us['cms_pbackground']; ?>'); background-position: 65% -100; background-repeat:;">
<img src="/yezz/images/circle-fill.png" width="40" height="40" alt="Avatar" class="img-circle" style="background-color: #52B3D9;
    background-image: url('{AVATARIMAGE}<?php echo $us['look']; ?>&direction=2&head_direction=2&gesture=sml');background-position: -12px -20px;background-repeat: no-repeat; margin-bottom: 10px;">
								<p class="h3" style="margin-top: 10px;"><?php echo $us['username']; ?></p>
								<footer style="color: #FFF; margin-top: -10px;"><b><?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime(" %d %b. %y", $us['account_created'])); ?></b></footer>
							</div></div></blockquote>
						</div>
						<?php } }else{ echo '<b style="color:red;">No hay Usuarios Registrados A&uacute;n</b><br><br><br>'; } ?>
						
						</div>

                    </div>
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