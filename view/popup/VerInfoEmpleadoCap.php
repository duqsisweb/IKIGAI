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
    <title>Ikigai</title>
    <link rel="icon" type="image/x-icon" href="../../assets/Icono.ico" />
    <link href="../../css/styles.css" rel="stylesheet" />
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <center><a class="navbar-brand">Detalle Por Empleado</a></center>
    </div>
</nav>
<div class="container">
    <div class="text-right mt-5">
        <div class="row">
            <?php
            error_reporting(0);
            session_start();

            if (isset($_POST['NROPROG'])) {
                $usu = $_SESSION['usuario'];
                require '../../Funciones/funcionalidades.php';
                $Func = new Funciones;

                $NROPROG = $_POST['NROPROG'];
                $CODEMPLEADO = $_POST['CODEMPLEADO'];

                $prueba = odbc_result($Func->CabCap($NROPROG), 'CAPACITACION');

                // $ClaseTotal = $Func->ClaseTotal($TotalPromedio); 
            ?>

                <div class="col-md-12"><br></div>
                <div class="col-md-12">
                    <table class="table table-bordered" cellspacing="0" id="tablaprueba">
                        <tr>
                            <td colspan="5" align="center"><strong>REGISTRO DE EVALUACION DE LA FORMACION POR EMPLEADO</strong></td>
                            <td>GHA -FT-35<br>Versión: 1<br>Fecha de Emisión: 29/03/2016</td>
                        </tr>
                        <tr>
                            <td colspan="6"><strong>Tipo de actividad: </strong> <?php echo odbc_result($Func->CabCap($NROPROG), 'CAPACITACION') ?></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha: </strong> <?php echo odbc_result($Func->CabCap($NROPROG), 'FECHA') ?></td>
                            <td><strong>Hora inicio: </strong><?php echo substr(odbc_result($Func->CabCap($NROPROG), 'HINICIO'), 0, 5) ?></td>
                            <td><strong>Hora finalizacion: </strong><?php echo substr(odbc_result($Func->CabCap($NROPROG), 'HFINAL'), 0, 5) ?></td>
                            <td colspan="7"><strong>Duracion: </strong><?php echo number_format(round(odbc_result($Func->CabCap($NROPROG), 'DURACION'), 2), 2) . " Horas"; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Lugar: </strong> <?php echo utf8_encode(odbc_result($Func->CabCap($NROPROG), 'LUGAR')) ?> </td>
                            <td colspan="5"><strong>Responsable: </strong> <?php echo utf8_decode(odbc_result($Func->CabCap($NROPROG), 'Capacit')) ?> (<strong>Nota: </strong><?php echo utf8_decode(odbc_result($Func->CabCap($NROPROG), 'Nota')) ?>) </td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Tipo de formacion: </strong> <?php echo utf8_encode(odbc_result($Func->CabCap($NROPROG), 'TFORM')) ?> </td>
                            <td colspan="4"><strong>Bitácora: </strong> <a target="_blank" id="btnDescargar" onclick="exportarExcel()" class="">¡Click para ver!</a></td>
                        </tr>
                        <tr>
                            <td colspan="6"><strong>Descripcion: </strong> <?php echo utf8_encode(odbc_result($Func->CabCap($NROPROG), 'DESCRIPCION')) ?> </td>
                        </tr>
                        <tr align="center">
                            <td><strong>NOMBRE</td>
                            <td><strong>CARGO</strong></td>
                            <td><strong>CC</strong></td>
                            <td><strong>SEXO</strong></td>
                            <td><strong>NOTA</strong></td>
                            <td><strong>OBSERVACIONES</strong></td>
                        </tr>

                        <?php
                        $NotaAprueba = 0;
                        foreach ($Func->PartiCapac($NROPROG, $CODEMPLEADO) as $a) {
                            ($a['APRUEBA'] >= 3.5) ? $icon =  "✅" : $icon = '⛔';

                            if (odbc_result($Func->validarBoton($NROPROG, $a['CODIGO']), 'CANTIDAD') != 0) {
                                $botonEnlace = "<td>
                                    <form action='RegistrosReprogramacion.php' target='_blank' onsubmit='window.open('RegistrosReprogramacion.php' , 'popup','width=1600,height=1600,scrollbars=no,resizable=no') method='POST'>	
                                        <input type='hidden' name='NROPROGEMPL' value='" . $NROPROG . "'>	
                                        <input type='hidden' name='CODEMPLEADOEMPL' value='" . $a['CODIGO'] . "'>	
                                        <input name='dataInfo' style='width: 100%' class='btn btn-success' type='submit' value='" . utf8_encode($a['NOM']) . "'/></center>	
                                    </form>	
                                </td>";
                            } else {
                                $botonEnlace = "<td align='center'>" . utf8_encode($a['NOM']) . "</td>";
                            }

                            echo "<tr>	
                                " . $botonEnlace . "	
                                <td>" . utf8_encode($a['CARGO']) . "</td>	
                                <td align='right'>" . $a['CEDULA'] . "</td>	
                                <td align='right'>" . $a['SEXO'] . "</td>	
                                <td align='center'>" . round($a['APRUEBA'], 1) . " " . $icon . "</td>	
                                <td>" . utf8_encode($a['Observaciones']) . "</td>
                            </tr>";

                            $NotaAprueba = $NotaAprueba + $a['APRUEBA'];
                        }
                        $PromPart = $NotaAprueba / count($Func->PartiCapac($NROPROG, $CODEMPLEADO));
                        ($PromPart >= 3.5) ? $icon =  "✅" : $icon = '⛔';
                        ?>
                        <tr>
                            <td colspan="4">Promedio:</td>
                            <td align="center"><?php echo number_format(round($PromPart, 1), 1) . " " . $icon; ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>

        <section class="mt-2">
            <button id="btnDescargar" onclick="exportarExcel()" class="btn btn-success">VER PDF</button>
        </section>

        <div class="text-right mt-5">
        </div>
    </div>

    <script>
        function exportarExcel() {
            window.open('/IKIGAI/view/viewCapacitacion.php?NROPROG=<?php echo $NROPROG . '&&codempleado=' . $CODEMPLEADO ?>', '_blank');
        }
    </script>