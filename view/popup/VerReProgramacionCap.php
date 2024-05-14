<?php	
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);	
session_start();	
if (isset($_POST['cargarCapac'])) {	
	$usu = $_SESSION['usuario'];	
	require '../../Funciones/funcionalidades.php';	
	$Func = new Funciones;	

	$NROPROG = $_POST['NROPROG'];	
	$ConsMod = $Func-> ProgModifacion($NROPROG);	
	$cabeceraCap = $Func-> CabCap($NROPROG);

	$count = 1;	

	include "../../con_palmerdb.php";	
	$resultCapt = odbc_exec($conexion, "SELECT CAPACITADOR FROM PLATCAPACITACIONES..Programacion WHERE NROPROG = '$NROPROG'");	
	$CAPT = odbc_result($resultCapt, 'CAPACITADOR');	
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

		<script type="text/javascript">	
			function showContent() {	
				element = document.getElementById("content");	
				check = document.getElementById("check");	
				if (check.checked) {	
					element.style.display = 'block';	
				} else {	
					element.style.display = 'none';	
				}	
			}	
		</script>	

		<style>	
			#formAsistentes {	
				display: none;	
				margin: 20px;	
			}	

			.InputAsistentes {	
				text-align: center;	
			}	
		</style>	
	</head>	


	<nav class="navbar navbar-expand-lg navbar-dark bg-success">	
		<div class="container">	
			<center><a class="navbar-brand">Calificar reprogramados</a> </center>	
		</div>	
	</nav>	

	<?php if ($Func->ListAsistentesReprogramados($NROPROG) != 0) { ?>	

<form autocomplete="off" action="../../Funciones/upcapacitacion.php" method="POST" class="form-register" enctype="multipart/form-data">	
	<div class="container">	
		<div class="text-right mt-5">	
			<div class="row">	

				<div class="col-md-2">	
    				<div class="form-group">	
    					<label>Año</label>	

    				</div>						
				</div>	

				<div class="col-md-2">	
    				<div class="form-group">	
        				<input id="input1" name="Anio" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Anio') ?>" disabled>	
    				</div>						
				</div>	

				<div class="col-md-2">	
    				<div class="form-group">	
    					<label>Mes</label>	

    				</div>						
				</div>	

				<div class="col-md-2">	
    				<div class="form-group">	
        				<input id="input2" name="Mes" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Mes') ?>" disabled>	
    				</div>						
				</div>	

				<div class="col-md-2">	
    				<div class="form-group">	
    					<label>Link Drive</label>	
    				</div>						
				</div>	

				<div class="col-md-2">	
    				<div class="form-group">	
						<a href="<?php echo odbc_result($ConsMod, 'Bitacora') ?>" target="_blank">Ver Bitacora</a>
					</div> 						
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-2">	
					<label>Fecha<font color="red"><strong>*</strong></font></label>	
				</div>	

				<div class="col-md-2">	
					<input class="form-control" type="text" value="<?php echo odbc_result($cabeceraCap, 'FECHA') ?>" name="fecha" disabled />	
				</div>	

				<div class="col-md-2">	
					<label>Hora de inicio<font color="red"><strong>*</strong></font> </label>	
				</div>	

				<div class="col-md-2">	
					<input class="form-control" type="text" name="hinicio" value="<?php echo substr(odbc_result($cabeceraCap, 'HINICIO'), 0, 5) ?>" disabled />	
				</div>	

				<div class="col-md-2">	
					<label>Hora de finalización<font color="red"><strong>*</strong></font> </label>	
				</div>	

				<div class="col-md-2">	
					<input class="form-control" type="text" name="hfinal" value="<?php echo substr(odbc_result($cabeceraCap, 'HFINAL'), 0, 5) ?>" disabled />	
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-2">	
    				<div class="form-group">	
    					<label>Capacitacion</label>	
    				</div>						
				</div>	

				<div class="col-md-4">	
    				<div class="form-group">	
        				<input id="input3" name="Capacitacion" class="form-control saveInputs" type="text" value="<?php echo odbc_result($cabeceraCap, 'Capacit') ?>" disabled>	
    				</div>						
				</div>	

				<div class="col-md-2">	
					<label>Descripción<font color="red"><strong>*</strong></font> </label>	
				</div>	

				<div class="col-md-4">	
					<input class="form-control saveInputs" type="text" name="description" value="<?php echo odbc_result($cabeceraCap, 'DESCRIPCION') ?>" disabled>	
				</div>	

				<div class="col-md-12"><hr></div>	

				<div class="col-md-2">	
					<div class="form-group">	
						<label>Capacitador</label>	
    				</div>						
				</div>	

				<div class="col-md-3">	
    				<div class="form-group">	
        				<input id="input4" name="CAPACITADOR" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CAPACITADOR') ?>" disabled>	
    				</div>						
				</div>	

				<div class="col-md-1">	
					<div class="form-group">	
						<label>Lugar<font color="red"><strong>*</strong></font> </label>	
					</div>						
				</div>

				<div class="col-md-3">	
					<div class="form-group">	
						<input id="cantidadAsis" name="CANTPROGRAMADOS" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CANTIDADPROG') ?>" disabled>	
					</div>						
				</div>	

				<div class="col-md-2">	
					<div class="form-group">	
						<label>Asistentes programados</label>	
					</div>						
				</div>	

				<div class="col-md-1">	
					<div class="form-group">	
						<input id="cantidadAsis" name="CANTPROGRAMADOS" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CANTIDADPROG') ?>" disabled>	
					</div>						
				</div>	

				<div class="col-md-12"><hr></div>	

				<div id="inputsAsis" class="container" style="padding:30px"><div>	

				<input type="hidden" name="USER" value="<?php echo $usu?>">	
				<input id="countChecks" type="hidden" name="CANTUSERSELECT">	
			</div>	
		</div>	
	</div>	

				
			<div class='container' style="width: 100%; margin-bottom:40px">	
				<table align="center" style="width: 100%">	
					<tr>	
						<td class='col-1' bgcolor="#198754" align='center'>	
							<font color="white"><strong>N°</strong></font>	
						</td>	
						<td class='col-2' bgcolor="#198754" align='center'>	
							<font color="white"><strong>Codigo</strong></font>	
						</td>	
						<td class='col-3' bgcolor="#198754" align='center'>	
							<font color="white"><strong>Nombre Empleado</strong></font>	
						</td>	
						<td class='col-3' bgcolor="#198754" align='center'>	
							<font color="white"><strong>Observacion</strong></font>	
						</td>	
						<td class='col-1' bgcolor="#198754" align='center'>	
							<font color="white"><strong>Obligatorio</strong></font>	
						</td>	
						<td class='col-2' bgcolor="#198754" align='center'>	
							<font color="white"><strong>Nota</strong></font>	
						</td>	
						<td class='col-1' bgcolor="#198754" align='center'>	
							<font color="white"><strong>¿Asistio?</strong></font>	
						</td>	
					</tr>	
					<div class='row'>	
						<?php	
						$count = 1;	
						$count2 = 1;	
						$ident = 0;	

						foreach ($Func->ListAsistentesReprogramados($NROPROG) as $asis) {	

							$color = ($asis['TIPOUSUARIO'] == "Si") ? 'green' : 'blue';		

							$ident++;   	

							echo "<tr align='center'>	
							<td>	
								<input class='form-control InputAsistentes totalAsist' value=" . $count++ . " disabled>	
							</td>	
								
							<td>	
								<input class='form-control InputAsistentes' value='" . rtrim($asis['CODIGOEMPL']) . "' name='codigoEmpl$ident'>	
							</td>	
							<td>	
							<input class='form-control InputAsistentes' value='" .utf8_encode($asis['NOMCAP']). "' readonly>	
							</td>	
							<td> 	
								<input class='form-control' value='' placeholder='Observacion' name='observacion$ident'	>	
							</td>	
								
							<td>	
								<input class='form-control InputAsistentes' value=" . $asis['TIPOUSUARIO'] . " style= 'background: $color; color: #ffffff;' disabled>	
							</td>	
							<td> 	
							 	<input id='ident$ident' class='form-control InputAsistentes nota' value=" . $asis['NOTAEMPL'] . " name='nota$ident' disabled>	
							</td>	
							<td>	
								<select id='ident$ident' class='nput-group-text InputAsistentes select' style='height: 40px' name='asistencia$ident' required>	
									<option value=''>Selecciona</option>	
									<option value='1'>Si</option>	
									<option value='2'>No</option>	
								</select>	
							</td>	
						</tr>";	
						} ?>	
					</div>	
				</table>	
			</div>	

			<div class='container' style="width: 100%; margin-bottom:30px">	
				<div id="newInput" class="row"></div>	
			</div>	

			<input type="hidden" name="NROPROG" value='<?php echo $NROPROG ?>'>	
			<input type="hidden" name="CAPT" value='<?php echo $CAPT ?>'>	
			<input id="totalAsisInput" type="hidden" name='totalAsist' value=''>	

			<div class='container' style="width: 100%; margin-bottom:40px">			
				<center><input name="cargarNotas" style="width: 30%" class="btn btn-success" type="submit" value="¡Cargar Capacitacion!" /></center>	
			</div>	
		</form>	

	<?php } else { ?>	
		<div style="margin: 40px" class="alert alert-warning" role="alert" align="center">No hay asistentes para calificar</div>	
	<?php } ?>	
<?php } ?>	

<!-- Si selecciona que no asistio automaticamente pone nota 1 -->	
<script>	
	let selects = document.querySelectorAll(".select");	
	let notasInput = document.querySelectorAll(".nota");	
	let newInput = document.getElementById("newInput");	

	selects.forEach(element1 => {	
		let id = element1.id;	
		element1.addEventListener("change", function(e) {	
			if (e.target.value == "2") {	
				document.getElementById(`${id}`).value = ""; 	
				document.getElementById(`${id}`).disabled = false;	
				document.getElementById(`${id}`).required = false;	
			} else {	
				document.getElementById(`${id}`).value = "";	
				document.getElementById(`${id}`).disabled = false;	
				document.getElementById(`${id}`).required = true;	
			}	
		})	
	});	

	let count = '<?php echo $count?>';	
	let ident = '<?php echo $count?>';	
	let totalAsistentes = count-1;	

	const añadirNuevoCampo = () => {	
		ident = parseInt(ident) + 1;	
		totalIdent = ident - 1;	

		let estructuraCelda = `<tr align='center'>	
						<div style="width: 9%" >	
							<td><input class='form-control InputAsistentes totalAsist2' value=${count++} disabled></td>	
						</div>	
						<div style="width: 14%">	
							<td><input class='form-control InputAsistentes' value="" placeholder='Ingresa codigo' name='codigoEmpl${totalIdent}' required></td>	
						</div>	
							
						<div style="width: 23%">	
						<td>
							<input class='form-control InputAsistentes' value="" placeholder='Ingresa el nombre'></div>	
						</td>	
						<div style="width: 31%">	
							<td>
								<input class='form-control' value='' placeholder='Observacion' name='observacion${totalIdent}'>
							</td>	
						</div>	
						<div style="width: 14%">	
							<td>
								<input class='form-control InputAsistentes nota' value='' placeholder="0.0" name='nota${totalIdent}' required>
							</td>	
						</div>	
						<div style="width: 5%">	
							<td>
								<select ' class='nput-group-text InputAsistentes select' style='height: 40px' name='asistencia${totalIdent}' required>	
									<option value=''>Selecciona</option>	
									<option value='1'>Si</option>	
									<option value='2'>No</option>	
								</select>
							</td>	
						</div>	
					</tr>`	
		newInput.innerHTML += estructuraCelda;	
		totalAsistentes = parseInt(count) - 1;	
		obtenerTotalAsis();	
	}	

	const obtenerTotalAsis = () => {	
		document.getElementById("totalAsisInput").value = totalAsistentes;	
	}	

	obtenerTotalAsis();	

</script>	 