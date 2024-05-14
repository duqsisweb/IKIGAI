<?php
#include '../plantilla_solicitud_copia.php';
require '../conexion.php';
require('alphapdf.php');

$pdf = new AlphaPDF();
$pdf->AddPage();
$pdf->SetFillColor(232,232,232);
$pdf->Setfont('Arial','B',12);
$pdf->SetFontSize(9);
$pdf->MultiCell(11,12,'Item',1,'C',1);
$pdf->SetY(50);
$pdf->SetX(21);
$pdf->SetFontSize(12);
$pdf->Cell(70,12,'DESCRIPCION',1,0,'C',1);
$pdf->Cell(30,12,'MARCA',1,0,'C',1);
$pdf->Cell(20,12,'UNIDAD',1,0,'C',1);
$pdf->Cell(25,12,'CANTIDAD',1,0,'C',1);
$pdf->MultiCell(34,6,'CONSUMO O PRESTAMO',1,'C',1);
$pdf->SetLineWidth(1.5);

// set alpha to semi-transparency
$pdf->SetAlpha(0.4);
// draw jpeg image
$pdf->Image('../imagenes/138.png',10,100,190);


// restore full opacity
$pdf->SetAlpha(1);

$pdf->Output();
?>
