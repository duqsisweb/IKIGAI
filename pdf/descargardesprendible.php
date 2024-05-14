<?php 

require 'conexion.php';
require('fpdf/fpdf.php'); 
require_once '../PHPExcel/Classes/PHPExcel.php';

 
$Cedula=$_POST['Cedula'];
$anio=$_POST['anio'];
$mes=$_POST['mes'];

switch ($mes) {
  case '1': $NombreMes='ENERO'; $FinMes= '30'; break;
  case '2': $NombreMes='FEBRERO'; $FinMes= '28'; break;
  case '3': $NombreMes='MARZO'; $FinMes= '31'; break;
  case '4': $NombreMes='ABRIL'; $FinMes= '30'; break;
  case '5': $NombreMes='MAYO'; $FinMes= '31'; break;
  case '6': $NombreMes='JUNIO'; $FinMes= '30'; break;
  case '7': $NombreMes='JULIO'; $FinMes= '31'; break;
  case '8': $NombreMes='AGOSTO'; $FinMes= '31'; break;
  case '9': $NombreMes='SEPTIEMBRE'; $FinMes= '30'; break;
  case '10': $NombreMes='OCTUBRE'; $FinMes= '31'; break;
  case '11': $NombreMes='NOVIEMBRE'; $FinMes= '30'; break;
  case '12': $NombreMes='DICIEMBRE'; $FinMes= '31'; break;
  
}
$periodo=$_POST['periodo'];

if  ($periodo == 1)
  $ConPeriodo = 'DEL 01 DE '.$NombreMes.' DEL '.$anio.' AL 15 DE '.$NombreMes.' DEL '.$anio.'';
elseif ($periodo == 2)
  $ConPeriodo = 'DEL 16 DE '.$NombreMes.' DEL '.$anio.' AL '.$FinMes.' DE'.$NombreMes.' DEL '.$anio.'';
elseif ($periodo == 3)
  $ConPeriodo = 'DEL 01 DE '.$NombreMes.' DEL '.$anio.' AL '.$FinMes.' DE'.$NombreMes.' DEL '.$anio.'';


$PrimeraInfo="SELECT rc.rutanomina FROM rutadesprendibles rc WHERE rc.anio = $anio AND rc.mes = $mes AND  rc.periodo = $periodo";
$dos=$conexion->query($PrimeraInfo);
$tres=mysqli_fetch_assoc($dos);
$Ruta=$tres['rutanomina']; 

$archivo = "../".$Ruta;

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn(); 

for ($row = 2; $row <= $highestRow; $row++){

  if ($Cedula == $sheet->getCell("B".$row)->getValue()) {

    $NOMBRE = $sheet->getCell("C".$row)->getValue();
    $SUELDOBASICO = $sheet->getCell("N".$row)->getValue();
    $Fecha_retiro = $sheet->getCell("I".$row)->getValue();
    $Cargo = $sheet->getCell("F".$row)->getValue();   
    $DiasLaborados = $sheet->getCell("O".$row)->getValue();
    $SalarioBruto = $sheet->getCell("P".$row)->getValue();
    $SubcsidioTransporte = $sheet->getCell("AB".$row)->getValue();
    $DiasIncapacitados = $sheet->getCell("R".$row)->getValue();
    $Incapacidad = $sheet->getCell("X".$row)->getValue();
    $Validacion = ($DiasIncapacitados >= 1 ) ? $MensajeIncapacidad = $DiasIncapacitados : $MensajeIncapacidad = '-' ;
    $DiasACCLaborales = $sheet->getCell("S".$row)->getValue();
    $Validacion = ($DiasACCLaborales >= 1 ) ? $MensajeACC = $DiasACCLaborales : $MensajeACC = '-' ; 
    $AccidenteLaboral = $sheet->getCell("Y".$row)->getValue(); 
    $DiasVacaciones = $sheet->getCell("T".$row)->getValue();
    $Vacaciones = $sheet->getCell("Z".$row)->getValue();  
    $Validacion = ($DiasVacaciones >= 1 ) ? $MensajeVacaciones = $DiasVacaciones : $MensajeVacaciones = '-' ; 
    $LutoMaternidad = $sheet->getCell("U".$row)->getValue();
    $LutoLeyMaria = $sheet->getCell("AD".$row)->getValue();
    $Validacion = ($LutoMaternidad >= 1 ) ? $MensajeLuto = $LutoMaternidad : $MensajeLuto = '-' ; 
    $HorasExtras = $sheet->getCell("AE".$row)->getValue();
    $Validacion = ($HorasExtras >= 1 ) ? $ValidaHorasExtras = 'Si' : $ValidaHorasExtras = 'No';
    $OtrosIngresos = $sheet->getCell("AC".$row)->getValue();
    $Validacion = ($OtrosIngresos >= 1 ) ? $ValidaOtrosIngresos = 'Si' : $ValidaOtrosIngresos = 'No';
    $BAJUSTES = $sheet->getCell("AG".$row)->getValue();
    $Validacion = ($BAJUSTES >= 1 ) ? $ValidaBAJUSTES = 'Si' : $ValidaBAJUSTES = 'No';
    $DiasIncapacidadMesAnterior = $sheet->getCell("X".$row)->getValue();
    $DescuentoEquipos = $sheet->getCell("AJ".$row)->getValue();
    $DescuentoCelular = $sheet->getCell("AJ".$row)->getValue();
    $Libranzas = $sheet->getCell("AI".$row)->getValue();
    $DescuentoFunerario = $sheet->getCell("AK".$row)->getValue();
    $DescuentoMesAnterior = $sheet->getCell("AL".$row)->getValue();
    $Prestamos = $sheet->getCell("AH".$row)->getValue();
    $Salud = $sheet->getCell("AO".$row)->getValue();
    $Pension = $sheet->getCell("AP".$row)->getValue();
    $FondoSolidaridad = $sheet->getCell("AQ".$row)->getValue();
    $Retenciones = $sheet->getCell("AR".$row)->getValue();
    $Observaciones = $sheet->getCell("K".$row)->getValue();
    $Validacion = ($Observaciones != NULL ) ? $MenObservaciones = $Observaciones : $MenObservaciones = '-'; 


    $TotalDevengado = $SalarioBruto+$SubcsidioTransporte+$Incapacidad+$AccidenteLaboral+$DiasVacaciones+$LutoLeyMaria+$HorasExtras+$OtrosIngresos+$BAJUSTES;

    $TotalDeduccion = $DescuentoEquipos+$DescuentoCelular+$DescuentoFunerario+$DescuentoMesAnterior+$Prestamos+$Salud+$Pension+$Libranzas+$Retenciones;

    $TotalBruto = $TotalDevengado - $TotalDeduccion ; 
    

  }

} 


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
 
$pdf = new fpdf('L','mm','Letter'); 
$pdf->AddPage();
$pdf ->Image('imagenes/logo.png',208,15,51,'L'); 
$pdf->Image('imagenes/logofondo.png',40,30,200);
$pdf->SetMargins(20, 0, 20); 
$pdf ->SetFont ('Arial', 'B', 16);
$pdf->SetXY(20, 15);
$pdf ->Cell(0, 10, 'COMPROBANTE DE PAGO DE NOMINA', 0, 1, 'L'); ;
$pdf ->SetFont ('Arial', 'B', 12);
$pdf ->Cell(0, 0, 'PERIODO: '.$ConPeriodo, 0, 1, 'L'); ;  
$pdf ->Cell(0, 10, 'EMPLEADO: '.$NOMBRE, 0, 1, 'L'); ; 
$pdf ->Cell(0, 0, 'CARGO: '.$Cargo.'', 0, 1, 'L'); ; 
$pdf ->Cell(0, 10, 'C.C.: '.number_format($Cedula, 0), 0, 1, 'L'); ;  
$pdf ->Cell(0, 0, 'SUELDO BASICO: ', 0, 0, 'L');
$pdf ->Cell(-377, 0, '$'.number_format($SUELDOBASICO, 0), 0, 0, 'C');
$pdf ->Cell(-1, 10, 'MES: '.$NombreMes, 0, 1, 'C');

 

$pdf->SetY(55);
$pdf->SetX(21);
$pdf->SetFontSize(12);
$pdf->Cell(57,12,'DEVENGADO', 1, 0,'C',0);
$pdf->Cell(20,12,'DIAS', 1, 0,'C',0);
$pdf->Cell(30,12,'VALOR', 1, 0,'C',0);
$pdf->Cell(50,12,'DEDUCCIONES', 1, 0,'C',0); 
$pdf->Cell(20,12,'DIAS', 1, 0,'C',0); 
$pdf->Cell(30,12,'VALOR', 1, 0,'C',0);
$pdf->Cell(30,12,'SALDO', 1, 1,'C',0);

$pdf->SetY(67);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'DIAS LABORADOS', 1, 0,'L',0);
$pdf->Cell(20,8, $DiasLaborados, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($SalarioBruto, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'MATERIALES Y EQUIPOS', 1, 0,'L',0); 
$pdf->Cell(20,8, '', 1, 0,'L',0);  
$pdf->Cell(30,8, '$'.number_format($DescuentoEquipos, 0), 1, 0,'R',0);
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(75);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'AUXILIO DE TRANSPORTE', 1, 0,'L',0);
$pdf->Cell(20,8, $DiasLaborados, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($SubcsidioTransporte, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'CELULAR', 1, 0,'L',0); 
$pdf->Cell(20,8, '', 1, 0,'L',0); 
$pdf->Cell(30,8,'$'.number_format($DescuentoCelular, 0), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(83);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'INCAPACIDAD', 1, 0,'L',0);
$pdf->Cell(20,8, $MensajeIncapacidad, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($Incapacidad, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'SEGURO FUNERARIO', 1, 0,'L',0); 
$pdf->Cell(20,8, '', 1, 0,'L',0);
$pdf->Cell(30,8, '$'.number_format($DescuentoFunerario, 0), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(91);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'ACC LABORAL', 1, 0,'L',0);
$pdf->Cell(20,8, $MensajeACC, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($AccidenteLaboral, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'INCAPACIDAD MES ANT', 1, 0,'L',0); 
$pdf->Cell(20,8, $DiasIncapacidadMesAnterior, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($DescuentoMesAnterior, 0), 1, 0,'R',0);
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(99);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'VACACIONES', 1, 0,'L',0);
$pdf->Cell(20,8, $MensajeVacaciones, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($Vacaciones, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'PRESTAMOS PERSONALES', 1, 0,'L',0); 
$pdf->Cell(20,8,'', 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($Prestamos, 0), 1, 0,'R',0);
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(107);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'LUTO O MATERNIDAD', 1, 0,'L',0);
$pdf->Cell(20,8, $MensajeLuto, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($LutoLeyMaria), 1, 0,'R',0); 
$pdf->Cell(50,8,'SALUD', 1, 0,'L',0); 
$pdf->Cell(20,8, $DiasLaborados, 1, 0,'C',0); 
$pdf->Cell(30,8, '$'.number_format($Salud,0 ), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(115);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'HORAS EXTRAS', 1, 0,'L',0);
$pdf->Cell(20,8, $ValidaHorasExtras, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($HorasExtras,0 ), 1, 0,'R',0); 
$pdf->Cell(50,8,'PENSION', 1, 0,'L',0); 
$pdf->Cell(20,8, $DiasLaborados, 1, 0,'C',0); 
$pdf->Cell(30,8, '$'.number_format($Pension,0 ), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(123);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'NO SALARIALES', 1, 0,'L',0);
$pdf->Cell(20,8, $ValidaOtrosIngresos, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($OtrosIngresos, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'LIBRANZAS', 1, 0,'L',0); 
$pdf->Cell(20,8,'', 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($Libranzas, 0), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(131);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(57,8,'OTROS', 1, 0,'L',0);
$pdf->Cell(20,8, $ValidaBAJUSTES, 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($BAJUSTES, 0), 1, 0,'R',0); 
$pdf->Cell(50,8,'RETENCION SALARIAL', 1, 0,'L',0); 
$pdf->Cell(20,8,'', 1, 0,'C',0);
$pdf->Cell(30,8, '$'.number_format($Retenciones, 0), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(139);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(77,8,'TOTAL DEVENGADO', 1, 0,'L',0); 
$pdf->Cell(30,8, '$'.number_format($TotalDevengado, 0), 1, 0,'R',0); 
$pdf->Cell(70,8, 'TOTAL DEDUCCIONES SALARIAL', 1, 0,'L',0);  
$pdf->Cell(30,8, '$'.number_format($TotalDeduccion, 0), 1, 0,'R',0); 
$pdf->Cell(30,8,'', 1, 1,'C',0);

$pdf->SetY(147);
$pdf->SetX(21);
$pdf->SetFontSize(10);
$pdf->Cell(207,16, utf8_decode($MenObservaciones), 1, 0,'C',0);  
$pdf->Cell(30,16,'$'.number_format($TotalBruto, 0), 1, 1,'R',0); 



 

$pdf -> Output();
 
?>
