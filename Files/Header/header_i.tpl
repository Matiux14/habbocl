<?php global $db; $result = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1"); while($mant = $result->fetch_array()){ if($mant['mantenimiento'] == 1){header("LOCATION: ". PATH ."/maintenance"); } } ?>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>{SHORTNAME}: Es su mundo.</title>
	<meta name="category" content="Habbo">
	<meta name="description" content="{SHORTNAME} 2016 - El mundo de Habbo donde los créditos son GRATIS. Su Keko{SHORTNAME}, puede hacer una reunión y se puede convertir en el más famoso de {SHORTNAME} Hotel." />
	<meta name="author" content="Forbi" />
	<meta name="keywords" content="{SHORTNAME}, virtual, mundo, unir, Habbo libre, grupo, foro, juego, internet, amigo, joven, virtual, crear, conocer, libre, mobi, multijugador, así, insignias, social, adolescente, música, retro, Habbo, {SHORTNAME} habboretro, R26, V26, diversión, amor, nuevo, vida, vida virtual, virtual, newlife, nuevo, vivo, diversión, R63, beta, R60, popular, en línea latino" />
	<link rel="stylesheet" href="/yezz/css/habbo.in.css">
	<link rel="stylesheet" href="/yezz/css/animate.css">
	<link rel="stylesheet" href="/yezz/css/custombox.min.css">
	<script src="/yezz/js/custombox.min.js"></script>
    <script src="/yezz/js/snowstorm.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!--
	<script>
		!function(){window.onload=function(){var a=document.createElement("script");a.src='https://resend.io/widget.js',a.async=!0,a.onload=function(){__init('RAoJkCWD2e2AD4FA')},document.getElementsByTagName("head")[0].appendChild(a)}}();
	</script>
-->

	<!--Notification -->
	<link rel="manifest" href="/manifest.json">
	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
		<script type="text/javascript">
		window.smartlook||(function(d) {
		var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
		var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
		c.charset='utf-8';c.src='//rec.getsmartlook.com/recorder.js';h.appendChild(c);
		})(document);
		smartlook('init', '9225268ac4c69caee2c5cd342a9866f38b258ef2');
	</script>
	<!--Icons -->
	<link rel="apple-touch-icon" sizes="57x57" href="/yezz/images/icons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/yezz/images/icons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/yezz/images/icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/yezz/images/icons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/yezz/images/icons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/yezz/images/icons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/yezz/images/icons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/yezz/images/icons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/yezz/images/icons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/yezz/images/icons/android-chrome-192x192.png" sizes="192x192">
	<link rel="manifest" href="/yezz/images/icons/manifest.json">
	<meta name="apple-mobile-web-app-title" content="{SHORTNAME}">
	<meta name="application-name" content="{SHORTNAME}">
	<meta name="msapplication-TileColor" content="#9f00a7">
	<meta name="msapplication-TileImage" content="/yezz/images/icons/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!--Facebook Share-->
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="{SHORTNAME}" />
	<meta property="og:title" content="{SHORTNAME}" />
	<meta property="og:description" content="{SHORTNAME} 2016 - El mundo de Habbo donde los créditos son GRATIS. Su Keko{SHORTNAME}, puede hacer una reunión y se puede convertir en el más famoso de {SHORTNAME} Hotel." />
	<meta property="og:url" content="{PATH}" />
	<meta property="og:author" content="Forbi" />
	<meta property="og:image" content="/yezz/images/app_summary_image-1200x628.png" />
	<meta property="og:image:height" content="628" />
	<meta property="og:image:width" content="1200" />

	<!--Twitter Share-->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="{SHORTNAME}" />
	<meta name="twitter:author" content="Forbi" />
	<meta name="twitter:description" content="{SHORTNAME} 2016 - El mundo de Habbo donde los créditos son GRATIS. Su Keko{SHORTNAME}, puede hacer una reunión y se puede convertir en el más famoso de {SHORTNAME} Hotel." />
	<meta name="twitter:image" content="/yezz/images/app_summary_image-1200x628.png" />
	<meta name="twitter:site" content="@YeezyCMS" />

	<link rel="shortcut icon" href="/yezz/images/favicon.ico">
	<script src="/yezz/js/common.js"></script>

</head>
<body class="bg-faded" BACKGROUND="/yezz/images/31.png">
<nav class="navbar bg-white">
	<div class="container">
	<?php global $db;$logo = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1");while($logo2 = $logo->fetch_array()){?>
		<a class="navbar-brand" href="/">
			<span class="icon-logo"><img style="margin-top: -10px;" src="<?php echo $logo2['logo'];?>"></span><?php }?>
				<!--<span class="counter">3 {SHORTNAME}(s) connecté(s)!</span>-->
		</a>
		<a class="navbar-toggler hidden-md-up pull-right" data-toggle="collapse" href="#collapsingNavbar" aria-expanded="false" aria-controls="collapsingNavbar">
			&#9776;
		</a>
		<a class="navbar-toggler navbar-toggler-custom hidden-md-up pull-right" data-toggle="collapse" href="#collapsingMobileUser" aria-expanded="false" aria-controls="collapsingMobileUser">
			<span class="icon-user"></span>
		</a>
				<div id="collapsingNavbar" class="collapse navbar-toggleable-custom" role="tabpanel" aria-labelledby="collapsingNavbar">
			<ul class="nav navbar-nav pull-right" style="margin-top: 17px;">
				<li class="nav-item nav-item-toggable  active">
					<a class="nav-link" href="/">Home </a>
				</li>
				<li class="nav-item nav-item-toggable ">
					<a class="nav-link" href="/community">Comunidad </a>
				</li>

				<li class="nav-item nav-item-toggable hidden-sm-up">
					<form method="POST" action="/search" accept-charset="UTF-8" id="login" class="navbar-form"><input name="_token" type="hidden" value="L5byhI6sGNcYwbFCT8PlaoP0ncqAPuQCbSFkoNQI">
						<input class="form-control navbar-search-input" ng-model="search" placeholder="Buscar usuario en {SHORTNAME}&hellip;" name="term" type="text">
					</form>
				</li>
				<li class="navbar-divider hidden-sm-down"></li>
				<li class="nav-item dropdown nav-dropdown-search hidden-sm-down">
					<a class="nav-link dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="icon-search"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-search" aria-labelledby="dropdownMenu1">
						<for
						m method="POST" action="/search" accept-charset="UTF-8" id="login" class="navbar-form"><input name="_token" type="hidden" value="L5byhI6sGNcYwbFCT8PlaoP0ncqAPuQCbSFkoNQI">
							<input class="form-control navbar-search-input" ng-model="search" placeholder="Buscar usuario en {SHORTNAME}&hellip;" name="term" type="text">
						</form>
					</div>
				</li>
								<li class="nav-item dropdown hidden-sm-down">
					<a class="nav-link dropdown-toggle nav-dropdown-user" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="/yezz/images/circle-fill.png" width="40" height="40" alt="Avatar" class="img-circle" style="background-color: #52B3D9;
    background-image: url('/yezz/images/avatar.png');background-position: -12px -20px;background-repeat: no-repeat;"> <span class="icon-caret-down"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-user dropdown-menu-animated" aria-labelledby="dropdownMenu2">
						<div class="media">
							<div class="media-left">
								<img src="/yezz/images/circle-fill.png" width="40" height="40" alt="Avatar" class="img-circle" style="background-color: #52B3D9;
    background-image: url('/yezz/images/avatar.png');background-position-x: -12px;background-position-y: -20px;background-repeat: no-repeat;">
							</div>
							<div class="media-body media-middle">
								<h5 class="media-heading">Invitado</h5>
								<h6>¡Bienvenido a {SHORTNAME}!</h6>
							</div>
						</div>
						<a href="/welcome/register" class="dropdown-item text-uppercase">Crear una cuenta</a>
					</div>
				</li>
											</ul>
		</div>
		<div class="col-md-6" style="margin-top: 53px;margin-left: -11%;">
					<p style="color: #000; line-height: 0;">(<b>{USERSON}</b> usuarios en linea)</p>
				</div>
				<div id="collapsingMobileUser" class="collapse navbar-toggleable-custom dropdown-menu-custom p-x hidden-md-up" role="tabpanel" aria-labelledby="collapsingMobileUser">
			<div class="media m-t">
				<div class="media-left">
					<img src="/yezz/images/circle-fill.png" width="40" height="40" alt="Avatar" class="img-circle" style="background-color: #52B3D9;
    background-image: url('/yezz/images/avatar.png');background-position: -12px -20px;background-repeat: no-repeat;">
				</div>
				<div class="media-body media-middle">
					<h5 class="media-heading">Invitado</h5>
					<h6>¡Bienvenido a {SHORTNAME}!</h6>
				</div>
			</div>
			<a href="/welcome/register" class="dropdown-item text-uppercase">Crear una cuenta</a>
		</div>
			</div>
</nav>
<div class="sub-nav">
	<div class="container">
		<div class="row">
			<div class="col-md-6">

			</div>
			<div class="col-md-6" style="margin-top: 50px;">
								<a href="/welcome/register" class="btn btn-success" style="margin-left: 40%;">Únete a la aventura!</a>
							</div>
		</div>
	</div>
</div>
<div class="secondary-nav" style="background-image: url('/yezz/images/frank_22.png'); background-repeat: no-repeat; background-position: 390px 0;">
	<div class="container">
		<div class="row">
			<div class="col-md-6" style="margin-top: 10px;margin-left: 6%;">
				<p style="color: #FFF; line-height: 1;"><b>¿No se ha registrado?<br>¡Adelante únete a los {USERREG} usuarios registrados! </b></p>
			</div>
		</div>
	</div>
</div><hr class="invisible">
