$(function(){
	$('#search_form').submit(function(e){
		e.preventDefault();
	})

	$('#search').keyup(function(){
		var envio = $('#search').val();

		$('#resultado').html('<center><h3>Buscando...</h3></center>');

		$.ajax({
			type: 'POST',
			url: '/functions.php',
			data: ('search='+envio),
			success: function(resp){
				if(resp!=""){
					$('#resultado').html(resp);
				}
			}
		})
	})
})