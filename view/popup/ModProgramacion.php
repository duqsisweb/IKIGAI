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
		#enviarButton {
			position: absolute;
			left: -9999px;
		}

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


<body>
	<form autocomplete="off" method="POST" class="form-register" action="../../Funciones/ModProgrCamb.php">


		<div class="container-fluid">
			<div class="text-right mt-5">

				<div class="row">

					<div class="col-md-3">
						<div class="form-group">
							<label>Año</label>

						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<input id="input1" name="Anio" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Anio') ?>" readonly required>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Mes</label>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<input id="input2" name="Mes" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Mes') ?>" readonly required>
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
							<input id="input3" name="Capacitacion" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'CAPACITACION') ?>" readonly required>
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
							<input id="input4" name="CAPACITADOR" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CAPACITADOR') ?>" readonly required>
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
							<input id="cantidadAsis" name="CANTPROGRAMADOS" class="form-control saveInputs" type="number" value="<?php echo odbc_result($ConsMod, 'CANTIDADPROG') ?>" readonly required>
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
							<input id="input7" name="linkDrive" class="form-control saveInputs" type="text" value="<?php echo odbc_result($ConsMod, 'Bitacora') ?>">
						</div>
					</div>

					<div class="col-md-12">
						<hr>
					</div>


					<!-- contenedor de la busqueda de usuarios -->
					<div class="container">

						<table class="table table-bordered">
							<thead class="table-dark">
								<tr>
									<th scope="col">Centro de Costo</th>
									<th scope="col">Cargo</th>
									<th scope="col">Nombre</th>
									<th scope="col">Tipo Invitación</th>
									<th scope="col">Acciones</th>
								</tr>
								</t head>
							<tbody id="tableBody">
								<tr>

									<td>
										<select class="form-control centroCosto" name="Costo">
											<option value="">Selecciona el Centro de Costo</option>
											<?php
											foreach ($Func->ListCostosMayor() as $a) {
												echo '<option value="' . $a['CentroMayor'] . '">' . $a['NOMBRE'] . '</option>';
											}
											?>
										</select>
									</td>
									<td>
										<select class="form-control campoCargo" name="cargo">
										</select>
									</td>
									<td>
										<select class="form-control campoNombre" name="nombre">
										</select>
									</td>
									<td>
										<select class="form-control tipoAsist tipoInvitacion" name="tipoInvitacion">
											<option value="">Seleccione Invitación</option>
											<option value="1">Obligatorio</option>
											<option value="2">No obligatorio</option>
										</select>
									</td>
									<td>
										<button type="button" class="btn btn-warning incrementButton" data-input-id="input3">+</button>
										<button type="button" class="btn btn-danger deleteButton">-</button>
									</td>
								</tr>

							</tbody>
						</table>

						<!-- campos que deben se tomanan los parametros		 -->
						<div>
							<input type="hidden" name="NROPROG" value="<?php echo $NROPROG ?>">
							<input type="hidden" name="" value="<?php echo $usu ?>">

							<input type="hidden" id="anioHidden" name="AnioHidden" value="<?php echo odbc_result($ConsMod, 'Anio') ?>">
							<input type="hidden" id="mesHidden" name="MesHidden" value="<?php echo odbc_result($ConsMod, 'Mes') ?>">
							<input type="hidden" id="capacitacionHidden" name="CapacitacionHidden" value="<?php echo odbc_result($ConsMod, 'CAPACITACION') ?>">
							<input type="hidden" id="capacitadorHidden" name="CapacitadorHidden" value="<?php echo odbc_result($ConsMod, 'CAPACITADOR') ?>">
							<input type="hidden" id="cantidadAsisHidden" name="CANTPROGRAMADOSHidden" value="<?php echo odbc_result($ConsMod, 'CANTIDADPROG') ?>">
							<input type="hidden" id="linkDriveHidden" name="LinkDriveHidden" value="<?php echo odbc_result($ConsMod, 'Bitacora') ?>">

							<input type="hidden" id="categoriaHidden" name="CategoriaHidden" value="<?php echo odbc_result($ConsMod, 'ID2'); ?>">
							<input type="hidden" id="temaHidden" name="TemaHidden" value="<?php echo odbc_result($ConsMod, 'ID1'); ?>">


						</div>

					</div>

				</div>

			</div>
		</div>



		</div>

		<div class="col-md-12" style="text-align: center;margin-top:30px;margin-bottom: 30px;">
			<input type="hidden" name="NROPROG" value="<?php echo $NROPROG ?>">
			<button type="button" style="display: none;" id="enviarButton" class="btn btn-success enviarButton">FUNCIONAL</button>
			<button type="button" id="" class="btn btn-success showAlertButton">ENVIAR</button>
			<button type="button" id="cerrarBtn" class="btn btn-danger" name="">CERRAR</button>
		</div>

	</form>


</body>

<!-- campos ocultos -->
<script>
	$(document).ready(function() {
		// Asigna el valor a la variable y al campo input oculto
		$("#input1").on("change", function() {
			var nuevoValor = $(this).val();
			$("#anioHidden").val(nuevoValor);
		});
		$("#input2").on("change", function() {
			var nuevoValor = $(this).val();
			$("#mesHidden").val(nuevoValor);
		});
		$("#input3").on("change", function() {
			var nuevoValor = $(this).val();
			$("#capacitacionHidden").val(nuevoValor);
		});
		$("#input4").on("change", function() {
			var nuevoValor = $(this).val();
			$("#capacitadorHidden").val(nuevoValor);
		});
		$("#cantidadAsis").on("change", function() {
			var nuevoValor = $(this).val();
			$("#cantidadAsisHidden").val(nuevoValor);
		});
		$(document).ready(function() {
			// Manejar el evento de cambio en el campo de entrada linkDrive
			$("#input7").on("change", function() {
				var nuevoValor = $(this).val();
				$("#linkDriveHidden").val(nuevoValor);
			});
		});

		// Manejar el evento de cambio en el campo select de categoría
		$("#input5").on("change", function() {
			var categoriaValue = $(this).val();
			$("#categoriaHidden").val(categoriaValue);
		});

		// Manejar el evento de cambio en el campo select de tema
		$("#input6").on("change", function() {
			var temaValue = $(this).val();
			$("#temaHidden").val(temaValue);
		});

	});
</script>

<!-- duplicar todos los campos de las filas -->
<script>
	$(document).ready(function() {

		// Evento de clic en el botón "+"
		$(document).on("click", ".incrementButton", function() {
			// Clonar la fila existente
			var clonedRow = $(this).closest("tr").clone();
			var count = parseInt(document.getElementById('cantidadAsis').value) + 1

			// Borrar el contenido de los campos select clonados
			clonedRow.find("select").val("");

			// Agregar la fila clonada a la tabla
			$("#tableBody").append(clonedRow);

			// Copiar los valores de la fila original a la fila duplicada
			var originalRow = $(this).closest("tr");
			clonedRow.find(".centroCosto").val(originalRow.find(".centroCosto").val());
			clonedRow.find(".campoCargo").val(originalRow.find(".campoCargo").val());
			clonedRow.find(".campoNombre");
			clonedRow.find(".campoCodigo").val(originalRow.find(".campoCodigo").val());
			// clonedRow.find(".tipoInvitacion").val(originalRow.find(".tipoInvitacion").val());

		});
		// Evento de cambio en el selector de Centro de Costo
		$(document).on("change", ".centroCosto", function() {
			var selectedCentroCosto = $(this).val();
			var row = $(this).closest("tr"); // Obtener la fila actual
			// console.log("Centro de Costo seleccionado:", selectedCentroCosto);

			// Realizar la solicitud AJAX específica para esta fila
			$.ajax({
				url: "../obtener_cargos.php",
				type: "GET",
				data: {
					costo: selectedCentroCosto
				},
				success: function(data) {
					// Actualizar el campo de selección de Cargo en esta fila
					row.find(".campoCargo").html(data);
					// console.log("Respuesta de obtener_cargos.php:", data);
				}
			});
		});
		// Evento de cambio en el selector de Cargo
		$(document).on("change", ".campoCargo", function() {
			var selectedCargo = $(this).val();
			var row = $(this).closest("tr"); // Obtener la fila actual
			// console.log("Cargo seleccionado:", selectedCargo);

			// Realizar la solicitud AJAX específica para esta fila
			$.ajax({
				url: "../obtener_nombres.php",
				type: "GET",
				data: {
					cargo: selectedCargo
				},
				success: function(data) {
					// Actualizar el campo de selección de Nombre en esta fila
					row.find(".campoNombre").html(data);
					row.find(".campoCodigo").html(data);
					// console.log("Respuesta de obtener_nombres.php:", data);
				}
			});
		});
		$(document).on("change", ".campoNombre", function() {
			var selectedNombre = $(this).val();
			console.log("Cedula seleccionado:", selectedNombre);
		});
		$(document).on("change", ".tipoAsist", function() {
			var selectedTipoInvitacion = $(this).val();
			console.log("Tipo de invitación seleccionado:", selectedTipoInvitacion);
		});

	});
</script>

<!-- ajax para enviar informacion -->
<script>
	$(document).ready(function() {
		// ... (otros scripts)

		// Evento de clic en el botón "ENVIAR"
		$("#enviarButton").click(function() {
			var data = [];

			// Obtén los valores de $usu y $NROPROG
			var usu = "<?php echo $usu; ?>";
			var NROPROG = "<?php echo $NROPROG; ?>";

			var AnioHidden = $("#anioHidden").val();
			var MesHidden = $("#mesHidden").val();
			var CapacitacionHidden = $("#capacitacionHidden").val();
			var CapacitadorHidden = $("#capacitadorHidden").val();
			var CANTPROGRAMADOSHidden = $("#cantidadAsisHidden").val();
			var LinkDriveHidden = $("#linkDriveHidden").val(); // Agregamos esta línea
			var CategoriaHidden = $("#categoriaHidden").val();
			var TemaHidden = $("#temaHidden").val();

			// Itera a través de todas las filas en la tabla
			$("#tableBody tr").each(function() {
				var rowData = {
					centroCosto: $(this).find(".centroCosto").val(),
					cargo: $(this).find(".campoCargo").val(),
					nombre: $(this).find(".campoNombre").val(),
					tipoInvitacion: $(this).find(".tipoInvitacion").val(),
					usu: usu,
					NROPROG: NROPROG
				};

				data.push(rowData);
			});

			// Agrega las variables adicionales a la solicitud de datos
			data.push({
				AnioHidden: AnioHidden,
				MesHidden: MesHidden,
				CapacitacionHidden: CapacitacionHidden,
				CapacitadorHidden: CapacitadorHidden,
				CANTPROGRAMADOSHidden: CANTPROGRAMADOSHidden,
				CategoriaHidden: CategoriaHidden,
				TemaHidden: TemaHidden,
				LinkDriveHidden: LinkDriveHidden // Agregamos esta línea
			});

			// Muestra los datos por consola
			console.log("Datos de las filas generadas:", data);

			// Realiza la solicitud AJAX para enviar los datos a dataToSend.php
			$.ajax({
				type: "POST",
				url: "dataToSend.php",
				data: {
					usu: usu,
					NROPROG: NROPROG,
					dataToSend: data,
					AnioHidden: AnioHidden,
					MesHidden: MesHidden,
					CapacitacionHidden: CapacitacionHidden,
					CapacitadorHidden: CapacitadorHidden,
					CANTPROGRAMADOSHidden: CANTPROGRAMADOSHidden,
					CategoriaHidden: CategoriaHidden,
					TemaHidden: TemaHidden,
					LinkDriveHidden: LinkDriveHidden // Agregamos esta línea
				},
				success: function(response) {
					// Maneja la respuesta del servidor si es necesario
					console.log("Respuesta del servidor:", response);
					// Redirige al usuario a una página o realiza otras operaciones si es necesario
					// window.location.href = "tu_pagina_de_redireccion.php";
				},
				error: function(xhr, status, error) {
					// Maneja errores si es necesario
					console.log("Error en la solicitud AJAX:", error);
				}
			});
		});

		// Evento de clic en el botón "No guardar"
		$(".denyButton").click(function() {
			// Limpia la consola
			console.clear();
		});
	});
</script>


<!-- script de suma -->
<script>
	$(document).ready(function() {
		// Evento de clic en el botón "+"
		$(document).on("click", ".incrementButton", function() {
			// Encontrar el campo de "Asistentes programados" por su identificador
			var cantidadAsisField = $("#cantidadAsis");

			// Obtener el valor actual del campo
			var currentValue = parseInt(cantidadAsisField.val()) || 0;

			// Incrementar el valor y actualizar el campo
			currentValue = currentValue + 1;
			cantidadAsisField.val(currentValue);

			// Actualizar el campo oculto con el nuevo valor
			$("#cantidadAsisHidden").val(currentValue);
		});
	});
</script>

<!-- script de eliminar fila y restar 1 -->
<script>
	$(document).ready(function() {
		// Evento de clic en el botón "-"
		$(document).on("click", ".deleteButton", function() {
			// Verificar si hay más de una fila antes de eliminar
			if ($("#tableBody tr").length > 1) {
				// Eliminar la fila actual
				$(this).closest("tr").remove();

				// Restar 1 al valor de CANTPROGRAMADOS
				var cantidadAsisField = $("#cantidadAsis");
				var currentValue = parseInt(cantidadAsisField.val()) || 0;
				if (currentValue > 0) {
					cantidadAsisField.val(currentValue - 1);
				}
			} else {
				// Mostrar un mensaje si no se pueden eliminar todas las filas
				alert("No se pueden eliminar todas las filas.");
			}
		});
	});
</script>

<!-- script de alerta -->
<script>
	$(document).ready(function() {
		$('.showAlertButton').click(function() {
			// Realizar la validación aquí
			if (validarCampos()) {
				Swal.fire({
					title: '¿Quieres actualizar esta programación?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: 'Guardar',
					denyButtonText: `No guardar`,
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire('¡Actualizado!', '', 'success');
						// Espera 2 segundos y luego cierra la ventana

						// Activa y hace clic en el botón "enviarButton"
						$(".enviarButton").show().click();
					} else if (result.isDenied) {
						Swal.fire('Los cambios no se realizaron', '', 'info');
					}
				});
			} else {
				Swal.fire('Por favor, complete todos los campos en la tabla.', '', 'error');
			}
		});
	});

	function validarCampos() {
		// Obtener todas las filas en la tabla
		var filas = $('#tableBody tr');

		for (var i = 0; i < filas.length; i++) {
			var fila = filas[i];

			// Obtener los campos dentro de la fila
			var centroCosto = $(fila).find('.centroCosto').val();
			var campoCargo = $(fila).find('.campoCargo').val();
			var campoNombre = $(fila).find('.campoNombre').val();
			var tipoInvitacion = $(fila).find('.tipoInvitacion').val();

			// Realizar la validación
			if (centroCosto === '' || campoCargo === '' || campoNombre === '' || tipoInvitacion === '') {
				return false; // Al menos un campo está vacío
			}
		}

		return true; // Todos los campos están rellenados
	}
</script>

<!-- script cerrar ventana -->
<script>
	document.getElementById("cerrarBtn").addEventListener("click", function() {
		window.close();
	});
</script>


