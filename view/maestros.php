<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if (isset($_SESSION['usuario'])) {
    require 'header.php'; 
    require 'footer.php';
    require '../Funciones/funcionalidades.php';
    $Func = new Funciones;
?>

	<div class="container">
		<div class="text-right mt-5">
			<div class="row">
				<div class="col-md-12">
					<ul class="list-group list-group-horizontal">
					<a style="text-decoration:none" href="index.php"><li class="list-group-item list-group-item-success">Menú principal</li></a>
					<li class="list-group-item list-group-item">Maestros</li>
					</ul>
				</div> 
			</div>
		</div>
	</div>

    <div class="container">
        <div class="text-right mt-5">
            <div class="row"> 

                <div align="center" class="col-md-6">
                	<div class="card text-white bg-success mb-3" style="max-width: 80%;">
					  <div class="card-header">Cargar información a maestros</div>
					  <div class="card-body">
					  	<form action="popup/aggArea.php" target="popup" onsubmit="window.open('', 'popup', 'width = 800, height = 900')" method="GET">
					    	<p class="card-text">Agregar información para el correcto funcionamiento del sistema</p> 
                    		<center><input name="aggArea" style="width: 100%" class="btn btn-success" type="submit" value="¡Ir al modulo!"/></center>
					    </form>
					  </div>
					</div>
    			</div>

                <div align="center" class="col-md-6">
                	<div class="card text-white bg-success mb-3" style="max-width: 80%;">
					  <div class="card-header">Ver Información de maestros</div>
					  <div class="card-body">
					  	<form action="viewMaestros.php" method="POST">
					    	<p class="card-text">Ver las diferentes informacion cargadas al sistema.</p> 
                    		<center><input name="Verprog" style="width: 100%" class="btn btn-success" type="submit" value="¡Ir al modulo!"/></center>
					    </form>
					  </div>
					</div>
    			</div>

    		</div>
    	</div>
    </div>


<?php }else{ 
?><script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href="../login.php"; 
</script><?php 
}