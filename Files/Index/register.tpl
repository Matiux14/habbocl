<?php global $db; $result = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1"); while($mant = $result->fetch_array()){ if($mant['mantenimiento'] == 1){header("LOCATION: ". PATH ."/maintenance"); } } ?>
<?php global $db;$result = $db->query("SELECT * FROM cms_settings WHERE id = '1'");while($data = $result->fetch_array()){if($data['registros'] == 1){?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>{SHORTNAME}: Crea tu {SHORTNAME} Avatar.</title>
	<meta name="category" content="Habbo">
	<meta name="description" content="{SHORTNAME} 2016 - El mundo de Habbo donde los créditos son GRATIS. Su Keko{SHORTNAME}, puede hacer una reunión y se puede convertir en el más famoso de {SHORTNAME} Hotel." />
	<meta name="author" content="Forbi" />
	<meta name="keywords" content="{SHORTNAME}, virtual, mundo, unir, Habbo libre, grupo, foro, juego, internet, amigo, joven, virtual, crear, conocer, libre, mobi, multijugador, así, insignias, social, adolescente, música, retro, Habbo, {SHORTNAME} habboretro, R26, V26, diversión, amor, nuevo, vida, vida virtual, virtual, newlife, nuevo, vivo, diversión, R63, beta, R60, popular, en línea latino" />
	<link rel="stylesheet" href="/yezz/css/habbo.in.css">
	<link rel="stylesheet" href="/yezz/css/application.css">
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
								<a href="/" class="btn btn-danger" style="margin-left: 40%;">Anular</a>
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

<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h3>Unirse a {SHORTNAME}</h3>
				<p style="margin-top: -15px; line-height: 1.1;">Para llegar a nosotros es muy simple, llene el formulario a continuación para crear su cuenta y a disfrutar!</p>
				{ERROR}
				<form method="post" action="<?php echo PATH; ?>/register_submit.php">

				
				<div class="form-group has-icon-left form-control-name">
					<label class="sr-only" for="inputUser">{SHORTNAME} Nombre</label>
					<input class="form-control form-control-lg" placeholder="{SHORTNAME} Nombre" required="required" id="inputUser" autocomplete="off" name="reg.username" type="text">
					
					<p style="font-size: 11px; line-height: 1; padding: 10px; margin-bottom: -15px;">Su nombre de usuario debe ser único y de respetar la actitud {SHORTNAME}, todas las cuentas con el apodo comenzando con ADM, MOD ó XXX será expulsado permanentemente</p>
				</div>
				<div class="form-group has-icon-left form-control-email">
					<label class="sr-only" for="inputEmail">Correo electrónico</label>
					<input class="form-control form-control-lg" placeholder="Correo electrónico" required="required" id="inputEmail" autocomplete="off" name="reg.mail" type="text">
					
					<p style="font-size: 11px; line-height: 1; padding: 10px; margin-bottom: -15px;"><b>Su dirección de correo electrónico debe ser válida</b>, ya que tendrá que usarlo para activar determinadas funciones en {SHORTNAME}</p>
				</div>
				<div class="form-group has-icon-left form-control-password">
					<label class="sr-only" for="inputPass">Contraseña</label>
					<input class="form-control form-control-lg" placeholder="Contraseña" required="required" id="inputPass" autocomplete="off" name="reg.password" type="password" value="">
					
					<p style="font-size: 11px; line-height: 1; padding: 10px; margin-bottom: -15px;">Elija una contraseña con un mínimo de 8 caracteres alfanuméricos además de que contenga caracteres diferentes y complejos, será más robusto para los piratas informáticos</p>
				</div>
				<div class="form-group has-icon-left form-control-password">
					<label class="sr-only" for="inputConfPass">Confirmar contraseña</label>
					<input class="form-control form-control-lg" placeholder="Confirmar contraseña" required="required" id="inputConfPass" autocomplete="off" name="reg.password2" type="password" value="">
				</div>
				<div class="form-group">
					<label for="selectGender">Sexo Masculino/Femenino</label>
					<select class="form-control form-control-lg" id="selectGender" name="gender">
					<option value="M" selected="selected">Masculino</option>
					<option value="F">Femenino</option></select>
				</div>
				
				<div class="form-group">
				<label class="selectGender" for="inputPass">Fecha de nacimiento</label>
<select name="DD" class="form-control form-control-lg" style="width:25%;">
						<option value="" disabled="" selected="">Día</option>
						<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
					</select>
					<select name="MM" class="form-control form-control-lg" style="width:25%; position:absolute; top: 660px; left: 180px;">
						<option value="" disabled="" selected="">Mes</option>
						<option value="01">Enero</option><option value="02">Febrero</option><option value="03">Marzo</option><option value="04">Abril</option><option value="05">Mayo</option><option value="06">Junio</option><option value="07">Julio</option><option value="08">Agosto</option><option value="09">Septiembre</option><option value="10">Octubre</option><option value="11">Noviembre</option><option value="12">Diciembre</option>
					</select>
					<select name="AAAA" class="form-control form-control-lg" style="width:25%; position:absolute; top: 660px; left: 350px;">
						<option value="" disabled="" selected="">Año</option>
						<option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option>
					</select>
</div>
<div id="index_badges" style="display: block;">						
				<?php 	global $db;
											$badreg = $db->query("SELECT * FROM cms_badges_reg ORDER BY id ASC LIMIT 9");
											if($badreg->num_rows > 0){
												while($bdg = $badreg->fetch_array()){?>
												<input name="badge" id="badge_<?php echo $bdg['id']; ?>" value="<?php echo $bdg['code']; ?>" type="radio" checked/>
												<label for="badge_<?php echo $bdg['id']; ?>"><img src="<?php echo BADGEURL; ?><?php echo $bdg['code']; ?>.gif"></label>
										<?php } }else{ echo '<p>No hay placas en la base de datos</p>'; } ?>
																			</div>									
				<div class="form-group">
					<button name="action" type="submit" class="btn btn-success btn-block">Crear cuenta</button>
				</div>
</div>
				</form>
			<div class="col-md-6">
				<h3 class="box-title">¿Qué es {SHORTNAME}?</h3>
				<div class="box-content">
					<p style="color: #FFF;">{SHORTNAME} es un servidor privado de Habbo, lo que significa que emula la mayor parte del juego original, su principal objetivo es proporcionar a los usuarios con el contenido libre que normalmente se cobra en el servidor original.</p>
				</div>
				

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


			
			<script src="https://www.google.com/recaptcha/api.js?hl=fr" async="" defer=""></script>
		</div>
	</div></div>
	<?php }else{$_SESSION['LOGIN_ERROR'] = "Los registros han sido desactivados temporalmente";header("LOCATION: ". PATH ."/index.php");}}?>