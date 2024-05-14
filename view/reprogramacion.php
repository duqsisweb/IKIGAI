<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);
if (isset($_SESSION['usuario'])) {
    require 'header.php'; 
    require 'footer.php';
    require '../Funciones/funcionalidades.php';
    $Func = new Funciones;

    $añoInicial = $_POST['añoInicial'];
	$añofinal = $_POST['añofinal'];

    if($añoInicial > $añofinal) {
		$FechaAlterna = $añoInicial;
		$añoInicial = $añofinal;
		$añofinal = $FechaAlterna;
	}

?>

<div class="container">
    <div class="text-right mt-4">
		<div class="row">
		    <div class="col-md-12">
		    	<ul class="list-group list-group-horizontal">
				  <a style="text-decoration:none" href="index.php"><li class="list-group-item list-group-item-success">Menú principal</li></a>
				  <li class="list-group-item list-group-item">ver capacitaciones</li>
				</ul>
			</div> 
		</div>
	</div>
</div>

<form action=""  method="POST">
    <div class="container">
        <div class="text-right mt-1">
            <div class="row"> 
                <div class="col-md-12">
                    <h3 align="center">Filtrar Capacitaciones para reprogramar</h3>
                </div>

                <div class="col-md-12">
                    <hr><br>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha inicio <font color="red"><strong>*</strong></font> </label>
                        <input type="date" class="form-control" name="añoInicial" min="" required>
                    </div> 
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                       <label>Fecha final <font color="red"><strong>*</strong></font> </label>
                       <input type="date" class="form-control" name="añofinal" required>
                    </div> 
                </div> 

                <div class="col-md-4">
                    <div class="form-group">
                        <center><input name="Verprog" style="width: 100%; height: 40px; margin-top:22px;" class="btn btn-success" type="submit" value="Buscar"/></center>
                    </div> 
                </div>
    	 	</div>
    	 </div>
</form>

<?php if (isset($_POST['Verprog'])) { ?>
    
    <form action="popup/VerReProgramacionCap.php" target="popup" onsubmit="window.open('', 'popup', 'width = 2000, height = 1200')" method="POST">
		<div class="container">
		    <div class="text-right mt-5">
				<div class="row">
				    <div align="center" class="col-md-6">
				    	<strong>Año: </strong> <?php echo $Anio ?>
				    </div>
				    <div align="center" class="col-md-6">
				    	<strong>Mes: </strong> <?php echo $Func->ListMeses(2, $Mes) ?>
				    </div> 
				    <div class="col-md-12">
				    	<br>
				    </div>
				    <div class="col-md-12">
				    <table align="center" style="width: 100%">
						<tr>
							<td bgcolor="#198754" align='center'><font color="white"><strong>✔</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Capacitacion</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Capacitador</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Año</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Mes</strong></font></td>
							<td bgcolor="#198754" align='center'><font color="white"><strong>Total Reprogramados</strong></font></td>
						</tr>
					
                        <?php foreach ($Func->CAPACITACIONESREPRO($añoInicial, $añofinal) as $a){
                            echo "<tr align='center'>
                            <td><div class='form-group'>
                                    <div class='form-check'>
                                        <input required class='form-check-input radioNPro' type='radio' value='".$a['NROPROG']."' name='NROPROG'>
                                    </div>	
                                </div>
                            </td>
                            <td>".utf8_encode($a['CAPACITACION'])."</td>
                            <td>".utf8_encode($a['CAPACITADOR'])."</td>
                            <td>".utf8_encode($a['ANIO'])."</td>
                            <td>".utf8_encode($a['MES'])."</td>
                            <td>".utf8_encode($a['CANTIDAD'])."</td>
                            <input id='cantidad' type='hidden' value='".$a['CANTIDAD']."' name='CANASIST'>
							</tr>";	
						} ?> 
			</table>                                                          
		</div>
        <?php if (count($Func->CAPACITACIONESREPRO($añoInicial, $añofinal)) !== 0) { ?>
            <div class="col-md-12 mt-5">
                <center><input name="cargarCapac" style="width: 100%; margin-top: 30px;" class="btn btn-success" type="submit" value="¡Cargar Información!"/>
            </div>
            <div class="form-group mt-5"">	
                <button id="btnDescargar"  onclick="actualizarVentana()" class="btn btn-success">Actualizar Ventana</button></center>	
            </div>  
        <?php }else{ ?>
            <div class="alert alert-danger" style="margin-top: 50px;" role="alert" align="center">No hay información disponible para cargar</div>
        <?php } ?>
	</form>

    <script>
		function actualizarVentana(){
			location.reload();
        }
	</script>

<?php } else { ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-success" style="margin-top: 50px;">
		<div class="container">
			<center><a class="navbar-brand">Consulta las capacitaciones por fechas</a> </center>
		</div>
    </nav> 
    
<?php } ?>

<?php }else{ 
?><script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href="../login.php"; 
</script><?php 
}
?>