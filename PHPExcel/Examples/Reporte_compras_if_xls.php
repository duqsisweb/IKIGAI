<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');
require 'conexion.php';
$consulta_mysql1="SELECT compras.Id_factura, material.Nombre_material, compras.Cantidad_entrada, compras.Costo_compra, compras.Fecha_compra, cliente.Nombre
FROM compras
INNER JOIN material ON compras.Id_material = material.Id_material
INNER JOIN cliente ON compras.Id_cliente = cliente.Id_cliente";
$ordenar=mysqli_query($conexion,"SELECT * FROM compras ORDER BY Fecha_compra ASC");
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
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
// Set document properties
$objPHPExcel->getProperties()->setCreator("Fibernet TeLecomunicaciones S.A.")
							 ->setLastModifiedBy("Area Contabilidad")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Historial de Compras")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Historial Compras");


// Add some data
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./images/logo.png');
$objDrawing->setHeight(40);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Item')
            ->setCellValue('B3', 'Material')
            ->setCellValue('C3', 'Ultima Compra')
            ->setCellValue('D3', 'Valor Ultima Compra')
            ->setCellValue('E3', 'Fecha Compra')
            ->setCellValue('F3', 'Cantidad')
            ->setCellValue('G3', 'Valor Compra');

// Miscellaneous glyphs, UTF-8
$resorden1 = mysqli_query($conexion,$consulta_mysql1);
$x=4;
while ($row = $resorden1->fetch_assoc()){
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$x, $row['Id_factura'])
            ->setCellValue('B'.$x, $row['Nombre_material'])
            ->setCellValue('C'.$x, $row['Fecha_compra'])
            ->setCellValue('D'.$x, $row['Costo_compra'])
            ->setCellValue('E'.$x, $row['Fecha_compra'])
            ->setCellValue('F'.$x, $row['Cantidad_entrada'])
            ->setCellValue('G'.$x, $row['Costo_compra']);
$x++;
}
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
