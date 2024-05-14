$(buscar_datos());

function buscar_datos(consulta){
	$.ajax({
		url:'buscar.php',
		type: 'POST',
		dataType:'php',
		data:{consulta: consulta},
		})
	.done(function(respuesta)){
		$("#datos").php(respuesta);
	}
	.fail(function){
		console.log("error");
	}
}