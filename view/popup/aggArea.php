<?php
header('Content-Type: text/html; charset=UTF-8');
require '../../Funciones/funcionalidades.php';
$Func = new Funciones;
session_start();
$usu = $_SESSION['usuario'];
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
		<center><a class="navbar-brand"><strong>Maestro:</strong> Agregar Tipo o Categoria</a> </center>
	</div>
</nav>


<form autocomplete="off" action="../../Funciones/aggarea.php" method="POST" class="form-register">
	<div class="container">
		<div class="text-right mt-5">
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success" role="alert">Por favor, ingrese el tipo o la categoria</div>
				</div>

				<div class="col-md-12"><br></div>

				<div class="col-md-9">
					<input placeholder="Nombre" class="form-control" type="text" name="OPCION" required>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<select id="TIPOOPCION" class="form-control" name="TIPOOPCION" required>
							<option value="">Seleccione ... </option>
							<option value="2">Categoria</option>
							<option value="1">Tipo</option>
						</select>
					</div>
				</div>

				<div class="col-md-12"><br></div>

				<div class="col-md-12">
					<input type="submit" name="Crear" class="btn btn-success" style="width: 100%">
				</div>


				<div class="container" style="margin-top: 50px;">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-striped">
								<thead class="table-dark">
									<tr>
										<th>ID</th>
										<th>TIPO</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$resultados = $Func->ListMaestrosT();
									if ($resultados) {
										foreach ($resultados as $resultado) {
											echo "<tr>";
											echo "<td>" . $resultado['ID'] . "</td>";
											echo "<td>" . $resultado['OPCION'] . "</td>";
											echo "</tr>";
										}
									} else {
										echo "<tr><td colspan='2'>No hay resultados</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table table-striped">
								<thead class="table-dark">
									<tr>
										<th>ID</th>
										<th>CATEGORIA</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$resultados = $Func->ListMaestrosC();
									if ($resultados) {
										foreach ($resultados as $resultado) {
											echo "<tr>";
											echo "<td>" . $resultado['ID'] . "</td>";
											echo "<td>" . $resultado['OPCION'] . "</td>";
											echo "</tr>";
										}
									} else {
										echo "<tr><td colspan='2'>No hay resultados</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</form>