<!-- Agregar la biblioteca SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

include 'con_palmerdb.php';
session_start();
$usu = $_SESSION['usuario'];

if (isset($_POST['ModPramacion'])) {
	$NROPROG = $_POST['NROPROG'];
	 $Anio = $_POST['Anio'];
	$Mes = $_POST['Mes'];
	$Capacitacion = $_POST['Capacitacion'];
	$CANTPROG = $_POST['CANTPROGRAMADOS'];
	$CAPACITADOR = $_POST['CAPACITADOR'];
	$CATEGORIA = $_POST['categoriaCap'];
	$TEMACAT = $_POST['temaCap'];
	$CANTUSERSELECT = $_POST['CANTUSERSELECT'];
	$LINKBITACORA = $_POST['linkDrive'];
	echo $Costo = $_POST['Costo'];

	for ($i = 1; $i <= $CANTUSERSELECT; $i++) {
		$CHECKCOD = $_POST['checks' . $i];
		$TIPO = $_POST['tipoInvitacion' . $i];

		$CODRESULT = odbc_exec($conexion, "SELECT CODIGOEMPL FROM PLATCAPACITACIONES.dbo.Capacitaciones WHERE NROPRGC = $NROPROG AND CODIGOEMPL = '$CHECKCOD'");
		$CODEXIST = odbc_result($CODRESULT, 'CODIGOEMPL');

		if ($CHECKCOD != NULL && $CHECKCOD !== $CODEXIST) {
			$QryPrg = "INSERT INTO PLATCAPACITACIONES.dbo.Capacitaciones (NROPRGC, CODIGOEMPL, APRUEBA, Observaciones, FECCARGA, USUARIO, TIPOUSUARIO, ESTADOASIS, REPROBADO) 	
			VALUES ('$NROPROG', '$CHECKCOD', NULL, 'No tiene observacion', GETDATE(), '$usu', '$TIPO' , 2, 2)";
			$Dato = odbc_exec($conexion, $QryPrg);
		} else {
?>
			<script>
				alert("¡este usuario ya esta registrado! <?php echo $CODEXIST ?>");
			</script><?php
					}
				}

				$QuerAct = odbc_exec($conexion, "UPDATE PLATCAPACITACIONES.dbo.Programacion SET Anio = $Anio,Bitacora = '$LINKBITACORA', Mes = $Mes, Capacitacion = '$Capacitacion',CATEGORIA = '$CATEGORIA' ,SUBTIPO = '$TEMACAT' ,CAPACITADOR = '$CAPACITADOR', CANTIDADPROG = '$CANTPROG', CANTIDADASIS = '$CANTUSERSELECT' WHERE NROPROG = $NROPROG");

				if ($QuerAct) {
						?>
		<script>
			// alert("¡Se modificó exitosamente la programación!");
			// window.location.href = "/IKIGAI/view/popup/ModProgramacion.php?NROPROG=<?php echo $NROPROG; ?>";

			// Recargar la página después de 2000 milisegundos (2 segundos)
			setTimeout(function() {
				location.reload();
			}, 2000);
		</script><?php
				} else {
					?>
		<script>
			alert("¡Lo sentimos, no se pudieron cargar datos!");
		</script><?php
				}
			}
					?>



