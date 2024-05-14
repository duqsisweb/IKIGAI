<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);
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
						<a style="text-decoration:none" href="index.php">
							<li class="list-group-item list-group-item-success">Menú principal</li>
						</a>
						<li class="list-group-item list-group-item">Ver capacitaciones</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<form method="GET">
		<div class="container">
			<div class="text-right mt-3">
				<div class="row">
					<div class="col-md-12">
						<h3 align="center">Busqueda por codigo empleado</h3>
					</div>

					<div class="col-md-2">
						<div class="form-group"><label>Buscar empleado <font color="red"><strong>*</strong></font> </label></div>
					</div>

					<div class="col-md-10">
						<div class="form-group">
							<input type="text" name="codEmpleado" list="listaEmpl" style="width: 100%; padding: 4px;" placeholder="Busca un empleado">
							<datalist id="listaEmpl">
								<?php foreach ($Func->ListTodosEmpl() as $a) {
									echo '<option value="' . $a['CEDULA'] . '">' . $a['NOMBRE'] . '</option>';
								} ?>
							</datalist>
							</select>
						</div>
					</div>

					<div class="col-md-12 mt-3">
						<center><input name="VEREMPLEADO" style="width: 100%" class="btn btn-success" type="submit" value="Buscar por empleado" /></center>
					</div>
				</div>
			</div>
		</div>
	</form>

	<?php if (isset($_GET['VEREMPLEADO'])) :
		$CODEMPLEADO = $_GET['codEmpleado'];
		$Filtrado = $CODEMPLEADO;
	?>

		<?php if (count($Func->ListCapCompletas($Filtrado)) !== 0) { ?>
			<div class="container">
				<div class="text-right mt-3">
					<div class="col-md-12">
						<table class="table table-bordered" cellspacing="0">
							<thead>
								<tr align="center" bgcolor="#198754">
									<td><strong>
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
											<font color="white">Tipo formacion
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
									<td><strong>
											<font color="white">Categoria
										</strong></font>
									</td>
									<td><strong>
											<font color="white">Subtipo
										</strong></font>
									</td>
									<td><strong>
											<font color="white">N Personas
										</strong></font>
									</td>
									<td><strong>
											<font color="white">Costo Total
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
								foreach ($Func->ListCapCompletas($Filtrado) as $a) {
									echo "<tr>
								<td align='center'>" . $a['NROPROG'] . "</td>
								<td align='center'>" . $a['Anio'] . "</td>
								<td align='center'>" . $a['Mes'] . "</td>
								<td align='center'>" . $a['TFORM'] . "</td> 
								<td align='center'>" . $a['Cumpleg'] . "</td>
								<td align='center'>" . utf8_encode($a['CAPACITACION']) . "</td>
								<td align='center'>" . utf8_encode($a['NCategoria']) . "</td>
								<td align='center'>" . utf8_encode($a['NSubtipo']) . "</td>
								<td align='center'>" . number_format($a['CANTIDADASIS'], 0) . "</td>
								<td align='center'>$" . number_format($a['PRECIO'], 0, ',', '.') . "</td>
								<td align='center'>
									<form action='popup/VerInfoEmpleadoCap.php' target='popup' onsubmit='window.open('popup/VerInfoEmpleadoCap.php', 'popup','width=1600,height=600,scrollbars=no,resizable=no')' method='POST'>
										<input type='hidden' name='NROPROG' value='" . $a['NROPROG'] . "'>
										<input type='hidden' name='CODEMPLEADO' value='" . $CODEMPLEADO . "'>
										<input name='Download' style='width: 100%'' class='btn btn-success' type='submit' value='VER'/></center>
									</form>
								</td>
							</tr>";
								}  ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		<?php } else { ?>
			<div class="alert alert-danger mt-5" role="alert" align="center">Este usuario no tiene capacitaciones asignadas o no ha sido calificado</div>
		<?php } ?>

	<?php endif ?>

<?php } else { ?>
	<script languaje "JavaScript">
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script>
<?php } ?>