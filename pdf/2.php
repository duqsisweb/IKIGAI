<?php
require 'fpdf/fpdf.php';
class AlphaPDF extends FPDF
{
	function Header()
	{
		$id_solici = $_POST["o_copia"];
		require 'conexion.php';
		$consulta_mysql="SELECT orden_solicitud.Id_solicitud, orden_solicitud.Fecha_Solicitud ,orden_solicitud.Hora_solicitud, orden_solicitud.Observaciones_sol, usuario.Name, cliente.Nombre, responsable.Nombres, responsable.Apellidos, orden_trabajo.Nombre_ot, orden_trabajo.Direccion_ot
		FROM orden_solicitud
		INNER JOIN cliente ON orden_solicitud.Id_cliente = cliente.Id_cliente
		INNER JOIN usuario ON orden_solicitud.Id_usuario = usuario.Id_usuario
		INNER JOIN responsable ON orden_solicitud.Id_respon = responsable.Id_respon
		INNER JOIN orden_trabajo ON orden_solicitud.Id_ot = orden_trabajo.Id_ot
		WHERE `Id_solicitud` = '$id_solici'";
		$resorden = mysqli_query($conexion,$consulta_mysql);
		while ($row1 = $resorden->fetch_assoc()) {
		$this->SetFont('Arial','B',12);
		$this->Image('imagenes/logo.png',13,11,40);
		$this->Cell(45, 10,'', 1, 0,'C');
		$this->Cell(95, 10,'FORMATO DE SOLICITUD DE MATERIAL', 1, 0,'C');
		$this->Cell(50, 5,'Version 2', 1, 2,'C');
		$this->Cell(50, 5,'FV: 01/08/2018', 1, 1,'C');
		$this->Cell(50, 10,'Nombre del Proyecto', 1, 0,'C',0);
		$this->Setfont('Arial','I',12);
		$this->Cell(65, 10,$row1['Nombre'], 1, 0,'C',0);
		$this->SetFont('Arial','B',12);
		$this->Cell(35, 10,'Consecutivo', 1, 0,'C',0);
		$this->Setfont('Arial','I',12);
		$this->Cell(40, 10,$row1['Id_solicitud'], 1, 1,'C',0);
		$this->SetFont('Arial','B',12);
		$this->Cell(25, 10,'Predio / OT', 1, 0,'C',0);
		$this->Setfont('Arial','I',12);
		$this->Cell(65, 10,$row1['Nombre_ot'], 1, 0,'C',0);
		$this->SetFont('Arial','B',12);
		$this->Cell(35, 10,'Quien Autoriza', 1, 0,'C',0);
		$this->Setfont('Arial','I',12);
		$this->Cell(65, 10,$row1['Name'], 1, 1,'C',0);
		$this->SetFont('Arial','B',11.5);
		$this->Cell(15, 10,'Fecha', 1, 0,'C',0);
		$this->Setfont('Arial','I',12);
		$this->Cell(25, 10,$row1['Fecha_Solicitud'], 1, 0,'C',0);
		$this->SetFont('Arial','B',12);
		$this->Cell(15, 10,'Hora', 1, 0,'C',0);
		$this->Setfont('Arial','I',12);
		$this->Cell(25, 10,$row1['Hora_solicitud'], 1, 0,'C');
		$this->SetFont('Arial','B',12);
		$this->Cell(35, 10,'Quien Recibe', 1, 0,'C');
		$this->Setfont('Arial','I',12);
		$this->Cell(75, 10,$row1['Nombres'].' '.$row1['Apellidos'], 1,0,'C');
		}
		$this->Ln(10);
}

	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,'Realizado por',0,1,'C');
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
?>