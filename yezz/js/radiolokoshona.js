var check = false;

function updateMusic(start){
	if(check)
		return;
	
	check = true;
	$("#locutor").html(" ");
	$("#programa").html("Cargando...");
	$("#ouvintes").html(" ");
	$.get('/api/radio/getStats?lok=1', function(data) {
		$("#locutor").html(data.locutor);
		$("#programa").html(data.current_song);
		$("#ouvintes").html(data.listeners_now);
		
		setTimeout(function(){ check = false }, 2000);
	}, 'json');
	
}

 
$(document).on('click', "#reload-btn", function(){
	updateMusic(true);
});

function doDraggable(){
	$("#player").draggable({
		axis:"x",containment:"#area_player",scroll:false,handle:".handle"
	});
}

$(document).on('click', ".o-c", function(){
	$("#player").toggleClass("minimize");
});

$(document).on('click', ".play", function(){
	updateMusic(true);
	$(".play").toggleClass("pause");
});

$(document).ready(function () {
	updateMusic(1);
    doDraggable();
});
$(document).ajaxComplete(function () {
    doDraggable();
});

var Player = {
	toggleP:function(){
		if ($('#audio').hasClass('pause') === true){
			$src=$('#audio').attr('src');
			$("#demo").html();
			$("#demo").html('<audio id="audio" src="'+$src+'" ></audio>');
			
			var currentVolume = ($('#volumeHidden').html())/100;
			$("#audio").prop("volume", currentVolume).trigger('play');

		}else{
			$("#audio").trigger("pause");
			$("#audio").addClass('pause');
		}
	}

}
var Alert = {
	show: function(time, html, minimeizeDiv, minimeizeClass){
		$("#alertContent").html(html);
		$("#player-alert").removeClass('minimize-alert');
		setTimeout(function(){ 
			$("#alertContent").html("");
			$("#player-alert").addClass('minimize-alert');
			$(minimeizeDiv).addClass(minimeizeClass);
			$(".player").fadeIn('fast');
		}, time);

	}
}

$(function(){
	$("#pedidos-btn").click(function() {
		$("#player-pedidos").removeClass('minimize-pedidos');
		$("#pedido-submit").prop("disabled",false).html("Enviar");
		$("#Pedido").val("");
		$(".player").fadeOut('fast');
	});
	$("#pedidos-form").submit(function() {
		$("#pedido-submit").prop("disabled",true).html("Cargando...");
		$.ajax({
			type: 'post',
			url: 'player/php/all.php?func=pedir',
			data: {
			'usuario': $("#nick-pedido").val(),
			'pedido':$("#pedido").val(),
			'locutor': $("#locutor").html()
			},
			success: function(data){
				if(data == 1){
					Alert.show("3000","<b>Por favor espera 5 minutos para otro pedido</b>","#player-pedidos","minimize-pedidos");
				}else if(data == 2){
					Alert.show("3000","<b>Pedido enviado!</b>","#player-pedidos","minimize-pedidos");
				}else{
					Alert.show("3000","<b>Error Interno</b>","#player-pedidos","minimize-pedidos");
				}
			}
		});
		return false;
	});
	$("#pedidos-voltar").click(function(){
		$("#player-pedidos").toggleClass("minimize-pedidos");
		$(".player").fadeIn('fast');
	});

	$("#presenca-btn").click(function() {
		$("#player-presenca").removeClass('minimize-presenca');
		$("#presenca-submit").prop("disabled",false).html("Enviar");
		$("#codigo").val("");
		$(".player").fadeOut('fast');
	});
	
	$("#presenca-voltar").click(function(){
		$("#player-presenca").toggleClass("minimize-presenca");
		$(".player").fadeIn('fast');
	});
	
	$("#volume > #barra").slider({
		min: 0,
		max: 100,
		value: 100,
		range: "min",
		animate: true,
		slide: function(event, ui) {
			var currentVolume = (ui.value)/100;
			$("#volumeHidden").html(ui.value);
			$("#audio").prop("volume", currentVolume);
		}
	});


});