<?php
include 'plantilla_solicitud.php';
require 'conexion.php';
$resultado1 = mysqli_query($conexion,"SELECT MAX(Id_solicitud) AS 'hola' FROM orden_solicitud");
		if (!$resultado1) {
    	echo 'No se pudo ejecutar la consulta: '.mysqli_error();
    	exit;
    	}
		$fila = mysqli_fetch_row($resultado1);
$consulta_mysql1="SELECT material.Nombre_material, material.Marca, material.Unidad_medida, material.Tipo_con_pres, solicitudes.Cantidad_solicitada, solicitudes.Item_solicitud FROM solicitudes
INNER JOIN material ON solicitudes.Id_material = material.Id_material WHERE `Id_solicitud` = '$fila[0]'";
		$ordenar=mysqli_query($conexion,"SELECT * FROM solicitudes ORDER BY solicitudes.Item_solicitud ASC");
$pdf=new PDF();
$pdf->AliasNbPages();
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

$pdf->SetFontSize(9);
$resorden1 = mysqli_query($conexion,$consulta_mysql1);
while ($row = $resorden1->fetch_assoc()){
$pdf->Cell(11,6,$row['Item_solicitud'],1,0,'C',0);
$pdf->Cell(70,6,$row['Nombre_material'],1,0,'C',0);
$pdf->Cell(30,6,$row['Marca'],1,0,'C',0);
$pdf->Cell(20,6,$row['Unidad_medida'],1,0,'C',0);
$pdf->Cell(25,6,$row['Cantidad_solicitada'],1,0,'C',0);
$pdf->Cell(34,6,$row['Tipo_con_pres'],1,1,'C',0);
}
$consulta_mysql2="SELECT * FROM orden_solicitud WHERE `Id_solicitud` = '$fila[0]'";
$resorden2 = mysqli_query($conexion,$consulta_mysql2);
while ($hola = $resorden2->fetch_assoc()){
$pdf->Cell(70,6,'Observaciones:',0,2,'L',0);
$pdf->Cell(190,20,$hola['Observaciones_sol'],1,0,'C',0);
}
$consulta_firma="SELECT usuario.Name
		FROM (orden_solicitud
		INNER JOIN usuario ON orden_solicitud.Id_usuario = usuario.Id_usuario)
		WHERE `Id_solicitud` = '$fila[0]'";
$firma = mysqli_query($conexion,$consulta_firma);
while ($firmar = $firma->fetch_assoc()){
$pdf->Ln(35);
$pdf->SetX(70);
$pdf->Cell(70,6,'FIRMA DE QUIEN AUTORIZA','T',2,'C',0);
$pdf->Cell(70,6,$firmar['Name'],'',2,'C',0);
}
$pdf->Output();

 ?>