<?php 	
include 'con_palmerdb.php';	
if (isset($_POST['Crear'])) {	
	$OPCION = utf8_decode($_POST['OPCION']);	
	$TIPOOPCION = $_POST['TIPOOPCION'];	

	$aggAra = "INSERT INTO PLATCAPACITACIONES..OpcionesProgramacion (OPCION, TIPOOPCION) VALUES ('$OPCION', $TIPOOPCION)";	
	$Dato=odbc_exec($conexion, $aggAra);	
	if ($Dato) {	
		?><script languaje="javascript">	
		    alert("¡Se creo con exito el elemento <?php echo $OPCION ?>!");	
			setTimeout(function(){	
		        window.close();	
		    },500); //Dejara un tiempo de 3 seg para que el usuario vea que se envio el formulario correctamente	
		</script><?php	
	}else{	
		echo $aggAra;	
		?>	
		<script languaje="javascript">	
			alert("¡Algo ocurrio, intentalo de nuevo!");	
			setTimeout(function(){	
		        window.close();	
		    },500); //Dejara un tiempo de 3 seg para que el usuario vea que se envio el formulario correctamente	
		</script><?php	
	}	
}	
