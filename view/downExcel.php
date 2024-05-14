<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if (isset($_SESSION['usuario'])) {

    require 'header.php'; 
    require 'footer.php';
    require '../Funciones/funcionalidades.php';
    $Func = new Funciones;
	date_default_timezone_set("America/Bogota");
	$mesmaximo = date('Y-m-d');

	 

?>

<style>
	.table-containter{ max-width: 100%; max-height: 400px; overflow-x: scroll; }  
</style>

<div class="container">
    <div class="text-right mt-3">
		<div class="row">
		    <div class="col-md-12">
		    	<ul class="list-group list-group-horizontal">
				  <a style="text-decoration:none" href="index.php"><li class="list-group-item list-group-item-success">Menú principal</li></a> 
				  <li class="list-group-item list-group-item"><strong>Descargar Información.</strong></li>
				</ul>
			</div> 
		</div>
	</div>
</div>   
<div class="text-right mt-5"></div>

<!-- Tabla de exportacion excel -->  
	<form method="POST" action="de.php">
		<div class="container">
			<div class="mt-3">
				<div class="row">
				<div class="col-md-4">
    <div class="form-group">
        <input id="fecha1" type="date" name="fecha1" class="form-control" value="<?php echo $fecha1 ?>" min='2022-01-01' max='2024-12-01' required>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <input id="fecha2" type="date" name="fecha2" class="form-control" value="<?php echo $fecha2 ?>" min='2022-01-01' max='<?php echo $mesmaximo ?>' required>
    </div>
</div>	
					<div class="col">
						<input  style="width: 100%" class="btn btn-success" type="submit" name="GenerarInforme" value="Buscar">
					</div>
				</div>		
			</div> 
		</div>
	</form>

	<script>
    // Obtener referencia a los elementos de fecha
    var fecha1Input = document.getElementById("fecha1");
    var fecha2Input = document.getElementById("fecha2");

    // Establecer el atributo min de fecha2 al valor seleccionado en fecha1
    fecha1Input.addEventListener('input', function() {
        fecha2Input.min = fecha1Input.value;
        // Restaurar el valor de fecha2 si es menor que el nuevo mínimo
        if (fecha2Input.value < fecha2Input.min) {
            fecha2Input.value = fecha2Input.min;
        }
    });
</script>
  
<?php }else{ ?>
	<script>
	    alert("Acceso Incorrecto");
	    window.location.href="../login.php"; 
	</script>
<?php }