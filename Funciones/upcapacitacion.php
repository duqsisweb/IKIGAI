<?php
session_start();
error_reporting(0);
require 'funcionalidades.php';
$Func = new Funciones;
if (isset($_SESSION['usuario'])) {
	include("con_palmerdb.php");
	date_default_timezone_set('America/Bogota');	
	$Max = Date("Y-m-d");	
	
	if (isset($_POST['cargarNotas'])) {
		$usu = $_SESSION['usuario'];
		$NROPROG = $_POST['NROPROG'];

		$CAPCT = $_POST['CAPT'];
		$hinicio = $_POST['hinicio'];
		$hfinal = $_POST['hfinal'];
		$lugar = $_POST['lugar'];
		$description = $_POST['description'];
		$TOTALASIS = $_POST['totalAsist'];
		$Bitacora = $_POST['Bitacora'];
		$fecha = $_POST['fecha'];
		$TotalValorCapacitacion = 0;
		$asisReprogramados = 0;

		$NotaCapacitador = ($_POST['NotaCapacitador'] != NULL) ? $_POST['NotaCapacitador'] : 0;

		if(isset($_POST['fecha'])) {
			$QuerAct = odbc_exec($conexion, "IF NOT EXISTS(SELECT * FROM PLATCAPACITACIONES.dbo.CabeceraCap WHERE NROPROG = '$NROPROG') BEGIN
			INSERT INTO PLATCAPACITACIONES.dbo.CabeceraCap (NROPROG, FECHA, HINICIO, HFINAL, LUGAR, DESCRIPCION, USUARIO, FECACT) 
			VALUES ($NROPROG, '$fecha', '$hinicio', '$hfinal', '$lugar', '$description', '$usu', GETDATE()) END");
		}
		
		$Duracion = odbc_result(odbc_exec($conexion, "SELECT DATEDIFF(HOUR, HINICIO, HFINAL) Tiempo FROM PLATCAPACITACIONES..CabeceraCap WHERE NROPROG = $NROPROG"), 'Tiempo');
		
		for ($i = 1; $i <= $TOTALASIS; $i++) {
			$COD = $_POST['codigoEmpl' . $i];
			$NOTA = $_POST['nota' . $i];
			$OBSERVACIONTEXT = $_POST['observacion' . $i];
			$ASISTENCIA = $_POST['asistencia' . $i];

			if($ASISTENCIA == 1){	
				$ValorHoraEmpleado = $Func->ValorHoraEmpleado($COD);	
				$TotalValorCapacitacion = $TotalValorCapacitacion + ($ValorHoraEmpleado * ($Duracion));	
			}	

			$PASOPRUEBA = ($NOTA >= 35) ? 1 : 2;
			$OPTION = ($NOTA == "") ? 'NULL' : $NOTA;
			$OBSERVACION = ($OBSERVACIONTEXT == "") ? 'No tiene observacion' : $OBSERVACIONTEXT;	

			if (($NOTA < 35) || ($NOTA === "")) {
				$QryPrg2="IF EXISTS(SELECT * FROM PLATCAPACITACIONES.dbo.REPROGRAMACION WHERE CODIGOEMPL = '$COD' AND NROPROG = '$NROPROG') BEGIN	
				UPDATE PLATCAPACITACIONES.dbo.REPROGRAMACION SET ESTADOEMPL = '0', NOTA = 0 WHERE CODIGOEMPL = '$COD' AND NROPROG = '$NROPROG'	
				UPDATE PLATCAPACITACIONES.dbo.Capacitaciones SET REPROBADO = 3, APRUEBA = $OPTION, ASISTENCIA = '$ASISTENCIA' WHERE CODIGOEMPL = '$COD' AND NROPRGC = '$NROPROG'
				
				INSERT INTO PLATCAPACITACIONES..REPROGRAMACION (CODIGOEMPL,NROPROG,Observacion,ESTADOEMPL,FECHACALIF,NOTA,USUARIOCALIF)
				VALUES ('$COD','$NROPROG','$OBSERVACION', '1', GETDATE(),$OPTION , '$usu') END	
				ELSE	
				BEGIN
				INSERT INTO PLATCAPACITACIONES..REPROGRAMACION (CODIGOEMPL,NROPROG,Observacion,ESTADOEMPL,FECHACALIF,NOTA,USUARIOCALIF)
				VALUES ('$COD','$NROPROG','Reprobo', '1', GETDATE(), $OPTION, '$usu')
				UPDATE PLATCAPACITACIONES.dbo.Capacitaciones SET REPROBADO = 3 WHERE CODIGOEMPL = '$COD' AND NROPRGC = '$NROPROG' END";
				odbc_exec($conexion, $QryPrg2);
				$asisReprogramados = 1;
			} else {
				$QryPrg="IF EXISTS(SELECT * FROM PLATCAPACITACIONES.dbo.Capacitaciones WHERE CODIGOEMPL = '$COD' AND NROPRGC = '$NROPROG') BEGIN	
				UPDATE PLATCAPACITACIONES.dbo.Capacitaciones SET APRUEBA = $OPTION, FECCARGA = GETDATE(), Observaciones = '$OBSERVACION', ESTADOASIS = '$PASOPRUEBA',REPROBADO = 1, ASISTENCIA = '$ASISTENCIA' WHERE CODIGOEMPL = '$COD' AND NROPRGC = '$NROPROG'
				UPDATE PLATCAPACITACIONES.dbo.REPROGRAMACION SET ESTADOEMPL = '0' WHERE CODIGOEMPL = '$COD' AND NROPROG = '$NROPROG' END
				ELSE	
				BEGIN	
				INSERT INTO PLATCAPACITACIONES.dbo.Capacitaciones (NROPRGC, CODIGOEMPL, APRUEBA, Observaciones, FECCARGA, ESTADOASIS,TIPOUSUARIO, USUARIO, ASISTENCIA,REPROBADO) 	
				VALUES ('$NROPROG', '$COD', '$OPTION', '$OBSERVACION', GETDATE(), '$PASOPRUEBA', '2' , '$usu', '$ASISTENCIA', 1) END";	
				odbc_exec($conexion, $QryPrg);	
			}
		}

		$totalAsistentes = odbc_result(odbc_exec($conexion, "SELECT COUNT(ASISTENCIA) AS TOTALASISTENCIA FROM PLATCAPACITACIONES..Capacitaciones WHERE ASISTENCIA = '1' AND NROPRGC = '$NROPROG'"), 'TOTALASISTENCIA');

		odbc_exec($conexion, "UPDATE PLATCAPACITACIONES.dbo.Programacion SET Bitacora = '$Bitacora', CANTIDADASIS = $totalAsistentes, PRECIO = PRECIO + $TotalValorCapacitacion, ESTADO = 1 WHERE NROPROG = $NROPROG");

		odbc_exec($conexion, "IF EXISTS(SELECT * FROM PLATCAPACITACIONES.dbo.CalCapacitador WHERE Capt = '$CAPCT' AND NROPROG = '$NROPROG') 
		BEGIN UPDATE PLATCAPACITACIONES.dbo.CalCapacitador SET FecIng = GETDATE(), Nota = '$NotaCapacitador', Usuario = '$usu', NROPROG = '$NROPROG' 
		WHERE Capt = '$CAPCT' AND NROPROG = '$NROPROG' END	
		ELSE	
		BEGIN	
		INSERT INTO PLATCAPACITACIONES.dbo.CalCapacitador (Capt, Nota, Usuario, FecIng, NROPROG) 
		VALUES ('$CAPCT', '$NotaCapacitador', '$usu', GETDATE(), '$NROPROG' ) END");

		if ($asisReprogramados === 1) { ?>

			<!DOCTYPE html>
			<html lang="en">

			<head>
				<meta charset="utf-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
				<meta name="description" content="Plataforma de capacitaciones para Gestion Humana" />
				<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
				<meta name="author" content="José Luis Casilimas Martinez" />
				<title>Plataforma de Capacitaciones</title>
				<link rel="icon" type="image/x-icon" href="../assets/Icono.ico" />
				<link href="../css/styles.css" rel="stylesheet" />
			</head>

			<div class="container">
				<div class="text-right mt-5">
					<h3 align="center">Reprogramacion</h3>

					<div class="row">
						<div class="col-md-12 mt-5">

							<table align="center" style="width: 80%">
								<tr>
									<td bgcolor="#198754" align='center'>
										<font color="white">
											<font color="white"><strong>NOMBRE EMPLEADO</strong></font>
									</td>
									<td bgcolor="#198754" align='center'>
										<font color="white">
											<font color="white"><strong>CAPACITACION</strong></font>
									</td>
									<td bgcolor="#198754" align='center'>
										<font color="white">
											<font color="white"><strong>USUARIO CALIFICA</strong></font>
									</td>
									<td bgcolor="#198754" align='center'>
										<font color="white">
											<font color="white"><strong>OBSERVACION</strong></font>
									</td>
									<td bgcolor="#198754" align='center'>
										<font color="white">
											<font color="white"><strong>NOTA</strong></font>
									</td>
								</tr>
								<?php 
								foreach ($Func->EMPLREPROG($NROPROG) as $RP) {

								echo "<tr align='center' >
									<td align='left'>" . utf8_decode($RP['NOMBRE']) . "</td>
									<td>" . utf8_decode($RP['CAPACITACION']) . "</td>
									<td>" . utf8_decode($RP['USUARIOCALIF']) . "</td>
									<td>" . utf8_decode($RP['Observacion']) . "</td>
									<td>" . utf8_decode($RP['NOTA']) . "</td>
								</tr>";
								
								} ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12"><br></div>

		
			<form action="reprogramarCap.php" method="POST">
				<div class="container">
					<div class="text-right mt-5">
						<div class="row">
							<div class="col-md-12">
								<h3 align="center">Selecciona la fecha para reprogramar la capacitacion</h3>
							</div>

							<div class="col-md-12">
								<hr><br>
							</div>

							<?php 
								$COUNT = 1;
								foreach ($Func->EMPLREPROG($NROPROG) as $RP) {

								echo "<input type='hidden' value='" . trim(utf8_decode($RP['CODIGO'])) . "' name='cod".$COUNT."'>";
								$COUNT++;
								
							} ?>

							<input type='hidden' value='<?php echo $COUNT - 1 ?>' name='cantidad'>
							<input type='hidden' value='<?php echo $NROPROG ?>' name='CAPACITACION'>

							<div class="col-md-4">
								<div class="form-group">
									<li class="list-group-item list-group-item" style="margin-top: 20px; background: #CBCBCB;">Fecha de reprogramacion</li>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Fecha <font color="red"><strong>*</strong></font> </label>
									<input class="form-control" type="date" min="<?php echo $Max ?>" name="fecha" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<center><input name="reprogCap" style="width: 100%; height: 40px; margin-top:22px;" class="btn btn-success" type="submit" value="Reprogramar" /></center>
								</div>
							</div>
						</div>
					</div>
			</form>
			</html> 	
		<?php

		} else { ?>
			<script>
				setTimeout(function() {
					window.close();
				}, 500);
				alert("Se califico exitosamente la capacitacion");
			</script>
		<?php }

	} else { ?>
		<script>
			alert("ocurrido un error");
		</script>
	<?php } ?>

<?php } else { ?>
	<script>
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script>
<?php } ?>