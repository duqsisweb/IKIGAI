<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);

$NROPROG = $_GET['NROPROG'];
$COST = $_GET['cost'];
$CARGO = $_GET['cargo'];

require '../../Funciones/funcionalidades.php';
$Func = new Funciones;
session_start();
$usu = $_SESSION['usuario'];
$ConsMod = $Func->ProgModifacion($NROPROG);
$count = 1;
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<style>
		.selectProg {
			width: 100%;
			height: 38px;
			border: 1px solid #D5D5D5;
			border-radius: 4px;
		}

		.formAsis {
			margin: 1px 1px;
			color: #FFFFFF;
			border: 1px solid #FFFFFF;
			text-transform: capitalize;
			font-size: 0.950rem;
			color: #FFFFFF;
		}

		.formAsis:disabled {

			margin: 1px 1px;
			border: 1px solid #FFFFFF;
			background-color: #198754;
			color: #FFFFFF;
			text-transform: capitalize;
			font-size: 0.950rem;
			color: #FFFFFF;
		}
	</style>

</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
	<div class="container">
		<center><a class="navbar-brand">Modificación de la programación</a></center>
	</div>
</nav>

<form autocomplete="off" method="POST" class="form-register" action="../../Funciones/ModProgrCamb.php">
	<div class="container">
		<div class="text-right mt-5">
			<div class="row">

				<div class="col-md-3">
					<div class="form-group">
						<label>Año</label>

					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<input id="input1" name="Anio" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Anio') ?>" required>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Mes</label>

					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<input id="input2" name="Mes" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Mes') ?>" required>
					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Capacitacion</label>

					</div>
				</div>

				<div class="col-md-9">
					<div class="form-group">
						<input id="input3" name="Capacitacion" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'CAPACITACION') ?>" required>
					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Capacitador</label>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<input id="input4" name="CAPACITADOR" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CAPACITADOR') ?>" required>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Asistentes programados</label>
					</div>
				</div>

				<!-- asistentes programados -->
				<div class="col-md-3">
					<div class="form-group">
						<input id="cantidadAsis" name="CANTPROGRAMADOS" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CANTIDADPROG') ?>">
					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Categoria</label>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<select id="input5" class="nput-group-text selectProg saveInputs" name="categoriaCap" required>
							<option value="<?php echo odbc_result($ConsMod, 'ID2') ?>"><?php echo utf8_encode(odbc_result($ConsMod, 'CATEGORIA')) ?></option>
							<?php
							foreach ($Func->ListSelectProgra('1') as $a) {
								echo '<option value="' . utf8_encode($a['ID']) . '">' . utf8_encode($a['OPCION']) . '</option>';
							} ?>
						</select>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Tipo</label>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<select id="input6" class="nput-group-text selectProg saveInputs" name="temaCap" required>
							<option value="<?php echo odbc_result($ConsMod, 'ID1') ?>"><?php echo utf8_encode(odbc_result($ConsMod, 'SUPTIPO')) ?></option>
							<?php
							foreach ($Func->ListSelectProgra('2') as $a) {
								echo '<option value="' . utf8_encode($a['ID']) . '">' . utf8_encode($a['OPCION']) . '</option>';
							} ?>
						</select>
					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Link Drive</label>
					</div>
				</div>

				<div class="col-md-9">
					<div class="form-group">
						<input id="input3" name="linkDrive" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Bitacora') ?>">
					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>

				<!-- Esta es la fila que deseas duplicar -->
				<div id="filaAEstablecerComoModelo" class="row">

					<!-- centro costo -->
					<div class="col-md-2">
						<label>Centro de Costo</label>
						<div class="form-group">
							<select list="Mes" class="form-control" type="text" name="Costo" id="centroCosto" required>
								<?php
								// Verificar si no se ha enviado el formulario o si no se ha seleccionado un valor para el campo "Costo"
								$selectedOption = (empty($_GET['Costo'])) ? 'selected' : '';

								// Agregar la opción predeterminada con el atributo "selected" si es necesario
								echo '<option value="" ' . $selectedOption . '>Selecciona el Centro de Costo</option>';

								// Generar las opciones a partir de la función $Func->ListCostosMayor()
								foreach ($Func->ListCostosMayor() as $a) {
									echo '<option value="' . $a['CentroMayor'] . '">' . $a['NOMBRE'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>

					<!-- cargo -->
					<div class="col-md-3">
						<label>Cargo</label>
						<div class="form-group">
							<select list="Mes" class="form-control" type="text" name="CARGO" id="campoCargo" required>
								<option value="">Seleccione el Cargo</option>
								<?php
								foreach ($Func->ListCargo('') as $cargo) { // La función ListCargo no necesita un parámetro de cargo aquí
									echo '<option value="' . $cargo['CODCARGO'] . '">' . $cargo['CARGO'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>

					<!-- nombre -->
					<div class="col-md-3">
						<label for="campoNombre">Nombre</label>
						<select id="campoNombre" class="form-control" name="nombre">
							<!-- Opciones generadas dinámicamente mediante AJAX -->
						</select>
					</div>

					<!-- tipo invitacion -->
					<div class="col-md-2">
						<label for="campoNombre">Tipo Invitación</label>
						<select class="form-control tipoAsist tipoInvitacion" name="tipoInvitacion">
							<option value="">Invitación</option>
							<option value="1">Obligatorio</option>
							<option value="2">No obligatorio</option>
						</select>

					</div>

					<div class="col-md-1">
						<br>
						<button type="button" id="incrementButton" class="btn btn-warning incrementButton">+</button>
					</div>

					<div class="col-md-1">
						<br>
						<button type="button" class="btn btn-danger decrecrementButton">-</button>
					</div>

				</div>

				<div id="contenedorDeFilas">

				</div>

			</div>


			<div id="inputsAsis" class="container" style="padding:30px">
				<div>
					<input type="hidden" name="USER" value="<?php echo $usu ?>">
					<input id="countChecks" type="hidden" name="CANTUSERSELECT">
				</div>
			</div>


		</div>

		<div class="col-md-12" style="text-align: center;margin-top:30px;margin-bottom: 30px;">
			<input type="hidden" name="NROPROG" value="<?php echo $NROPROG ?>">
			<center><input name="ModPramacion" style="display: none;" class="btn btn-success ModPramacion ModPramacion" type="submit" value="¡Modificar!" /></center>
			<button type="button" id="" class="btn btn-success showAlertButton" name="">GUARDAR</button> |
			<button type="button" id="cerrarBtn" class="btn btn-danger" name="">CERRAR</button>
		</div>



</form>



<script>
	// Utiliza el evento delegado para manejar clics en los botones "+" (tanto existentes como dinámicos)
	document.addEventListener("click", function(event) {
		if (event.target.classList.contains("incrementButton")) {
			// Obtén la fila modelo que deseas duplicar
			var filaModelo = document.getElementById("filaAEstablecerComoModelo");

			// Clona la fila modelo
			var nuevaFila = filaModelo.cloneNode(true);

			// Cambia el id de la nueva fila para que sea único
			nuevaFila.id = "nuevaFila" + Date.now();

			// Agrega la nueva fila al contenedor deseado
			var contenedor = document.getElementById("contenedorDeFilas");
			contenedor.appendChild(nuevaFila);
		}

		// Agrega un evento clic a todos los botones "-" con la clase "decrecrementButton"
		document.addEventListener("click", function(event) {
			if (event.target.classList.contains("decrecrementButton")) {
				// Obtén la fila actual a eliminar
				var filaAEliminar = event.target.closest(".row");

				// Verifica que no sea la última fila antes de eliminarla
				if (filaAEliminar && document.querySelectorAll(".row").length > 1) {
					filaAEliminar.remove(); // Elimina la fila
				}
			}
		});


	});
</script>

<script>
	document.getElementById("incrementButton").addEventListener("click", function() {
		// Obtén el elemento del campo CANTPROGRAMADOS
		var cantidadAsisInput = document.getElementById("cantidadAsis");

		// Incrementa el valor en 1
		cantidadAsisInput.value = parseInt(cantidadAsisInput.value) + 1;
	});

	document.getElementById("decrecrementButton").addEventListener("click", function() {
		// Obtén el elemento del campo CANTPROGRAMADOS
		var cantidadAsisInput = document.getElementById("cantidadAsis");

		// Resta 1 al valor actual del campo
		cantidadAsisInput.value = parseInt(cantidadAsisInput.value) - 1;
	});
</script>

<script>
	document.getElementById("cerrarBtn").addEventListener("click", function() {
		window.close();
	});
</script>

<script>
	$(document).ready(function() {
		// Cuando cambia la selección de Centro de Costo
		$("#centroCosto").change(function() {
			var selectedCentroCosto = $(this).val(); // Obtener el valor seleccionado
			console.log("Centro de Costo seleccionado:", selectedCentroCosto); // Agregar este mensaje de depuración

			// Realizar una solicitud AJAX para obtener las opciones de Cargo basadas en Centro de Costo
			$.ajax({
				url: "../obtener_cargos.php",
				type: "GET",
				data: {
					costo: selectedCentroCosto
				},
				success: function(data) {
					// Actualizar el campo de selección de Cargo con las nuevas opciones
					$("#campoCargo").html(data);
					console.log("Respuesta de obtener_cargos.php:", data); // Agregar este mensaje de depuración
				}
			});
		});

		// Cuando cambia la selección de Cargo
		$("#campoCargo").change(function() {
			var selectedCargo = $(this).val(); // Obtener el valor seleccionado del cargo
			console.log("Cargo seleccionado:", selectedCargo); // Agregar este mensaje de depuración

			// Realizar una solicitud AJAX para obtener la lista de nombres basada en el Cargo
			$.ajax({
				url: "../obtener_nombres.php", // Reemplaza con la ruta correcta a tu script PHP
				type: "GET",
				data: {
					cargo: selectedCargo
				},
				success: function(data) {
					// Actualizar el campo de selección de Nombre con las nuevas opciones
					$("#campoNombre").html(data);
					console.log("Respuesta de obtener_nombres.php:", data); // Agregar este mensaje de depuración
				}
			});
		});
	});
</script>






<!-- script de alerta -->
<script>
	$(document).ready(function() {
		$('.showAlertButton').click(function() {
			Swal.fire({
				title: '¿Quieres guardar los cambios?',
				showDenyButton: true,
				showCancelButton: false,
				confirmButtonText: 'Guardar',
				denyButtonText: `No guardar`,
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire('¡Guardado!', '', 'success');
					// Ejecutar el trigger después de 2 segundos
					setTimeout(function() {
						$('.ModPramacion').trigger('click');
					}, 2000);
				} else if (result.isDenied) {
					Swal.fire('Los cambios no se guardaron', '', 'info');
				}
			});
		});
	});
</script>