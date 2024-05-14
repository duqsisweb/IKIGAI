<?php	
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);	
session_start();	
if (isset($_POST['cargarCapac'])) {	
	$usu = $_SESSION['usuario'];	
	require '../../Funciones/funcionalidades.php';	
	$Func = new Funciones;	
	date_default_timezone_set('America/Bogota');	
	$Max = Date("Y-m-d");	
	$NROPROG = $_POST['NROPROG'];	
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
			<center><a class="navbar-brand">Subir datos de capacitación</a> </center>	
		</div>	
	</nav>	

	<?php if ($Func->ListAsistentes($NROPROG) != 0) { ?>	

		<form autocomplete="off" action="../../Funciones/upcapacitacion.php" method="POST" class="form-register" enctype="multipart/form-data">	
			<div class="container">	
				<div class="text-right mt-2">	
					<div class="row">	

						<div class="col-md-12"><br></div>	

						<div class="col-md-2">	
							¿Desea evaluar al capacitador?	
						</div>	

						<div class="col-md-1">	
							<input class="form-check-input" type="checkbox" name="check" id="check" value="1" onchange="javascript:showContent()" />	
						</div>	

						<div class="col-md-9">	
							<div id="content" style="display: none;">	
								<div class="row">	
									<div class="col-md-8"><strong>Nota:</strong> El rango es de 0.0 a 5.0, en donde 3.0 en adelante es positivo</div>	
									<div class="col-md-4"><input class="form-control" type="number" step="0.002" min="0.00" max="5.0" name="NotaCapacitador"></div>	
								</div>	
							</div>	
						</div>	

						<div class="col-md-12"><br>	
							<hr>	
						</div>	

						<div class="col-md-12"><br></div>	

						<div class="col-md-1">	
							<label>Fecha<font color="red"><strong>*</strong></font> </label>	
						</div>	

						<div class="col-md-3">	
							<input class="form-control" type="date" name="fecha" max="<?php echo $Max ?>" required />	
						</div>	

						<div class="col-md-1">	
							<label>Hora de inicio<font color="red"><strong>*</strong></font> </label>	
						</div>	

						<div class="col-md-3">	
							<input id="fechasInicio" class="form-control" type="time" name="hinicio" onChange="obtenerFechaInicio(event)" required />	
						</div>	

						<div class="col-md-1">	
							<label>Hora de finalización<font color="red"><strong>*</strong></font> </label>	
						</div>	

						<div class="col-md-3">	
							<input id="fechasFinal" class="form-control fechas" type="time" name="hfinal" onChange="obtenerFechaFinal(event)" required />	
						</div>	

						<div class="col-md-12"><br></div>	

						<div class="col-md-1">	
							<label>Lugar<font color="red"><strong>*</strong></font> </label>	
						</div>	

						<div class="col-md-3">	
							<select class="form-select" name="lugar" required>	
								<option value="">Selecciona un lugar</option>	
								<?php $empleados = 'CODLUGAR';	
								foreach ($Func->ListFiltro($empleados) as $a) {	
									echo '<option value="' . $a['FINCADESC'] . '">' . $a['FINCADESC'] . '</option>';	
								} ?>	
							</select>	
						</div>	

						<div class="col-md-1">	
							<label>Descripción<font color="red"><strong>*</strong></font> </label>	
						</div>	

						<div class="col-md-7">	
							<textarea class="form-control" type="text" name="description" style="height:30px" required></textarea>	
						</div>	

						<div class="col-md-12"><br></div>	

						<div class="col-md-1">	
							<label>Bitácora<font color="red"><strong>*</strong></font> </label>	
						</div>	

						<div class="col-md-11">	
							<input class="form-control" placeholder="URL Drive" type="text" name="Bitacora" required>	
						</div> 	

						<div class="col-md-12"><br></div>	
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

						foreach ($Func->ListAsistentes($NROPROG) as $asis) {	

							$color = ($asis['TIPOUSUARIO'] == "Si") ? 'green' : 'blue';		

							$ident++;   	

							echo "<tr align='center'>	
							<td>	
								<input class='form-control InputAsistentes totalAsist' value=" . $count++ . " disabled>	
							</td>	
							<td>	
								<input class='form-control InputAsistentes' value='" .rtrim($asis['CODIGOEMPL']). "' disabled>	
							</td>	
							<input class='form-control InputAsistentes' type='hidden' value='" . rtrim($asis['CODIGOEMPL']) . "' name='codigoEmpl$ident'>		
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
							 	<input id='ident$ident' class='form-control InputAsistentes nota' value=" . $asis['NOTA'] . " name='nota$ident' disabled>	
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
	let fechaInicio;
	let fechaFinal;

	const obtenerFechaInicio = (e) => {
		fechaInicio = e.target.value;
		verificarFechas();
	}

	const obtenerFechaFinal = (e) => {
		fechaFinal = e.target.value;
		verificarFechas();
	}

	const verificarFechas = () =>{
		if (fechaInicio > fechaFinal) {
			alert("La fecha de inicio es mayor a la final, revisa que las horas PM / AM sean correctas")
			document.getElementById('fechasInicio').style.background = "red";
			document.getElementById('fechasFinal').style.background = "red";
		} else if (fechaInicio < fechaFinal){
			document.getElementById('fechasInicio').style.background = "#198754";
			document.getElementById('fechasFinal').style.background = "#198754";
		}
	} 



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