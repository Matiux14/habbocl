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
<h3 class="box-title">Con más puntos de recompensa</h3>
				<div class="box-content">
					<ul class="list-group list-group-flush p-x">
					<?php 	global $db;
								$result = $db->query("SELECT * FROM user_stats ORDER BY AchievementScore DESC LIMIT 6");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){	
									
									$result2 = $db->query("SELECT * FROM users WHERE id = '".$data['id']."'");
								if($result->num_rows > 0){
									while($userinfo = $result2->fetch_array()){
										
									
									?>
									
								<div class="user" style="background: url('<?php echo AVATARIMAGE . $userinfo['look']; ?>&amp;direction=2&amp;head_direction=2&amp;gesture=sml&amp;size=1') no-repeat; background-position-y: -27px;"><hr style="margin-top: 5px;">
                       <b style="margin-left: 60px;"><a href="/home/<?php echo $userinfo['id']; ?>" class="light-link"><?php echo $userinfo['username']; ?></a></b>→ <img src="/yezz/images/trophy_gold.png">&nbsp;&nbsp;<b><?php echo utf8_encode($data['AchievementScore']) ?> </b>puntos de recompensa		<br>
                  </div>	

						<?php }}}}else{ echo '<center><b style="color:red;">No hay usuarios para mostrar</b></center>'; } ?>
					</ul>
				</div>
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
				
				
				
				<h3 class="box-title">Con más créditos</h3>
				<div class="box-content">
					<ul class="list-group list-group-flush p-x">
					<?php 	global $db;
								$result = $db->query("SELECT * FROM users WHERE rank < 4  ORDER BY credits DESC LIMIT 6");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){ ?>
<div class="user" style="background: url('<?php echo AVATARIMAGE . $data['look']; ?>&amp;direction=2&amp;head_direction=2&amp;gesture=sml&amp;size=1') no-repeat; background-position-y: -27px;"><hr style="margin-top: 5px;">
                       <b style="margin-left: 60px;"><a href="/home/<?php echo $data['id']; ?>" class="light-link"><?php echo $data['username']; ?></a></b>→ <img src="/yezz/images/diamond-icon.png">&nbsp;&nbsp;<b><?php echo $data['credits']; ?> </b>diamantes		<br>
                  </div>
						<?php } } else{ echo '<center><b style="color:red">No hay Usuarios</b></center>'; } ?>

						
					</ul>
				</div>
				
				
				
				<h3 class="box-title">Con más duckets</h3>
				<div class="box-content">
					<ul class="list-group list-group-flush p-x">
						<?php 	global $db;
								$result = $db->query("SELECT * FROM users WHERE rank < 4  ORDER BY activity_points DESC LIMIT 6");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){ ?>
<div class="user" style="background: url('<?php echo AVATARIMAGE . $data['look']; ?>&amp;direction=2&amp;head_direction=2&amp;gesture=sml&amp;size=1') no-repeat; background-position-y: -27px;"><hr style="margin-top: 5px;">
                       <b style="margin-left: 60px;"><a href="/home/<?php echo $data['id']; ?>" class="light-link"><?php echo $data['username']; ?></a></b>→ <img src="/yezz/images/diamond-icon.png">&nbsp;&nbsp;<b><?php echo $data['activity_points']; ?> </b>diamantes		<br>
                  </div>
						<?php } } else{ echo '<center><b style="color:red">No hay Usuarios</b></center>'; } ?>
						
					</ul>
				</div>
				
				
				
				<h3 class="box-title">Con más diamantes</h3>
				<div class="box-content">
					<ul class="list-group list-group-flush p-x">
						<?php 	global $db;
								$result = $db->query("SELECT * FROM users WHERE rank < 4  ORDER BY vip_points DESC LIMIT 6");
								if($result->num_rows > 0){
									while($data = $result->fetch_array()){ ?>
									<div class="user" style="background: url('<?php echo AVATARIMAGE . $data['look']; ?>&amp;direction=2&amp;head_direction=2&amp;gesture=sml&amp;size=1') no-repeat; background-position-y: -27px;"><hr style="margin-top: 5px;">
                       <b style="margin-left: 60px;"><a href="/home/<?php echo $data['id']; ?>" class="light-link"><?php echo $data['username']; ?></a></b>→ <img src="/yezz/images/diamond-icon.png">&nbsp;&nbsp;<b><?php echo $data['vip_points']; ?> </b>diamantes		<br>
                  </div>
						<?php } } else{ echo '<center><b style="color:red">No hay Usuarios</b></center>'; } ?>
						
					</ul>
				</div>
			</div>
			
		</div>
	</div>

