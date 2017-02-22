
<?php
    ob_start();
    require_once 'global.php';
    $Functions->Logged("true");
	$myusername = $_SESSION['username'];
	$ticket = $Functions->GenerateTicket(); 
	$query = $db->query("UPDATE users SET  auth_ticket = '{$ticket}', ip_last = '" . USER_IP . "', last_used = '". time() ."' WHERE username = '" . $myusername . "'");
	$users = $db->query("SELECT rank FROM users WHERE username = '" . $myusername . "'");
	$user = $users->fetch_array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<?php global $db;$result = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1");if($result->num_rows > 0){while($data = $result->fetch_array()){ ?> 

<title>Divertete al m&aacute;ximo, encuentra nuevas amistades, &iexcl; Bienvenido! - <?php echo $data['hotelname']; ?></title> 
<script type="text/javascript"> 
		var andSoItBegins = (new Date()).getTime();
		var ad_keywords = "";
		document.habboLoggedIn = true;
		var habboName = "<?php echo $_SESSION['username']; ?>";
		var habboReqPath = "<?php echo PATH; ?>";
		var habboStaticFilePath = "<?php echo CDN; ?>/web-gallery";
		var habboImagerUrl = "https://www.habbo.nl/habbo-imaging/";
		var habboPartner = "";
		var habboDefaultClientPopupUrl = "<?php echo PATH; ?>/client";
		window.name = "habboMain";
		if (typeof HabboClient != "undefined") { HabboClient.windowName = "uberClientWnd"; }
	</script>
	
<link rel="shortcut icon" type="image/x-icon" href="/yezz/img/favicon.ico"/>
<script src="<?php echo CDN; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo CDN; ?>/web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo CDN; ?>/web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo CDN; ?>/web-gallery/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo CDN; ?>/web-gallery/static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo CDN; ?>/web-gallery/styles/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CDN; ?>/web-gallery/styles/buttons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CDN; ?>/web-gallery/styles/boxes.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CDN; ?>/web-gallery/styles/tooltips.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CDN; ?>/web-gallery/styles/habboclient.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CDN; ?>/web-gallery/styles/habboflashclient.css" type="text/css" />
<script src="<?php echo CDN; ?>/web-gallery/static/js/habboflashclient.js" type="text/javascript"></script>
<script type="text/javascript">

document.oncontextmenu = function(){return false;}

</script>
    <link rel="stylesheet" type="text/css" href="/yezz/css/hotel.731d1960.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/yezz/js/radiolokoshona.js"></script>
    <link rel="stylesheet" type="text/css" href="/yezz/css/radiolokoshona.css">
	    <script type="text/javascript" src="/yezz/js/swfobject.js"></script>
 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="&iquest;Qu&eacute; esperas? Entra a {SHORTNAME}, podr&aacute;s encontrar amigos, crear tus salas, hacer cosas que nunca te imaginaste poder hacer..">
		<meta name="keywords" content="{SHORTNAME}, holos, habbo, habbo hotel, habbo pirata, habbo creditos, habbo latino, hlat, hlatino, habbolatino, habbo-hotel">
		<meta name="author" content="Edit Forbi">
		<meta property="og:url"           content="{PATH}" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="Bienvenido al hotel m&aacute;s grande de latinoam&eacute;rica - {SHORTNAME}" />
		<meta property="og:description"   content="Bienvenido a {SHORTNAME}, aqu&iacute; podr&aacute;s hacer amigos, crear tus salas, participar en eventos, a que esperas?" />
		<meta property="og:image"         content="{PATH}/yezz/images/yezz.png" />
		<meta property="og:image:width" content="470" />
		<meta property="og:image:height" content="300" />
		<meta property="fb:app_id" content="197133357372023" />
		<meta property="fb:admins" content="Forbi"/>
		<link rel="stylesheet" href="/yezz/css/load.css" style="text/css">
<script type="text/javascript">
function goLink(link)
{var link=link;window.location=link;}

$(window).load(function() {
	$('body').css({'overflow':'hidden'});
    $("#loadPage").delay(500).fadeOut("slow");
	$('body').css({'overflow':'visible'});
})
</script>
<span id="loadPage">
<br>
<center>
<img data-img="<?php global $db;$logo = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1");while($logo2 = $logo->fetch_array()){?><?php echo $logo2['logo'];?>" draggable="false" src="<?php echo $logo2['logo'];?>"><?php }?>	</center>
<br><br>
<div class="loader" id="loader">Cargando...</div>
</span>
        <script type="text/javascript">
    FlashExternalInterface.loginLogEnabled = false;
   
    FlashExternalInterface.logLoginStep("web.view.start");
   
    if (top == self) {
        FlashHabboClient.cacheCheck();
    }
        var flashvars = {
            "client.allow.cross.domain" : "0", 
            "client.notify.cross.domain" : "1", 
            "connection.info.host" : "<?php echo $data['host']; ?>", 
            "connection.info.port" : "<?php echo $data['port']; ?>", 
            "site.url" : "<?php echo PATH; ?>/client", 
            "url.prefix" : "<?php echo PATH; ?>/client", 
            "client.reload.url" : "<?php echo PATH; ?>/client", 
            "client.fatal.error.url" : "<?php echo PATH; ?>/client", 
            "client.connection.failed.url" : "<?php echo PATH; ?>/client", 
            "logout.url" : "<?php echo PATH; ?>/client", 
            "logout.disconnect.url" : "<?php echo PATH; ?>/client", 
            "external.variables.txt" : "<?php echo $data['external_variables']; ?>", 
            "external.texts.txt" : "<?php echo $data['external_texts']; ?>",
            "productdata.load.url" : "<?php echo $data['productdata']; ?>", 
            "furnidata.load.url" : "<?php echo $data['furnidata']; ?>",  
            "processlog.enabled" : "1", 
            "account_id" : "<?php echo $Functions->Get('id'); ?>",
            "client.starting.revolving" : "¡Por favor, espera <?php echo $Functions->Get('username'); ?>! <?php echo $data['hotelname']; ?> se está cargando /Para ciencia, \u00A1T\u00FA, monstruito!\/Cargando mensajes divertidos... Por favor, espera.\/\u00BFTe apetecen salchipapas con qu\u00E9?\/Sigue al pato amarillo.\/El tiempo es s\u00F3lo una ilusi\u00F3n.\/\u00A1\u00BFTodav\u00EDa estamos aqu\u00ED?!\/Me gusta tu camiseta.\/Mira a la izquierda. Mira a la derecha. Parpadea dos veces. \u00A1Ta-ch\u00E1n!\/No eres t\u00FA, soy yo.\/Shhh! Estoy intentando pensar.\/Cargando el universo de p\u00EDxeles.", 
            "flash.client.url" : "<?php echo $data['flash_client_url']; ?>", 
            "sso.ticket" : "<?php echo $ticket; ?>",
            "user.hash" : "5690170255dbf26e0275377f436614c91d1a810d", 
            "has.identity" : "1", 
            "flash.client.origin" : "popup", 
            "nux.lobbies.enabled" : "false", 
            "country_code" : "DO" 
            };
 
    var params = {
        "base" : "<?php echo $data['flash_client_url']; ?>",
        "allowScriptAccess" : "always",
        "menu" : "false"                
    };
   
    if (!(HabbletLoader.needsFlashKbWorkaround())) {
        params["wmode"] = "opaque";
    }
    
    FlashExternalInterface.signoutUrl = "<?php echo PATH; ?>/me.php";
 
    var clientUrl = "<?php echo $data['habbo_swf']; ?>";
    swfobject.embedSWF(clientUrl, "flash-container", "100%", "100%", "10.0.0", "<?php echo PATH; ?>gallery/web-gallery/flash/expressInstall.swf", flashvars, params);
 
    window.onbeforeunload = unloading;
    function unloading() {
        var clientObject;
        if (navigator.appName.indexOf("Microsoft") != -1) {
            clientObject = window["flash-container"];
        } else {
            clientObject = document["flash-container"];
        }
        try {
            clientObject.unloading();
        } catch (e) {}
    }
	</script>
	

    </head>
    <body>
	<div id="client-ui">

	<div id="area_player" style="top: 0;position: fixed;z-index: 2;">
		<div id="player" class="draggable ui-widget-content ui-draggable minimize" style="left: 380.313px; position: relative; top: 0px;">
			<div class="player_min">
				<div class="guy"></div>
				<div class="txt">Radio</div>
				<div class="handle ui-draggable-handle"></div>
				<div class="open o-c tip" title=""></div>
			</div>
			<div class="player">
				<div style="margin-left: 10px;margin-top: 40px;">
					<p id="demo">
						<audio autoplay src="https://radio.fresh-hotel.org/Capital" preload="auto" controls="controls"></audio>
					</p>
					
				</div>
				<div class="close o-c tip" title=""></div>
				<div class="handle ui-draggable-handle"></div>
			</div>
			
			
		</div>
	</div>
    <div id="flash-wrapper">
        <div id="flash-container">
            
        </div>
    </div>
    <div id="content" class="client-content"></div>
    <iframe id="page-content" class="hidden" allowtransparency="true" frameBorder="0" src="about:blank"></iframe>
</div>
    </body>
	
<?php } } else{ echo '<i>No se encuentra la tabla cms_settings</i>'; }?>
</html>
<?php ob_end_flush(); ?>