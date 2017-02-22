<?php global $db;
$perfil = $db->query("SELECT * FROM users WHERE username =  '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
$user = $perfil->fetch_array();
$ranks = $db->query("SELECT * FROM ranks");
$rank = $ranks->fetch_array();
$info = $db->query("SELECT * FROM cms_comments WHERE type = 'bug'");
$cntr = $info->num_rows;
?>
<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{SHORTNAME}: {title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link rel="shortcut icon" href="{CDN}/images/favicon.ico" type="image/vnd.microsoft.icon">
	<script src="{CDN}/js/v3_landing_top.js" type="text/javascript"></script>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<style>#error{background: #F44336 ;padding: 10px;color: white;text-align: center;width:100%;}</style>

	<link href="{HK}/templates/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{HK}/templates/css/ionicons.min.css" rel="stylesheet" />
	<link href="{HK}/templates/css/font-awesome.min.css" rel="stylesheet" />

	<link href="{HK}/templates/css/animate.css" rel="stylesheet" />
	<link href="{HK}/templates/css/slider.css" rel="stylesheet" />
	<link href="{HK}/templates/css/rickshaw.min.css" rel="stylesheet" />
	<link href="{HK}/templates/css/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
	<link href="{HK}/templates/css/daterangepicker-bs3.css" rel="stylesheet" />

	<link href="{HK}/templates/css/material.css" rel="stylesheet" />
	<link href="{HK}/templates/css/style.css" rel="stylesheet" />
	<link href="{HK}/templates/css/plugins.css" rel="stylesheet" />
	<link href="{HK}/templates/css/helpers.css" rel="stylesheet" />
	<link href="{HK}/templates/css/responsive.css" rel="stylesheet" />
</head>
<body class="fixed-leftside fixed-header">
	<header>
		<a href="{HK}" class="logo"><span>{SHORTNAME}</span></a>
		<nav class="navbar navbar-static-top">
			<a href="#" class="navbar-btn sidebar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a> 
        </nav>
    </header>
		 
	<div class="wrapper">
        <div class="leftside">
			<div class="sidebar">
				<div class="nav-profile">
					<div class="thumb">
						<img  src="/yezz/images/dftl_perfil.png" class="img-circle" alt="" />
					</div>
					<div class="info">
						<a href="#"><?php echo $_SESSION['username']; ?></a>
						<ul class="tools list-inline">
							<li><a href="#" data-toggle="tooltip" title="Rango"><?php global $db; $rangos = $db->query("SELECT * FROM ranks WHERE id = '{$user['rank']}' "); $myrank = $rangos->fetch_array();  echo $myrank['name']; ?></a></li>
						</ul>
					</div>
					<a href="/me" class="button"><img src="{HK}/templates/images/turnoff.png" width="20" height="20" alt="Salir" /></a>
				</div>
				<div class="title">Navegaci&oacute;n</div>
					<ul class="nav-sidebar">
						<li <?php if($zone == 'Bienvenido'){ echo 'class="active"'; }else{ echo 'class="desactive"'; } ?>>
                            <a href="{HK}">
                                <i class="fa fa-home"></i> <span>Bienvenido</span>
                            </a>
                        </li>
                        <li <?php if($zone == 'Reportes'){ echo 'class="active"'; }else{ echo 'class="desactive"'; } ?>>
							<a href="{HK}/reportes.php">
								<i class="fa fa-bug"></i> <span>Reportes</span>
								<span class="label pull-right"><?php echo $cntr; ?></span>
							</a>
						</li>
						<li <?php if($zone == 'Configuraci&oacute;n Inicial'){ echo 'class="active"'; }else{ echo 'class="desactive"'; } ?>>
                            <a href="{HK}/config.php">
                                <i class="fa fa-cog"></i> <span>Configuraci&oacute;n Inicial</span>
                            </a>
                        </li>
                        <li <?php if($zone == 'Configuraci&oacute;n del Hotel'){ echo 'class="active"'; }else{ echo 'class="desactive"'; } ?>>
                            <a href="{HK}/configs.php">
                                <i class="fa fa-cogs"></i> <span>Configuraci&oacute;n del Hotel</span>
                            </a>
                        </li>
                        <li <?php if($zone == 'Banear' || $zone == 'Dar Rango' || $zone == 'Revisar Clones' || $zone == 'Editar Usuario' || $zone == 'Dar Placa' || $zone == 'Dar Recursos'){ echo 'class=" nav-dropdown active"'; }else{ echo 'class="nav-dropdown"'; } ?>>
                            <a href="#">
                                <i class="fa fa-users"></i> <span>Gesti&oacute;n de Usuarios</span>
                                <i class="fa fa-caret-right pull-right"></i>
                            </a>
                            <ul>
                                <li><a href="{HK}/bans.php">Banear / Desbanear</a></li>
                                <li><a href="{HK}/clones.php">Clones</a></li>
                                <li><a href="{HK}/badges.php">Dar / Quitar Placa</a></li>
								<li><a href="{HK}/ranks.php">Dar / Bajar Rango</a></li>
                                <li><a href="{HK}/resources.php">Dar / Quitar Recursos</a></li>
                                <li><a href="{HK}/users.php">Editar Usuario</a></li>
                            </ul>
                        </li>
						<li <?php if($zone == 'Subir Placas'){ echo 'class=" nav-dropdown active"'; }else{ echo 'class="nav-dropdown"'; } ?>>
                            <a href="#">
                                <i class="fa fa-wrench"></i> <span>Acciones</span>
                                <i class="fa fa-caret-right pull-right"></i>
                            </a>
                            <ul>
                                <li><a href="{HK}/subir.php">Subir Placas</a></li>
                            </ul>
                        </li>
						<li <?php if($zone == 'Subir Placas a la Tienda' || $zone == 'Subir Rares a la Tienda'){ echo 'class=" nav-dropdown active"'; }else{ echo 'class="nav-dropdown"'; } ?>>
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i> <span>Tienda</span> 
                                <i class="fa fa-caret-right pull-right"></i>
                            </a>
							<ul>
                                <li><a href="{HK}/upbadges.php">Agregar Placas</a></li>
                                <li><a href="{HK}/uprares.php">Agregar Rares</a></li>
                            </ul>
                        </li>
                       <li <?php if($zone == 'Noticiones' || $zone == 'Promos'){ echo 'class=" nav-dropdown active"'; }else{ echo 'class="nav-dropdown"'; } ?>>
                            <a href="#">
                                <i class="fa fa-calendar"></i> <span>Noticias</span> 
                                <i class="fa fa-caret-right pull-right"></i>
                            </a>
							<ul>
                                <li><a href="{HK}/promos.php">Promos</a></li>
                            </ul>
                        </li>
                       <li <?php if($zone == 'Ausencias del Equipo'){ echo 'class="active"'; }else{ echo 'class="desactive"'; } ?>>
							<a href="{HK}/aus.php">
								<i class="fa fa-user-times"></i> <span>Ausencias</span>
							</a>
						</li>
                         <li <?php if($zone == 'Logs de la CMS' || $zone == 'Logs del Emulador'){ echo 'class=" nav-dropdown active"'; }else{ echo 'class="nav-dropdown"'; } ?>>
                            <a href="#">
                                <i class="fa fa-tasks"></i> <span>Logs</span>
                                <i class="fa fa-caret-right pull-right"></i>
                            </a>
                            <ul>
                                <li><a href="{HK}/logscms.php">CMS</a></li>
                                <li><a href="{HK}/logsemu.php">Emulador</a></li>
                            </ul>
                        </li>
                    </ul>
					<div class="widget">
						<div class="list">
							<div class="title">Staff's en L&iacute;nea <a href="#" class="pull-right"><i class="fa fa-shield"></i></a></div>
							<?php 	global $db;
								$search = $db->query("SELECT * FROM users WHERE rank >= 3");
								if($search->num_rows > 0){
									while($inform = $search->fetch_array()){?>
										<ul style="width:100%;margin-left:-20px;">
											<img src="/yezz/images/dftl_perfil.png" alt="avatar" class="pull-left" />
											<div class="name"><?php echo $inform['username']; ?></div>
											<i class="fa fa-circle <?php if($inform['online'] == 1){ echo 'color-green-500'; }else{ echo 'color-red-500'; } ?> margin-right-5 font-size-10 pull-right"></i> 
										<br><br></ul>
							<?php } }else{ echo '<i>No Usuarios con rango</i>'; } ?>
							<div class="footer">
								<input type="text" class="form-control" Placeholder="Buscar..." />
							</div>
						</div>
					</div>
			</div>
        </div>
        <div class="rightside bg-grey-100">
            <div class="page-head bg-grey-100">
				<h1 class="page-title"><?php echo $zone; ?><small>Bienvenido a la Administraci&oacute;n</small></h1>
				<div id="bs-daterangepicker" class="btn bg-grey-50 padding-10-20 no-border color-grey-600 pull-right border-radius-25 hidden-xs no-shadow"><i class="fa fa-calendar-o"></i> Hoy es <?php setlocale(LC_TIME,"spanish"); echo utf8_encode(strftime("%A %d de %B del %Y", time())); ?></div>
			</div>
            <div class="container-fluid">
			{ERROR}<br>
	<!-- END CONTENT -->
	<script src="{HK}/templates/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="{HK}/templates/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="{HK}/templates/js/holder.js"></script>
	<script src="{HK}/templates/js/pace.min.js" type="text/javascript"></script>
	<script src="{HK}/templates/js/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="{HK}/templates/js/core.js" type="text/javascript"></script>
	<!-- dashboard -->
	<script type="text/javascript">
		maniac.loadchart();
		maniac.loadvectormap();
		maniac.loadbsslider();
		maniac.loadrickshaw();
		maniac.loadcounter();
		maniac.loadprogress();
		maniac.loaddaterangepicker();
	</script> 
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>