<?php

    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('America/Bogota');
    require '../Funciones/funcionalidades.php';
    $Func = new Funciones;

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $x=4;
    $DateInformacion = date("Y-m-d H:i:s");
    $Informacion = $Func->generarExcelProgramaciones($fecha1, $fecha2);


	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');
 
	require_once '../PHPExcel/Classes/PHPExcel.php'; 
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("IKIGAI")
		->setLastModifiedBy("IKIGAI")
		->setTitle("Reporte por fechas")
		->setSubject("Reportes")
		->setDescription("Descripcion.")
		->setKeywords("Mensual")
		->setCategory("Reportes");

    $objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Reporte generado desde la plataforma IKIGAI') 
		->setCellValue('A2', 'Hora: '.$DateInformacion.' desde el '.$fecha1.' hasta el '.$fecha2);


    $objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A3', 'Programacion') 
		->setCellValue('B3', 'Fecha')
		->setCellValue('C3', 'Personas Programadas')
		->setCellValue('D3', 'Personas Asistentes')
		->setCellValue('E3', 'Nombre') 
		->setCellValue('F3', 'Año')
		->setCellValue('G3', 'Mes')
		->setCellValue('H3', 'Categoria')
		->setCellValue('I3', 'Subtipo')
		->setCellValue('J3', 'Lugar')
		->setCellValue('K3', 'Fecha Evento')
		->setCellValue('L3', 'Descripción')
		->setCellValue('M3', 'Tipo formación')
		->setCellValue('N3', 'Cumplimiento Legal')
		->setCellValue('O3', 'Capacitador')
		->setCellValue('P3', 'Hora Inicio')
		->setCellValue('Q3', 'Hora Final')
		->setCellValue('R3', 'Duración (Mns)')
		->setCellValue('S3', 'Personal Femenino')
		->setCellValue('T3', 'Personal Masculino')
		->setCellValue('U3', 'Cedula')
		->setCellValue('V3', 'Nota')
		->setCellValue('W3', 'Colaborador') 
		->setCellValue('X3', 'Genero');      
 
    foreach ($Informacion as $vw) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$x, $vw['NROPROG'])
            ->setCellValue('B'.$x, $vw['FECHA'])
            ->setCellValue('C'.$x, $vw['CANTIDADPROG'])
            ->setCellValue('D'.$x, $vw['CANTIDADASIS'])
            ->setCellValue('E'.$x, $vw['CAPACITACION'])
            ->setCellValue('F'.$x, $vw['ANIO'])
            ->setCellValue('G'.$x, $vw['MES'])
            ->setCellValue('H'.$x, $vw['CATEGORIA'])
            ->setCellValue('I'.$x, $vw['SUBTIPO'])
            ->setCellValue('J'.$x, $vw['LUGAR'])
            ->setCellValue('K'.$x, $vw['FECHAEVENT'])
            ->setCellValue('L'.$x, $vw['DESCRIPCION'])
            ->setCellValue('M'.$x, $vw['TFORM'])
            ->setCellValue('N'.$x, $vw['Cumpleg'])
            ->setCellValue('O'.$x, $vw['CAPACITADORNOM'])
            ->setCellValue('P'.$x, $vw['HINICIO'])
            ->setCellValue('Q'.$x, $vw['HFINAL'])
            ->setCellValue('R'.$x, $vw['DURACION'])
            ->setCellValue('S'.$x, $vw['FEMENINO'])
            ->setCellValue('T'.$x, $vw['MASCULINO'])
            ->setCellValue('U'.$x, $vw['CEDULA'])
            ->setCellValue('V'.$x, $vw['APRUEBA'])
            ->setCellValue('W'.$x, $vw['NOMBRE_COMPLETO'])
            ->setCellValue('X'.$x, $vw['SEXO']);

        $x++;

    }

    


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="IKIGAI.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;


 