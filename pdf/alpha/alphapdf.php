<?php
require('../fpdf/fpdf.php');

class AlphaPDF extends FPDF
{
	function Header()
	{
$this->SetFont('Arial','B',12);
		$this->Image('../imagenes/logo.png',13,11,40);
		$this->Cell(45, 10,'', 1, 0,'C');
		$this->Cell(95, 10,'FORMATO DE SOLICITUD DE MATERIAL', 1, 0,'C');
		$this->Cell(50, 5,'Version 2', 1, 2,'C');
		$this->Cell(50, 5,'FV: 01/08/2018', 1, 1,'C');
		$this->Cell(50, 10,'Nombre del Proyecto', 1, 0,'C',0);
		
}



	var $extgstates = array();

	// alpha: real value from 0 (transparent) to 1 (opaque)
	// bm:    blend mode, one of the following:
	//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
	//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
	function SetAlpha($alpha, $bm='Normal')
	{
		// set alpha for stroking (CA) and non-stroking (ca) operations
		$gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
		$this->SetExtGState($gs);
	}

	function AddExtGState($parms)
	{
		$n = count($this->extgstates)+1;
		$this->extgstates[$n]['parms'] = $parms;
		return $n;
	}

	function SetExtGState($gs)
	{
		$this->_out(sprintf('/GS%d gs', $gs));
	}

	function _enddoc()
	{
		if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
			$this->PDFVersion='1.4';
		parent::_enddoc();
	}

	function _putextgstates()
	{
		for ($i = 1; $i <= count($this->extgstates); $i++)
		{
			$this->_newobj();
			$this->extgstates[$i]['n'] = $this->n;
			$this->_out('<</Type /ExtGState');
			$parms = $this->extgstates[$i]['parms'];
			$this->_out(sprintf('/ca %.3F', $parms['ca']));
			$this->_out(sprintf('/CA %.3F', $parms['CA']));
			$this->_out('/BM '.$parms['BM']);
			$this->_out('>>');
			$this->_out('endobj');
		}
	}

	function _putresourcedict()
	{
		parent::_putresourcedict();
		$this->_out('/ExtGState <<');
		foreach($this->extgstates as $k=>$extgstate)
			$this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
		$this->_out('>>');
	}

	function _putresources()
	{
		$this->_putextgstates();
		parent::_putresources();
	}
}
?>
