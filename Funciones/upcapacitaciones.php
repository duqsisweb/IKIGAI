<?php
// error_reporting(0);
session_start();
if (isset($_SESSION['usuario'])) {
	include '../con_palmerdb.php';
	if (isset($_POST['EnviarDocumento'])) {
		$exito = 0;
		$usu = $_SESSION['usuario'];
		$Comprobante = $_FILES['archivo'];

		$Serial = "SELECT ISNULL(MAX(P.NROPRGC), 0) AS SERIAL FROM PLATCAPACITACIONES.dbo.Capacitaciones P";
		$reslt = odbc_exec($conexion, $Serial);
		$Ser = odbc_result($reslt, 'SERIAL');

		$NroProgc = $Ser;

		$Documento = $Comprobante['name'];
		$tmpimagen = $Comprobante['tmp_name'];
		$extimagen = pathinfo($Documento);

		if ($Comprobante['error'] > 0) {
			$Estado = 0;
		} else {
			$permitidos = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			$limite_kb = 5000;

			if (in_array($Comprobante['type'], $permitidos) && $Comprobante['size'] <= $limite_kb * 3024) {

				$ruta_a = "../Documentos/Capacitacion/" . $Ser . "/";
				$ruta_dcto = $ruta_a . $Comprobante['name'];

				if (!file_exists($ruta_a)) {
					mkdir($ruta_a);
				}

				if (!file_exists($ruta_dcto)) {
					$resultado_a = @move_uploaded_file($Comprobante['tmp_name'], $ruta_dcto);

					if ($resultado_a) {
						require '../PHPExcel/Classes/PHPExcel/IOFactory.php';
						$nombreArchivo = $ruta_dcto;
						$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
						$objPHPExcel->setActiveSheetIndex(1);
						$numRows = $objPHPExcel->setActiveSheetIndex(1)->getHighestRow();
						for ($i = 4; $i <= $numRows; $i++) {

							// Lee el valor de $TFORM del archivo de Excel
							$TIPOUSUARIO = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
							$ASISTENCIA = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
							$VALIDACION  = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();

							if ($VALIDACION != "Usuario no existe") {
								
								$TIPOUSUARIOValue = ($TIPOUSUARIO == "OBLIGATORIO") ? 1 : 2;
								$ASISTENCIAValue = ($ASISTENCIA == "SI") ? 1 : 0;

								$NroProgc = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue() + $Ser;
								$CODIGOEMPL = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
								$APRUEBA = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
								$Observaciones  = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();

								if ($CODIGOEMPL != NULL) {
									// Luego, utiliza $TIPOSValue en tu consulta de inserción en la base de datos
									$QryPrg = "INSERT INTO PLATCAPACITACIONES.dbo.Capacitaciones
								( NROPRGC, CODIGOEMPL, APRUEBA, Observaciones, FECCARGA, USUARIO, TIPOUSUARIO, ASISTENCIA )
								VALUES 
								( '$NroProgc', '$CODIGOEMPL', '$APRUEBA', '$Observaciones', GETDATE(), '$usu', '$TIPOUSUARIOValue', '$ASISTENCIAValue' )";

									$Dato = odbc_exec($conexion, $QryPrg);
									if ($Dato) {

										$CONSULTA = "SELECT (V.VALORHORA/60)*DATEDIFF(MINUTE, HINICIO, HFINAL) AS costo FROM PLATCAPACITACIONES.dbo.Capacitaciones cap LEFT JOIN PALMERAS2013.DBO.MTEMPLEA v on v.CODIGO = cap.CODIGOEMPL LEFT JOIN [PLATCAPACITACIONES].[dbo].[CabeceraCap] p on cap.NROPRGC = p.NROPROG WHERE NROPRGC = '$NroProgc' AND CODIGOEMPL = '$CODIGOEMPL'";
										$resultado = odbc_exec($conexion, $CONSULTA);
										$COSTO = odbc_result($resultado, 'costo');
										odbc_exec($conexion, " UPDATE PLATCAPACITACIONES.dbo.Programacion set PRECIO = PRECIO + '$COSTO' WHERE NROPROG = '$NroProgc'");
										odbc_free_result($Dato); // Libera los recursos de la consulta
									}
									echo "<br>";
								}
							} else {
								// Mostrar alerta y salir del bucle
								echo "<script>alert('¡Usuario no válido en la fila $i del archivo Excel!');</script>";
								break;
							}
						}
						?><script languaje="javascript">
							window.location = "../view/upcapacitacion.php";
							alert("¡Se cargó con éxito la capacitación!");
						</script><?php
					} else {
						?><script languaje="javascript">
							window.location = "../view/upcapacitacion.php";
							alert("¡Hubo un error!");
						</script><?php
					}
				} else {
					?><script languaje="javascript">
						window.location = "../view/upcapacitacion.php";
						alert("¡Hubo un error!");
					</script><?php
				}
			} else {
				?><script languaje="javascript">
					window.location = "../view/upcapacitacion.php";
					alert("¡Por favor, suba un archivo válido (Excel)!");
				</script><?php
			}
		} // Cierre de las validaciones 0	
	}
} else {
	?><script languaje "JavaScript">
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script><?php
} // Cierre de Valid