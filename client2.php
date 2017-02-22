<div class="client__buttons">
                <button onclick="javascript:window.open('/')" ng-click="close()" class="client__close"><span class="client__close__text" translate="CLIENT_TO_WEB_BUTTON">INÍCIO</span></button>
                 				<button onclick="toggleFullScreen()" class="client__fullscreen"><i show-if-fullscreen="false" class="client__fullscreen__icon icon--fullscreen"></i>
								<i id="fullscreen-button-a-icon"></i></button>
        				<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<style>
.oculto {display: none;}

#boton-escondido {
	display: none;
    left: 0px;
    top: 10px;
    position: fixed;
}

a {
	color: #fc6204;
}

#embed-topbar {
	background-color: rgba(34, 34, 31, 0.77);
    background-position: 65px 10px;
    background-repeat: no-repeat;
    border-top-right-radius: 40px;
    border-bottom-right-radius: 40px;
    position: fixed;
    left: 0px;
    top: 50px;
    overflow: hidden;
    opacity: 0.96;
    width: 260px;
    height: 260px;
}

#cerrar {
	color: white;
    float: right;
    text-decoration: none;
    margin-top: 14px;
    margin-left: -45px;
    z-index: 999999;
}
</style>
<div id="reproductor">
	<a id="boton-escondido" style="display:none;left:0px;top:50px;position:fixed;" href="javascript:void(0);" onclick="showtopbar();"><img src="http://i.imgur.com/6l28pIY.gif"></a>
	<div id="embed-topbar">
	  <a id="boton-esconder" href="javascript:void(0);" onclick="hidetopbar()"><img src="http://i.imgur.com/nffOtvN.gif"></a>
	  
	  <a id="cerrar" title="Cerrar radio" style="color:white;float:right;text-decoration:none;margin-top: 18px;margin-left:-45px;z-index: 999999;" href="javascript:void(0);" onclick="document.getElementById('embed-topbar').className = 'oculto'">
	   <img src="http://i.imgur.com/uChC4jz.png" style="z-index:10000;margin-left: -31px;">
	  </a>
	<br>

	<div id="player" style="margin-top: -42px;margin-left: 21px;">
	 
	
<embed pluginspage="http://www.adobe.com/go/getflashplayer"src="http://toplatino.net/players/toplatino.swf" width="160" height="240" wmode="transparent"type="application/x-shockwave-flash" allowscriptaccess="always"></embed>
<script>
var audio = document.getElementById('stream');
audio.volume = 1.0;
</script>
	</div>

	</div>
<script>
function hidetopbar() {
 
  $("#embed-topbar").animate({
  left: -$("#embed-topbar").width() + "px"
  }, 1000);
 }

function showtopbar() {
 
  $("#embed-topbar").animate({
  left: "0px"
  }, 1000);
 }

$("#boton-escondido").click(function(){
    $("#boton-escondido").hide();
    $("#boton-esconder").show();
});

$("#boton-esconder").click(function(){
	setTimeout(function(){ jQuery("#boton-escondido").show(); }, 900);
});

$("#cerrar").click(function(){
    $("#reproductor").remove();
});
</script>
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>
  $(document).ready(function(){
    setInterval(function(){
     $("#count,#rooms").fadeOut();
     $(".toolbar-client").load('/count');
     $("#count,#rooms").fadeIn();
    },60000);
    
   setTimeout(function(){
  $("div.ads").fadeOut(55000, function () {
  $("div.ads").remove();
      });
   
}, 20000);
 });
  </script>
   
<script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>
  $(document).ready(function(){
   setTimeout(function(){
  $("div.ads").fadeOut(55000, function () {
  $("div.ads").remove();
      });
   
}, 70000);
 });
  </script>				<style>.icon--fullscreen {background-image: url(assets/images/sprite.png);background-position: -141px -446px;width: 15px;height: 14px}.client__buttons button:active,.client__buttons button:hover,.register-banner__button:active,.register-banner__button:hover {border-bottom-width: 2px;border-bottom-style: solid}.client-closed,.register-banner__wrapper {display: -webkit-flex;display: -ms-flexbox}.register-banner__wrapper {-webkit-align-items: center;-ms-flex-align: center;align-items: center;background-color: #25b8ee;display: flex;padding: 48px 12px;width: 100%}.client__buttons button,.register-banner__button {line-height: 1.2;border-radius: 5px;margin-bottom: 4px;border-width: 2px;border-style: solid;text-align: center;text-transform: uppercase}@media (min-width: 767px) {.register-banner__title {margin-top: 0}}.register-banner__button {box-shadow: 0 3px 0 1px rgba(0, 0, 0, .3);display: inline-block;background-color: #00813e;border-color: #8eda55;color: #fff;font-size: 32px;padding: 12px 24px;width: 100%}.client {left: -9999px}.client--visible {left: 0}.client__buttons {left: 12px;position: absolute;top: 12px;z-index: 630}.client__buttons button {box-shadow: 0 3px 0 1px rgba(0, 0, 0, .3);background-color: #ffb900;border-color: #ffea00;color: #000;font-size: 12px;padding: 6px 12px;display: block;float: left}.client__buttons button:hover {background-color: #ffd400;border-color: #fffd70}.client__buttons button:active,.client__buttons button:disabled {background-color: #f89400;border-color: #ffce37}.client__buttons button:active {box-shadow: 0 1px 0 1px rgba(0, 0, 0, .3);-webkit-transform: translate(0, 2px);transform: translate(0, 2px)}.client-reload__button,.photo-delete {box-shadow: 0 3px 0 1px rgba(0, 0, 0, .3)}.client__buttons button:first-child,.client__buttons button:not(:first-child):not(:last-child) {border-bottom-right-radius: 0; border-top-right-radius: 0}.client__buttons button:last-child,.client__buttons button:not(:first-child):not(:last-child) {border-bottom-left-radius: 0;border-top-left-radius: 0}.client__buttons button:not(:last-child) {margin-right: 4px}.client__buttons .client__close {padding: 4.5px 6px}.client__buttons .client__fullscreen {padding-left: 6px;padding-right: 6px}.client__close__text {position: relative;padding-left: 22px;line-height: 17px}.client-closed,.client-error {-webkit-align-items: center;padding: 48px 12px}.client__close__text:before {background-image: url(assets/images/sprite.png);background-position: -223px -156px;width: 16px;height: 16px;content: '';display: block;margin-top: -8px;position: absolute;top: 50%;left: 0}.client__close__text:active,.client__close__text:hover{border-bottom-style: solid;border-bottom-width: 0}.client__fullscreen__icon {display: block}
                </style>
				<script>
            function toggleFullScreen()
            {
                if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
                (!document.mozFullScreen && !document.webkitIsFullScreen))
                {
                    if (document.documentElement.requestFullScreen)
                    {  
                        document.documentElement.requestFullScreen();  
                    }
                    else if (document.documentElement.mozRequestFullScreen)
                    {  
                        document.documentElement.mozRequestFullScreen();  
                    }
                    else if (document.documentElement.webkitRequestFullScreen)
                    {  
                        document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
                    }  
                }
                else
                {  
                    if (document.cancelFullScreen)
                    {  
                        document.cancelFullScreen();  
                    }
                    else if (document.mozCancelFullScreen)
                    {  
                        document.mozCancelFullScreen();  
                    }
                    else if (document.webkitCancelFullScreen)
                    {  
                        document.webkitCancelFullScreen();  
                    }  
                } 
            }
        </script>

				</div>
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

<title><?php echo $data['hotelname']; ?> ~ Cliente</title> 
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
<link rel="shortcut icon" href="<?php echo CDN; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
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
 
<meta name="description" content="HabboCash is a virtual world where you can meet and make friends. Make friends, join the fun, get noticed!" />
<meta name="keywords" content="nillus, ragezone, retro, keep it real, private server, free, credits, habbo hotel , virtual, world, social network, free, community, avatar, chat, online, teen, roleplaying, join, social, groups, forums, safe, play, games, online, friends, teens, rares, rare furni, collecting, create, collect, connect, furni, furniture, pets , room design, sharing, expression, badges, hangout, music, celebrity, celebrity visits, celebrities, mmo, mmorpg, massively multiplayer" />

<!DOCTYPE html>
<html lang="es_ES">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />


        <meta name="description" content="Diversión al limite!" />
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        
        <style type="text/css"> 
            * { margin: 0; padding: 0; }
            html, #flash-container { height: 100%; text-align: left; background-color: black; }
            #flash-container { position: absolute; overflow: hidden; left: 0; top: 0; right: 0; bottom: 0; }
        </style>


        <script type="text/javascript">
    FlashExternalInterface.loginLogEnabled = false;
   
    FlashExternalInterface.logLoginStep("web.view.start");
   
    if (top == self) {
        FlashHabboClient.cacheCheck();
    }
        var flashvars = {
            "client.allow.cross.domain": "1",
                "client.notify.cross.domain": "0",
                "connection.info.host": "<?php echo $data['host']; ?>",
                "connection.info.port": "<?php echo $data['port']; ?>",
                "site.url": "<?php echo PATH; ?>/clienterror",
                "url.prefix": "<?php echo PATH; ?>/",
                "client.reload.url": "<?php echo PATH; ?>/client.php",
                "client.fatal.error.url": "<?php echo PATH; ?>/client",
                "client.connection.failed.url": "<?php echo PATH; ?>/client",
                "external.variables.txt": "<?php echo $data['external_variables']; ?>",
                "external.texts.txt": "<?php echo $data['external_texts']; ?>",
                "productdata.load.url": "<?php echo $data['productdata']; ?>",
                "furnidata.load.url": "<?php echo $data['furnidata']; ?>",
                "use.sso.ticket": "1",
                "sso.ticket": "<?php echo $ticket; ?>",
                "processlog.enabled": "1",
                "account_id" : "<?php echo $Functions->Get('id'); ?>", 
                "client.starting" : "¡Por favor, espera <?php echo $Functions->Get('username'); ?>! <?php echo $data['hotelname']; ?> se está cargando", 
                "flash.client.url": "<?php echo $data['flash_client_url']; ?>",
                "user.hash" : "5690170255dbf26e0275377f436614c91d1a810d", 
                "has.identity": "1",
                "flash.client.origin": "popup",
                "forward.type" : "2",
                "forward.id" : "0"
            };
    var params = {
            "base" : "<?php echo $data['flash_client_url']; ?>",
            "allowScriptAccess" : "always",
            "menu" : "true"                
    };
   
    if (!(HabbletLoader.needsFlashKbWorkaround())) {
        params["wmode"] = "opaque";
    }
    
    FlashExternalInterface.signoutUrl = "<?php echo PATH; ?>/me.php";
 
    var clientUrl = "<?php echo $data['habbo_swf']; ?>";
    swfobject.embedSWF(clientUrl, "flash-container", "100%", "100%", "10.0.0", "http://localhost/gallery/web-gallery/flash/expressInstall.swf", flashvars, params);
 
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
        <div id="flash-container">
        </div>
    </body>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-3024459785592755",
    enable_page_level_ads: true
  });
</script>
<?php } } else{ echo '<i>No se encuentra la tabla cms_settings</i>'; }?>
</html>
<?php ob_end_flush(); ?>