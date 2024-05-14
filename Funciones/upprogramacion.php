<?php
// error_reporting(0);
session_start();
if (isset($_SESSION['usuario'])) {
	include '../con_palmerdb.php';
	if (isset($_POST['EnviarDocumento'])) {
		$exito = 0;
		$usu = $_SESSION['usuario'];
		$Comprobante = $_FILES['archivo'];

		$Serial = "SELECT ISNULL(MAX(P.NROPROG), 0)+1 AS SERIAL FROM PLATCAPACITACIONES.dbo.Programacion P";
		$reslt = odbc_exec($conexion, $Serial);
		$Ser = odbc_result($reslt, 'SERIAL');

		$NroProg = $Ser;

		$Documento = $Comprobante['name'];
		$tmpimagen = $Comprobante['tmp_name'];
		$extimagen = pathinfo($Documento);

		if ($Comprobante['error'] > 0) {
			$Estado = 0;
		} else {
			$permitidos = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			$limite_kb = 5000;

			if (in_array($Comprobante['type'], $permitidos) && $Comprobante['size'] <= $limite_kb * 3024) {

				$ruta_a = "../Documentos/Programacion/" . $Ser . "/";
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
						$objPHPExcel->setActiveSheetIndex(0);
						$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();



						for ($i = 3; $i <= $numRows; $i++) {


							$TFORM = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
							$TFORMValue = ($TFORM == "INTERNA") ? 1 : 2;

							$CAPAC = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
							$CADOR = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
							$ANIO  = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
							$MES   = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();

							$LEGL = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
							$LEGLValue = ($LEGL == "SI") ? 1 : 0;

							$PROGR  = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
							$PASIS  = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
							// PARA LAS CATEGORIAS
							$CATEG  = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
							// PARA LOS TIPOS
							$TIPOS = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getCalculatedValue();



							$LINKD  = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getCalculatedValue();


							// PARA LA FECHA
							$FECHA = $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getCalculatedValue();
							// Convierte el valor de Excel a una fecha en formato UNIX timestamp
							$fechaUnixTimestamp = PHPExcel_Shared_Date::ExcelToPHP($FECHA);
							// Luego, formatea la fecha en el formato deseado
							$fechaFormateada = date("Y-m-d", $fechaUnixTimestamp);
							// echo "Valor de FECHA antes de la conversión: $fechaFormateada";


							// Obtén los valores de hora de las celdas Q y R
$horaInicioExcel = $objPHPExcel->getActiveSheet()->getCell('Q' . $i)->getValue(); // Obtiene el valor sin formato
$horaFinalExcel = $objPHPExcel->getActiveSheet()->getCell('R' . $i)->getValue(); // Obtiene el valor sin formato

// Ajuste de la zona horaria (5 horas)
$horaInicioExcel += 5 / 24; // Suma 5 horas
$horaFinalExcel += 5 / 24; // Suma 5 horas

// Convierte los valores de hora en formato Excel a timestamps de PHP
$timestampHoraInicio = PHPExcel_Shared_Date::ExcelToPHP($horaInicioExcel);
$timestampHoraFinal = PHPExcel_Shared_Date::ExcelToPHP($horaFinalExcel);

// Formatea los timestamps en el formato de hora deseado para la base de datos
$horaInicioFormatted = date("H:i:s", $timestampHoraInicio);
$horaFinalFormatted = date("H:i:s", $timestampHoraFinal);


							$DESCRIP  = $objPHPExcel->getActiveSheet()->getCell('S' . $i)->getCalculatedValue();
							$LUGAR  = $objPHPExcel->getActiveSheet()->getCell('T' . $i)->getCalculatedValue();


							if ($TFORMValue != NULL and $CAPAC != NULL) {
								$QryPrg = "INSERT INTO PLATCAPACITACIONES.dbo.Programacion (ID, NROPROG, TFORM, CAPACITACION, CAPACITADOR, ANIO, MES, USUARIO, FECCARGA, ESTADO, PRECIO, CANTIDADASIS, CUMPLEGAL, CATEGORIA, SUBTIPO, CANTIDADPROG, FECHA )
								VALUES ('$Ser', '$NroProg', '$TFORMValue', '$CAPAC', '$CADOR', '$ANIO', '$MES', '$usu', GETDATE(), 1, 0, '$PASIS', '$LEGLValue', '$CATEG', '$TIPOS', $PROGR, '$fechaFormateada')";
								$Dato = odbc_exec($conexion, $QryPrg);

								if ($Dato) {
									odbc_free_result($Dato); // Libera los recursos de la consulta
								}
							}

							// Utiliza la misma variable $NroProg en el segundo INSERT
							if ($TFORMValue != NULL and $CAPAC != NULL) {
// Ahora puedes usar $horaInicioFormatted y $horaFinalFormatted en tu consulta SQL
$QryPrg2 = "INSERT INTO PLATCAPACITACIONES.dbo.CabeceraCap (NROPROG, FECHA, HINICIO, HFINAL, LUGAR, DESCRIPCION, USUARIO, FECACT)
            VALUES ('$NroProg', '$fechaFormateada', '$horaInicioFormatted', '$horaFinalFormatted', '$LUGAR', '$DESCRIP', '$usu', GETDATE())";
								$Dato2 = odbc_exec($conexion, $QryPrg2);
								$NroProg++;
								if ($Dato2) {
									odbc_free_result($Dato2); // Libera los recursos de la consulta
									?>
												<script languaje="javascript">
													window.location = "../view/upinformacion.php";
													alert("¡Se cargo con exito la programación!");
												</script>
									<?php
								}
							}
						}


						?><script languaje="javascript">
							window.location = "../view/upinformacion.php";
							alert("¡Se cargo con exito la programación!");
						</script><?php
								} else {
									?><script languaje="javascript">
							window.location = "../view/upinformacion.php";
							alert("¡Hubo un error!");
						</script><?php
								}
							} else {
									?><script languaje="javascript">
						window.location = "../view/upinformacion.php";
						alert("¡Hubo un error!");
					</script><?php
							}
						} else {
								?><script languaje="javascript">
					window.location = "../view/upinformacion.php";
					alert("¡Por favor, suba un archivo valido (Excel)!");
				</script><?php
						}
					} // Cierre de las validaciones 0	
				}
			} else {
							?>
	<script languaje "JavaScript">
		alert("Acceso Incorrecto");
		window.location.href = "../login.php";
	</script>
<?php
			} // Cierre de Validacion de Inicio de sesion	
