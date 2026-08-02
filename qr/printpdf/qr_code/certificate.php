<?php
//============================================================+
// File name   : example_062.php
// Begin       : 2010-08-25
// Last Update : 2013-05-14
//
// Description : Example 062 for TCPDF class
//               XObject Template
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XObject Template
 * @author Nicola Asuni
 * @since 2010-08-25
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Evitta Rose');
$pdf->SetTitle('MAT Certificate');
$pdf->SetSubject('SaNDS Lab');
$pdf->SetKeywords('Certificate, Evitta Rose, MAT');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 062', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage('L', 'A4');

//$pdf->Write(0, 'XObject Templates', '', 0, 'C', 1, 0, false, false, 0);

$pdf->Image('images/MAT-Level-4-Certificate-of-Completion.jpg', 0, 0, 0, 0, '', '', '', true, 300, '', false, false, 0, false, false, false);

//$pdf->Cell(70, 130, 'Ebine Rose Alappat', 0, 20, 'L');
$pdf->Cell(0, 130, 'Ebine Rose Alappat', 0, 0, 'C', 0, '', 0);
$pdf->Ln(90);
$pdf->SetFont('helvetica', 'B', 10);
$html = '<dl>
    
    <dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12/05/2022</dd>
   
</dl>';

// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);
//$pdf->Write(0, '12-12-2022', '', 0, '', true, 0, false, false, 0);

//Close and output PDF document
$pdf->Output('example_062.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
