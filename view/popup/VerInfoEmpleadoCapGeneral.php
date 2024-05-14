<?php

header('Content-Type: text/html; charset=UTF-8');
// error_reporting(0);	
session_start();

if (isset($_POST['NROPROG'])) {
    $usu = $_SESSION['usuario'];
    require '../../Funciones/funcionalidades.php';
    $Func = new Funciones;

    $NROPROG = $_POST['NROPROG'];

    $Programados = odbc_result($Func->Estadisticas(1, $NROPROG), 'CANTIDADPROG');
    $Asistidos = odbc_result($Func->Estadisticas(2, $NROPROG), 'Nro');

    if ($Asistidos > $Programados) {
        $Cobertura = 100;
    } else {
        $Val = ($Programados == 0 or $Asistidos == 0) ? $Cobertura = 0 : $Cobertura = ($Asistidos / $Programados) * 100;
    }

    $Eficacia = odbc_result($Func->Estadisticas(3, $NROPROG), 'Nro');
    $Val = ($Eficacia == 0 or $Asistidos == 0) ? $porEficacia = 0 : $porEficacia = ($Eficacia / $Asistidos) * 100;
    $TotalPromedio = ($Cobertura + $porEficacia + 100) / 3;

    $ClaseTotal = $Func->ClaseTotal($TotalPromedio);
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
            <center><a class="navbar-brand">Detalle General</a></center>
        </div>
    </nav>

    <div class="container">
        <div class="text-right mt-1">

            <div class="col-md-12"><br></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3" style="max-width: 100%;">
                        <div class="card-header" align="center">Cobertura</div>
                        <div class="card-body">Se programo un total de <strong><?php echo $Programados ?></strong> personas, asistiendo un total de <strong><?php echo $Asistidos ?></strong> personas, para una cobertura de <strong><?php echo number_format($Cobertura) ?>%.</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3" style="max-width: 100%;">
                        <div class="card-header" align="center">Eficacia</div>
                        <div class="card-body">La capacitacion tuvo un total de <strong><?php echo number_format($Eficacia) ?> </strong> personas aprobadas, significando un <strong><?php echo number_format($porEficacia) ?>%</strong> de eficacia
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="tablapruebaGeneral">
                    <table class="table table-bordered" cellspacing="0">
                        <tr>
                            <td colspan="5" align="center"><strong>REGISTRO DE EVALUACION DE LA FORMACION</strong></td>
                            <td>GHA -FT-35<br>Versión: 1<br>Fecha de Emisión: 29/03/2016</td>
                        </tr>
                        <tr>
                            <td colspan="6"><strong>Tipo de actividad:</strong> <?php echo odbc_result($Func->CabCap($NROPROG), 'CAPACITACION') ?></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha: </strong> <?php echo odbc_result($Func->CabCap($NROPROG), 'FECHA') ?></td>
                            <td><strong>Hora inicio: </strong><?php echo substr(odbc_result($Func->CabCap($NROPROG), 'HINICIO'), 0, 5) ?></td>
                            <td><strong>Hora finalizacion: </strong><?php echo substr(odbc_result($Func->CabCap($NROPROG), 'HFINAL'), 0, 5) ?></td>
                            <td colspan="3"><strong>Duracion: </strong><?php echo number_format(round(odbc_result($Func->CabCap($NROPROG), 'DURACION'), 2), 2) . " Horas"; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Lugar: </strong> <?php echo utf8_encode(odbc_result($Func->CabCap($NROPROG), 'LUGAR')) ?> </td>
                            <td colspan="5"><strong>Responsable: </strong> <?php echo utf8_decode(odbc_result($Func->CabCap($NROPROG), 'Capacit')) ?> (<strong>Nota: </strong><?php echo utf8_decode(odbc_result($Func->CabCap($NROPROG), 'Nota')) ?>) </td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Tipo de formacion: </strong> <?php echo utf8_encode(odbc_result($Func->CabCap($NROPROG), 'TFORM')) ?> </td>
                            <td colspan="4"><strong>Bitácora: </strong> <a target="_blank" href="<?php echo odbc_result($Func->CabCap($NROPROG), 'Bitacora') ?>">¡Click para ver!</a></td>
                        </tr>
                        <tr>
                            <td colspan="6"><strong>Descripcion: </strong> <?php echo utf8_encode(odbc_result($Func->CabCap($NROPROG), 'DESCRIPCION')) ?> </td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Valor Total: </strong>$<?php echo number_format(odbc_result($Func->CabCap($NROPROG), 'PRECIO'), 1) ?> </td>
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
                        $CODEMPLEADO = NULL;
                        foreach ($Func->PartiCapac($NROPROG, $CODEMPLEADO) as $a) {
                            $Val = ($a['APRUEBA'] >= 3.5) ? $icon =  "✅" : $icon = '⛔';

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
                                <td>" .  utf8_encode($a['CARGO']) . "</td>	
                                <td>" . $a['CODIGO'] . "</td>
                                <td>" . $a['SEXO'] . "</td>		
                                <td align='center'>" . number_format(round($a['APRUEBA'], 1), 1) . " " . $icon . "</td>	
                                <td>" . utf8_encode($a['Observaciones']) . "</td></tr>";
                            $NotaAprueba = $NotaAprueba + $a['APRUEBA'];
                        }
                        $PromPart = $NotaAprueba / count($Func->PartiCapac($NROPROG, $CODEMPLEADO));
                        $Val = ($PromPart >= 3.5) ? $icon =  "✅" : $icon = '⛔';
                        ?>
                        <tr>
                            <td colspan="4">Promedio:</td>
                            <td align="center"><?php echo number_format(round($PromPart, 1), 1) . " " . $icon; ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <section class="mt-8">
                <button id="btnDescargar" onclick="exportarExcelGeneral()" class="btn btn-success">VER PDF</button>
                <button id="btnDescargar" onclick="CerrarVentana()" class="btn btn-success">Cerrar Ventana</button>
            </section>

            <div class="text-right mt-5">

            </div>
            </div>
        </div>

        <script>
            function exportarExcelGeneral() {
                window.open('/IKIGAI/view/viewCapacitacion.php?NROPROG=<?php echo $NROPROG ?>', '_blank');
            }

            function CerrarVentana() {
                window.close();
            }
        </script>