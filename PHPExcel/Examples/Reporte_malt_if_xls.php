<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');
require 'conexion.php';
$consulta_mysql1="SELECT solmatcomp.Id_material, cliente.Nombre, orden_trabajo.Nombre_ot, solmatcomp.Nombre_material, solmatcomp.Tipo, solmatcomp.cantidad, usuario.Name, solmatcomp.fecha_solicitud, solmatcomp.Estado 
FROM solmatcomp 
INNER JOIN cliente ON cliente.Id_cliente = solmatcomp.Id_cliente 
INNER JOIN orden_trabajo ON orden_trabajo.Id_ot = solmatcomp.Id_ot 
INNER JOIN usuario ON usuario.Id_usuario = solmatcomp.Id_usuario
WHERE solmatcomp.Estado != 'Completado'";

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');


require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


 
$objPHPExcel = new PHPExcel();
$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 15,
        'name'  => 'Arial'
    ));
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('');
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);
 
$objPHPExcel->getProperties()->setCreator("Fibernet TeLecomunicaciones S.A.")
							 ->setLastModifiedBy("Almaacen")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Historial de Compras")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Solicitud de compra de material");


 
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./images/logo.png');
$objDrawing->setHeight(40);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Cod. Material')
            ->setCellValue('B3', 'Proyecto')
            ->setCellValue('C3', 'Nombre OT')
            ->setCellValue('D3', 'Nombre material')
            ->setCellValue('E3', 'Tipo')
            ->setCellValue('F3', 'Cantidad')
            ->setCellValue('G3', 'Usuario que solicita')
            ->setCellValue('H3', 'Fecha de Solicitud')
            ->setCellValue('I3', 'Estado');
            
 
$resorden1 = mysqli_query($conexion,$consulta_mysql1);
$x=4;
while ($row = $resorden1->fetch_assoc()){
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$x, $row['Id_material'])
            ->setCellValue('B'.$x, $row['Nombre'])
            ->setCellValue('C'.$x, $row['Nombre_ot'])
            ->setCellValue('D'.$x, $row['Nombre_material'])
            ->setCellValue('E'.$x, $row['Tipo'])
            ->setCellValue('F'.$x, $row['cantidad'])
            ->setCellValue('G'.$x, $row['Name'])
            ->setCellValue('H'.$x, $row['fecha_solicitud'])
            ->setCellValue('I'.$x, $row['Estado']);
        $x++;
}
 
$objPHPExcel->getActiveSheet()->setTitle('Simple');


 
$objPHPExcel->setActiveSheetIndex(0);


 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

 
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
