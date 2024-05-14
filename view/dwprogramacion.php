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
		$Val = ($_GET['Mes'] == 13) ? $Mes = date("m") : $Mes = $_GET['Mes'];
		$Cuerpo = '<li class="list-group-item list-group-item">Consulta año ' . $Anio . ' del mes ' . $Func->ListMeses(2, $Mes) . '</li>';
		$Arr = $Func->ListProgramacion($Anio, $Mes);
	}
?>

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
						<?php echo $Cuerpo ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<form method="GET">
		<div class="container">
			<div class="text-right mt-3">
				<div class="row">

					<div class="col-md-4">
						<div class="form-group">
							<select list="Anio" class="form-control" type="text" name="Anio" required>
								<?php for ($i = 2022; $i <= Date("Y"); $i++) {
									$selected = ($i == $Anio) ? 'selected="selected"' : '';
									echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<select list="Mes" class="form-control" type="text" name="Mes" placeholder="Seleccione el mes" required>
								<option value="13">Seleccione el mes</option>
								<?php foreach ($Func->ListMeses(1, 0) as $admon) {
									$selected = ($admon['Mes'] == $Mes) ? 'selected="selected"' : '';
									echo '<option value="' . $admon['Mes'] . '" ' . $selected . '>' . $admon['NombMes'] . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<center><input name="Verprog" style="width: 100%" class="btn btn-success" type="submit" value="¡Cargar Información!" /></center>
					</div>
				</div>
			</div>
		</div>
	</form>

	<?php if ($est == 1) : ?>

		<div class="container">
			<div class="text-right mt-4">
				<div class="row">
					<div class="col-md-12">
						<table align="center" style="width: 100%">
							<tr>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>Cump. Legal</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>Tipo formación</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>Capacitacion</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>Capacitador</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>Categoria</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>Tema</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong>C. Personas Prog</strong></font>
								</td>
								<td bgcolor="#198754" align='center'>
									<font color="white"><strong><img style='width: 20px; height: 20px' src='../Imagenes/lupa.png'></a></strong></font>
								</td>
							</tr>
							<?php
							if (count($Arr) !== 0) {

								foreach ($Func->ListProgramacion($Anio, $Mes) as $a) {

									echo "<tr align='center'> 
								<td>" . $a['Cumpleg'] . "</td>
								<td>" . $a['TFORM'] . "</td>
								<td>" . utf8_decode($a['CAPACITACION']) . "</td>
								<td>" . utf8_decode($a['NOMCAP']) . "</td>
								<td>" . utf8_encode($a['CATEGORIA']) . "</td>
								<td>" . utf8_encode($a['SUBTIPO']) . "</td>
								<td>" . $a['CANTIDADPROG'] . "</td> ";

									$ruta = "popup/ModProgramacion.php?NROPROG=" . $a['NROPROG'];
									echo "<td style='white-space:nowrap' align='right'>"; ?> <a href="<?php echo $ruta ?>" target="popup" onclick="localStorage.clear(); window.open('<?php echo $ruta ?>','popup','width=1600,height=600,scrollbars=no,resizable=no');"><img style='width: 20px; height: 20px' src='../Imagenes/lupa.png'></a></td>
								<?php
									echo "</tr>";
								} ?>
							<?php } else { ?>
								<div class="alert alert-danger" role="alert" align="center">No hay programaciones disponibles en esta fecha</div>
							<?php } ?>
						</table>
					</div>
				</div>

				<div class="form-group mt-5"">	
                <center><button id=" btnDescargar" style="width: 50%" onclick="actualizarVentana()" class="btn btn-success">Actualizar Ventana</button></center>
				</div>
			</div>
		</div>
		
		<script>
			function actualizarVentana() {
				location.reload();
			}
		</script>

	<?php endif ?>

<?php } else {
?><script languaje "JavaScript">
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script><?php
			}
