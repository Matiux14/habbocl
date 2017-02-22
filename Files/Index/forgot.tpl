<html>
	﻿﻿<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>{SHORTNAME} ~ Recuperar Contraseña</title>
		<link rel="shortcut icon" href="{CDN}/images/favicon.ico" type="image/vnd.microsoft.icon">
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<link rel="stylesheet" href="{CDN}/css/index.css" type="text/css" media="all" />
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>																																																																																																																																																																																																																																																																																																																																																															<?php echo'<i style="color: white;text-align: center;font-size:0px;"> &#79;&#110;&#101;&#67;&#77;&#83; &#98;&#121; &#74;&#101;&#105;&#104;&#100;&#101;&#110;</i>'; ?>
	</head>
	<body>
		<div id="hotel_bg"></div>
		<div id="hotel_bg_right"></div>
		<div id="header"><div class="content"><div class="online-count" style="height:60%;"><img src="{CDN}/images/index/ons.gif" style="margin-right: 2px;float: left;height: 20px;">{USERSON} Conectados</div></div></div>
		<div id="header-bottom"><div class="content2"><img src="{CDN}/images/index/header.png" style="margin-top:-75px;"><img src="{CDN}/images/index/sole.png" style="margin-top:-20%;margin-left:15%;"></div></div>
		
		<div class="content" style="margin-top:10px;">																																																																																																																																																																																																																																																																																																																																																																							
			{ERROR}<br>		
			<a href="/"><img src="{LOGO}" class="logo"/></a>
			<div class="left" style="margin-top:40px;">
				<div style="width:300px;" class="fb-page" data-href="https://www.facebook.com/{FACE}" data-width="420" data-height="250" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/{FACE}"><a href="https://www.facebook.com/{FACE}">{SHORTNAME}</a></blockquote></div></div>
				<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
			</div>

			<div class="containerforgot" style="margin-top:40px;">
			<img src="{CDN}images/frank22.png" style="float:right;">
				<form method="post" action="<?php echo PATH; ?>/functions.php">
					<input type="text" name="mail" class="password" placeholder="<?php echo $_SESSION['correo']; ?>" disabled></input>
					<input type="password" name="newsena" class="password" placeholder="Nueva Contraseña"></input>
					<input type="password" name="newsena2" class="password" placeholder="Repite tu Nueva Contraseña"></input>
					<input name="action" type="submit" id="register_button" style="margin-top:8px;height: 46px;float:left;width: 300px;" value="Guardar Contraseña">
				</form>	
				
			</div>
			</br>
			<div id="footerreg"><center>{SHORTNAME} {FOOTER}<br><div id="copy">Este Hotel usa <b>{ID}</b></div></center></div>						
		</div>
	</body>
</html>