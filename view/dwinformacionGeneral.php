<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);
if (isset($_SESSION['usuario'])) {
	require 'header.php';
	require 'footer.php';
	require '../Funciones/funcionalidades.php';
	$Func = new Funciones;
	$Cuerpo = "";
	$est = 0;

	if (isset($_GET['Verprog'])) {
		$est++;
		$Anio = $_GET['Anio'];

		$Trimestre = $_GET['Trimestre'];
		$ValTris = ($Trimestre == 13) ? 'No elige' : $Trimestre;

		$COSTOCC = $_GET['Costo'];
		$ValCODCC = ($COSTOCC == NULL) ? 'No elige' : $COSTOCC;

		$Sexo = $_GET['Sexo'];
		$ValSex = ($Sexo == null) ? 'No elige' : $Sexo;

		$CODIGO = $_GET['Cargo'];
		$ValCarg = ($CODIGO == null) ? 'No elige' : $CODIGO;

		$Categoria = $_GET['Cap'];
		$ValCat = ($Categoria == null) ? 'No elige' : $Categoria;

		$Subtipo = $_GET['Tema'];
		$ValTipo = ($Subtipo == null) ? 'No elige' : $Subtipo;

		$Cuerpo = '<li class="list-group-item list-group-item"><strong>Consulta año:</strong> ' . $Anio . '</li>';
		$Vertris = '<li class="list-group-item list-group-item"><strong>Trimestre:</strong> ' . $ValTris . '</li>';
		$VerCodcc = '<li class="list-group-item list-group-item"><strong>CC Mayor:</strong> ' . $ValCODCC . '</li>';
		// $VerSex = '<li class="list-group-item list-group-item"><strong>Sexo:</strong> ' . $ValSex . '</li>';
		$VerCarg = '<li class="list-group-item list-group-item"><strong>Cargo:</strong> ' . $ValCarg . '</li>';
		$VerCat = '<li class="list-group-item list-group-item"><strong>Tipo:</strong> ' . $ValCat . '</li>';
		$VerTipo = '<li class="list-group-item list-group-item"><strong>Tema:</strong> ' . $ValTipo . '</li>';
	}

?>


	<style>
		.hidden-cell {
			display: none;
		}
	</style>

	<div class="container">
		<div class="text-right mt-3">
			<div class="row">
				<div class="col-md-12">
					<ul class="list-group list-group-horizontal">
						<a style="text-decoration:none" href="index.php">
							<li class="list-group-item list-group-item-success">Menú principal</li>
						</a>
						<a style="text-decoration:none" href="dwprogramacion.php">
							<li class="list-group-item list-group-item-success">Seleccione la programación</li>
						</a>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="text-right mt-3">
			<div class="row">
				<div class="col-md-12">
					<ul class="list-group list-group-horizontal">
						<?php echo $Cuerpo ?>
						<?php echo $Vertris ?>
						<?php echo $VerCodcc ?>
						<?php echo $VerSex ?>
						<?php echo $VerCarg ?>
						<?php echo $VerCat ?>
						<?php echo $VerTipo ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<form method="GET">
		<div class="container">
			<div class="text-right mt-3">
				<div class="row">

					<div class="col-md-2">
						<label>Año</label>
						<div class="form-group">
							<select list="Anio" class="form-control" type="text" name="Anio" required>
								<?php
								for ($i = 2022; $i <= Date("Y"); $i++) {
									$selected = ($i == $_GET['Anio']) ? 'selected' : '';
									echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<label>Trimestre</label>
						<div class="form-group">
							<select list="Trimestre" class="form-control" type="text" name="Trimestre" required>
								<option value="" disabled selected>Seleccione el trimestre</option>
								<option value="1" <?php if ($_GET['Trimestre'] == '1') echo 'selected'; ?>>Trimestre 1</option>
								<option value="2" <?php if ($_GET['Trimestre'] == '2') echo 'selected'; ?>>Trimestre 2</option>
								<option value="3" <?php if ($_GET['Trimestre'] == '3') echo 'selected'; ?>>Trimestre 3</option>
								<option value="4" <?php if ($_GET['Trimestre'] == '4') echo 'selected'; ?>>Trimestre 4</option>
							</select>

						</div>
					</div>

					<div class="col-md-3">
						<label>Centro de Costo</label>
						<div class="form-group">
							<select list="Mes" class="form-control" type="text" name="Costo" id="centroCosto" >
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

					<div class="col-md-4">
						<label>Cargo</label>
						<div class="form-group">
							<select list="Mes" class="form-control" type="text" name="Cargo" id="campoCargo" >
								<option value="">Seleccione el Cargo</option>
								<?php
								foreach ($Func->ListCargo($COSTOCC) as $a) {
									echo '<option value="' . $a['CODCARGO'] . '">' . $a['CARGO'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>


					<div class="col-md-12"><br></div>

					<div class="col-md-4">
						<label>Tipo</label>
						<div class="form-group">
							<select list="Mes" class="form-control" type="text" name="Cap" placeholder="Seleccione el Tipo">
								<option value="">Seleccione el Tipo de Capacitación</option>
								<?php
								foreach ($Func->ListSelectProgra('1') as $a) {
									$selected = (utf8_encode($a['ID']) == $_GET['Cap']) ? 'selected' : '';
									echo '<option value="' . utf8_encode($a['ID']) . '" ' . $selected . '>' . utf8_encode($a['OPCION']) . '</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<label>Tema</label>
						<div class="form-group">
							<select list="Tema" class="form-control" type="text" name="Tema" placeholder="Seleccione el Tema">
								<option value="">Seleccione el Tema</option>
								<?php
								foreach ($Func->ListSelectProgra('2') as $a) {
									$selected = (utf8_encode($a['ID']) == $_GET['Tema']) ? 'selected' : '';
									echo '<option value="' . utf8_encode($a['ID']) . '" ' . $selected . '>' . utf8_encode($a['OPCION']) . '</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="col-md-12"><br></div>



					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4" style="text-align: center;">
							<center><input name="Verprog" style="width: 100%" class="btn btn-success" type="submit" value="¡Mostrar Información!" /></center>
						</div>
						<div class="col-md-4"></div>
					</div>


				</div>
			</div>
		</div>
	</form>

	<?php if ($est == 1) : ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<table class="table table-bordered table-hover" cellspacing="0" id="mtable">
						<thead>
							<tr align="center" bgcolor="#198754">
								<td class="hidden-cell"><strong>
										<font color="white">ID
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Año
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Mes
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Tipo formación
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Cumpl. Legal
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Capacitación
									</strong></font>
								</td>
								<td class="capacitacion-column"><strong>
										<font color="white">Categoria
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Subtipo
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Costo Total
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Personas
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Hombres
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Mujeres
									</strong></font>
								</td>
								<td><strong>
										<font color="white">Binario
									</strong></font>
								</td>
								<td><strong>
										<font color="white">VER
									</strong></font>
								</td>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($Func->ListCapCompletasTrim($Anio, $Trimestre, $CODIGO, $Categoria, $Subtipo, $Sexo, $COSTOCC) as $a) {
								echo "<tr>
								<td align='center' class='hidden-cell'>" . $a['NROPROG'] . "</td>
								<td align='center'>" . $a['ANIO'] . "</td>
								<td align='center'>" . $Func->ListMeses(2, $a['MES']) . "</td>
								<td align='center'>" . $a['TFORM'] . "</td>
								<td align='center'>" . $a['Cumpleg'] . "</td>
								<td align='center'>" . utf8_encode($a['CAPACITACION']) . "</td>
								<td align='center'>" . utf8_encode($a['NCategoria']) . "</td>
								<td align='center'>" . utf8_encode($a['NSubtipo']) . "</td>
								<td align='right'>$" . number_format($a['PRECIO'], 0, ',', '.') . "</td>
								<td align='right'>" . number_format($a['CANTIDADASIS'], 0) . "</td>
								<td align='center'>" . $a['Hombres'] . "</td>
								<td align='center'>" . $a['Mujeres'] . "</td>
								<td align='center'>0</td>
								
								
								<td align='right'>
									<form action='popup/VerInfoEmpleadoCapGeneral.php' target='_blank' onsubmit='window.open('popup/VerInfoEmpleadoCapGeneral.php', 'popup','width=1600,height=1600,scrollbars=no,resizable=no')' method='POST'>
										<input type='hidden' name='NROPROG' value='" . $a['NROPROG'] . "'>
										<input name='Download' style='width: 100%'' class='btn btn-success' type='submit' value='VER'/>
									</form>
								</td>
							</tr>";
							}
							?>
						</tbody>

						<tfoot>
							<tr align="center" bgcolor="#dddddd">
								<th class="hidden-cell"></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								
							</tr>
						</tfoot>
					</table>
				</div>
			</div>

		</div>
		</div>
	<?php endif ?>


	<!-- Inicio DataTable -->
	<script>
		jQuery(document).ready(function() {


			var filtros = $('#mtable').DataTable({
				initComplete: function() {
					this.api()
						.columns([5, 6, 7])
						.every(function() {
							var column = this;
							var select = $('<select class="form-select" ><option value=""></option></select>')
								.appendTo($(column.footer()).empty())
								.on('change', function() {
									var val = $.fn.dataTable.util.escapeRegex($(this).val());
									column.search(val ? '^' + val + '$' : '', true, false).draw();
								});

							column
								.data()
								.unique()
								.sort()
								.each(function(d, j) {
									select.append('<option value="' + d + '">' + d + '</option>');
								});
						});
				},
			});

			var lenguaje = jQuery('#mtable').DataTable({
				responsive: true, // Hace que la tabla sea responsive
				info: false,
				select: true,
				destroy: true,
				jQueryUI: true,
				paginate: true,
				iDisplayLength: 30,
				searching: true,
				dom: 'Bfrtip',
				buttons: [
					'excel'
					// 'copy', 'csv', 'excel'
				],
				language: {
					lengthMenu: 'Mostrar _MENU_ registros por página.',
					zeroRecords: 'Lo sentimos. No se encontraron registros.',
					info: 'Mostrando: _START_ de _END_ - Total registros: _TOTAL_',
					infoEmpty: 'No hay registros aún.',
					infoFiltered: '(filtrados de un total de _MAX_ registros)',
					search: 'Búsqueda',
					LoadingRecords: 'Cargando ...',
					Processing: 'Procesando...',
					SearchPlaceholder: 'Comience a teclear...',
					paginate: {
						previous: 'Anterior',
						next: 'Siguiente',
					}
				}
			});
		});
	</script>
	<!-- Fin DataTable -->



	<script>
		$(document).ready(function() {
			// Cuando cambia la selección de Centro de Costo
			$("#centroCosto").change(function() {
				var selectedCentroCosto = $(this).val(); // Obtener el valor seleccionado
				// Realizar una solicitud AJAX para obtener las opciones de Cargo basadas en Centro de Costo
				$.ajax({
					url: "obtener_cargos.php", // Ruta del script PHP que obtiene los cargos
					type: "GET",
					data: {
						costo: selectedCentroCosto
					}, // Pasar el Centro de Costo seleccionado como parámetro
					success: function(data) {
						// Actualizar el campo de selección de Cargo con las nuevas opciones
						$("#campoCargo").html(data);
					}
				});
			});
		});
	</script>









<?php } else { ?>
	<script language="JavaScript">
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script>
<?php } ?>