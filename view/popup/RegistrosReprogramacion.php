<?php 
header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>	
	<html lang="en">	

	<head>	
		<meta charset="utf-8" />	
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />	
		<meta name="description" content="Plataforma de capacitaciones para Gestion Humana" />	
		<link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
		<meta name="author" content="José Luis Casilimas Martinez" />	
		<title>Plataforma de Capacitaciones</title>	
		<link rel="icon" type="image/x-icon" href="../assets/Icono.ico" />	
		<link href="../../css/styles.css" rel="stylesheet" />	
    </head>	
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">	
	<div class="container">	
		<center><a class="navbar-brand">Reprogramaciones del empleado</a></center>	
	</div>	
</nav> 	
<div class="container">	
    <div class="text-right mt-5">	
        <div class="row">	
            <?php	
            error_reporting(0);	
            session_start();	

            if (isset($_POST['dataInfo'])) {	
                $usu = $_SESSION['usuario'];	
                require '../../Funciones/funcionalidades.php';	
                $Func = new Funciones;	

                $NROPROG = $_POST['NROPROGEMPL'];	
                $CODEMPLEADO = $_POST['CODEMPLEADOEMPL'];	

                if ($Func->infoReprogEmpleado($NROPROG , $CODEMPLEADO) != 0) {
            ?>	
                <div class="col-md-12"><br></div>	
                <div class="col-md-12">	
                    <table class="table table-bordered" cellspacing="0" id="tablaprueba">	
                       
                        <tr align="center">	
                            <td><strong>CC</strong></td>	
                            <td><strong>NOMBRE</td>	
                            <td><strong>CARGO</strong></td>	
                            <td><strong>NOTA</strong></td>	
                            <td><strong>OBSERVACIONES</strong></td>	
                            <td><strong>FECHA DE PRESENTACION</strong></td>	
                        </tr>	
                        <?php	
                        $NotaAprueba = 0;	
                        foreach ($Func->infoReprogEmpleado($NROPROG , $CODEMPLEADO) as $a) {	
                           ($a['NOTA'] >= 35.00) ? $icon =  "✅" : $icon = '⛔';	
                           
                            echo "<tr>	
                                <td align='right'>" . $a['CODIGO'] . "</td>	
                                <td>" . utf8_encode($a['NOMBRE']) . "</td>	
                                <td>" . utf8_encode($a['CARGO']) . "</td>	
                                <td align='center'>" . number_format(round($a['NOTA'], 1), 1) . " " . $icon . "</td>	
                                <td>" . utf8_encode($a['Observacion']) . "</td>
                                <td>" .$a['FECHAMOD']. "</td>
                            </tr>";	
                        }?>	
                    </table>	
                </div>	
                <?php } else { ?>
                    <div  class="alert alert-warning" role="alert" align="center">Este usuario no tiene un registro de notas</div>	
                <?php } 
            } ?>	
        </div>	
               
        <section class="mt-5">
            <button id="btnDescargar" onclick="CerrarVentana()" class="btn btn-success">Cerrar Ventana</button>
        </section>
            
        <div class="text-right mt-5">
    </div>	
</div>	 

<script>
    function CerrarVentana(){
        window.close();
    }
</script>
