<?php 

require 'conexion.php';
require('fpdf/fpdf.php'); 
require_once '../PHPExcel/Classes/PHPExcel.php';

 
$Cedula=$_POST['Cedula'];
$anio=$_POST['anio'];

$PrimeraInfo="SELECT rc.Ruta FROM rutacerficados rc WHERE rc.Anio = '$anio'";
$dos=$conexion->query($PrimeraInfo);
$tres=mysqli_fetch_assoc($dos);
$Ruta=$tres['Ruta']; 

$archivo = "../".$Ruta;

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn(); 

for ($row = 2; $row <= $highestRow; $row++){

  if ($Cedula == $sheet->getCell("A".$row)->getValue()) {

    $Nombre = $sheet->getCell("B".$row)->getValue();
    $Fecha_ingrreso = $sheet->getCell("C".$row)->getValue();
    $Fecha_retiro = $sheet->getCell("I".$row)->getValue();
    $Cargo = $sheet->getCell("D".$row)->getValue(); 
    $Salario = $sheet->getCell("F".$row)->getValue(); 
    $Tipo_contrato = $sheet->getCell("H".$row)->getValue();
    $Fecha_retiro = $sheet->getCell("I".$row)->getValue();

  }

}
 
   
  if ($Fecha_retiro == NULL) { 
    $texto= 'Que el(a) señor(a) '.$Nombre.', identificado con cedula de ciudadania No. '.number_format($Cedula, 0).', labora en nuestra compañia desempeñandose como '.$Cargo.', desde el '.$Fecha_ingrreso.', bajo un contrato por '.$Tipo_contrato.', actualmente con un salario de $'.number_format($Salario, 0);
  }else{ 
  	$texto='Que el(a) señor(a) '.$Nombre.', identificado con cedula de ciudadania No. '.number_format($Cedula, 0).', laboro en nuestra compañia desempeñandose como '.$Cargo.', desde el '.$Fecha_ingrreso.' hasta el '.$Fecha_retiro.', bajo un contrato por '.$Tipo_contrato.'.';
  }

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
 
$pdf = new fpdf('P','mm','Letter'); 
$pdf ->AddPage();
$pdf->SetMargins(60, 60 , 30); 
$pdf ->Image('imagenes/logo.png',140,15,51,'R'); 
$pdf->Image('imagenes/logofondo.png',5,55,200);
$pdf ->SetFont ('Arial', 'B', 16);
$pdf->SetXY(30, 40);
$pdf ->Cell(0, 10, 'FIBERNET TELECOMUNICACIONES S.A.S', 0, 1, 'C'); ;
$pdf->SetXY(30, 50);
$pdf ->Cell(0, 10, 'NIT 830.053.209-0', 0, 1, 'C'); ; 
$pdf ->SetFont ('Arial', 'B', 14);
$pdf->SetXY(30, 85);
$pdf ->Cell(0, 10, 'CERTIFICA', 0, 1, 'C'); ;
$pdf ->SetFont ('Arial', '', 12);
$pdf->SetXY(30, 110);
$pdf ->MultiCell(0, 7, utf8_decode($texto), 0, 'J', 0);

$pdf->SetXY(30, 150);
$pdf ->MultiCell(0, 7, 'La presente se expide a solicitud del interesado, a los '.date("d").' dias del mes de '.$meses[date("n")-1].' del '.date("Y").'.', 0, 'J', 0);
$pdf->SetXY(30, 170);
$pdf ->MultiCell(0, 7, 'Atentamente, ',0, 'J', 0);
$pdf ->Image('imagenes/Firma.png',35,188,50,'L'); 
$pdf ->SetFont ('Arial', 'I', 12);
$pdf->SetXY(30, 200);
$pdf ->Cell(0, 0, '________________________________', 0, 1, 'L');
$pdf->SetXY(30, 205);
$pdf ->Cell(0, 0, 'Ing. Lady Mora Ceron', 0, 0, 'L'); 
$pdf->SetXY(30, 210);
$pdf ->Cell(0, 0, 'Coordinadora Administrativa', 0, 0, 'L'); 
$pdf ->SetFont ('Arial', 'I', 9);
$pdf->SetXY(30, 250);
$pdf ->Cell(0, 0, 'Calle 116 No. 71D - 05 Bogota D.C. Colombia PBX: +57 (1) 6130060 Fax: 253 6364', 0, 0, 'C');  
$pdf->SetXY(30, 251);
$pdf ->Cell(0, 0, '______________________________________________________________________________________', 0, 0, 'L'); 
$pdf->SetXY(30, 256);
$pdf ->Cell(0, 0, 'NIT.: 830.053.209-0 E-mail: administracion@fibernet.com.co - https://fibernetsa.co/', 0, 1, 'C'); 

 

$pdf -> Output();
 
?>
