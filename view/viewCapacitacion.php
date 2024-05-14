<?php
header('Content-Type: text/html; charset=UTF-8');
include_once("../pdf/fpdf/fpdf.php");
require '../Funciones/funcionalidades.php';
$Func = new Funciones;
date_default_timezone_set('America/Bogota');
$NROPROG = $_GET['NROPROG'];

if (isset($_GET['codempleado'])){
    $CODEMPLEADO = $_GET['codempleado'];
} else {
    $CODEMPLEADO = NULL;
}

$pdf = new fpdf('P','mm','Letter'); 

$pdf -> SetMargins(4,10,0);
$pdf ->AddPage();

// $pdf->SetMargins(60, 60 , 30); 
// $pdf ->Image('imagenes/logo.png',140,15,51,'R'); 
// $pdf->Image('imagenes/logofondo.png',5,55,200);
//Maximo 200
$pdf ->SetFont ('Arial', 'B', 16); 
$pdf->SetFontSize(12);
$pdf->SetTextColor(9, 198, 32);
$pdf->Cell(208,20,'REGISTRO DE EVALUACION DE LA FORMACION', 1, 1,'C',0);
$pdf ->SetFontSize(10);

$pdf->Ln(0);
$pdf->SetTextColor(33,33,33);
$pdf->Cell(73,10,'Tipo de actividad', 1, 0,'L',0);
$pdf->Cell(135,10, odbc_result($Func->CabCap($NROPROG), 'CAPACITACION'), 1, 1,'L',0);
$pdf->Cell(52,10,'Fecha :' .substr(odbc_result($Func->CabCap($NROPROG), 'FECHA'), 0), 1, 0,'L',0);
$pdf->Cell(52,10,'Hr. Inicio: '.substr(odbc_result($Func->CabCap($NROPROG), 'HINICIO'), 0 , 5), 1, 0,'L',0);
$pdf->Cell(52,10,'Hr. Final :'.substr(odbc_result($Func->CabCap($NROPROG), 'HFINAL'), 0 , 5), 1, 0,'L',0);
$pdf->Cell(52,10,'Duracion: ' .substr(number_format(round(odbc_result($Func->CabCap($NROPROG), 'DURACION'), 2), 2), 0). " Horas", 1, 1,'L',0);

$pdf->Ln(0);

$pdf->Cell(104,10,'Lugar: '.substr(utf8_decode(odbc_result($Func->CabCap($NROPROG), 'LUGAR')), 0), 1, 0,'L',0);
$pdf->SetTextColor(5, 137, 241 );
$pdf->Cell(52,10,'Ver bitacora', 1, 0,'L',0,utf8_decode(odbc_result($Func->CabCap($NROPROG), 'Bitacora')));
$pdf->SetTextColor(33, 33, 33);
$pdf->Cell(52,10,'Valor: '.number_format(odbc_result($Func->CabCap($NROPROG), 'PRECIO'), 1), 1, 1,'L',0);

$pdf->Ln(0);
$pdf->Cell(65,10,'Tema de formacion: ' .odbc_result($Func->CabCap($NROPROG), 'TFORM'), 1, 0,'L',0);
$pdf->Cell(65,10,'Tipo Capacitacion: ' .odbc_result($Func->CabCap($NROPROG), 'CATEGORIA'), 1, 0,'L',0);
$pdf->Cell(78,10,'Tema: ' .odbc_result($Func->CabCap($NROPROG), 'SUBTIPO'), 1, 1,'L',0);
$pdf->Ln(0);

$pdf->Cell(104,10,'Responsable: ' .odbc_result($Func->CabCap($NROPROG), 'Capacit'), 1, 0,'L',0);
$pdf->Cell(104,10,'Nota Capacitador: ' .odbc_result($Func->CabCap($NROPROG), 'NOTA'), 1, 1,'L',0);

$pdf->Ln(0);

$pdf->MultiCell(208,20,'DESCRIPCION: '.utf8_decode(odbc_result($Func->CabCap($NROPROG), 'DESCRIPCION')), 1,'L', false);

$pdf ->SetFontSize(8);
$pdf->SetTextColor(9, 198, 32);
$pdf->Cell(22,5,'CC', 1, 0,'C',0);
$pdf->Cell(45,5,'NOMBRE', 1, 0,'C',0);
$pdf->Cell(67,5,'CARGO', 1, 0,'C',0);
$pdf->Cell(10,5,'SEXO', 1, 0,'C',0);
$pdf->Cell(10,5,'NOTA', 1, 0,'C',0);
$pdf->Cell(54,5,'OBSERVACIONES', 1, 1,'C',0);

$pdf ->SetFontSize(8);
$pdf->SetTextColor(33, 33, 33);
// Colores
$R;
$G;
$B;

$NotaAprueba = 0;

foreach ($Func->PartiCapac($NROPROG, $CODEMPLEADO) as $a) {

    $pdf->Cell(22, 7, $a['CEDULA'],1, 0, 'L');
    $pdf->Cell(45, 7, substr($a['NOMBRE'],0 , 30),1, 0, 'L');
    $pdf->Cell(67, 7, $a['CARGO'],1, 0, 'L');
    $pdf->Cell(10, 7, $a['SEXO'],1, 0, 'L');

    if($a['APRUEBA'] < 35.00) {
        $R = 255;
        $G = 0;
        $B = 0;
    } else {
        $R = 19;
        $G = 164;
        $B = 47;
    }
    
    $pdf->SetTextColor($R,$G,$B);
    $pdf->Cell(10, 7, $a['APRUEBA'] !== null ? $a['APRUEBA'] : '0.0',1, 0, 'L');
    
    $pdf->SetTextColor(33, 33, 33);
    $pdf->Cell(54, 7, $a['Observaciones'],1, 1, 'L');
    $pdf->Ln(0);

    $NotaAprueba = $NotaAprueba + $a['APRUEBA'];
}

$PromPart = $NotaAprueba / count($Func->PartiCapac($NROPROG, $CODEMPLEADO));
$pdf ->SetFontSize(10);
$pdf->Cell(144,10,'Promedio: ', 1, 0,'C',0);
$pdf->Cell(10,10, number_format(round($PromPart, 1), 1), 1, 0,'C',0);
$pdf->Cell(54,10,'', 1, 1,'L',0);

$pdf -> Output();