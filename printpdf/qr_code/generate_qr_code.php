<?php
//============================================================+
// File name   : example_027.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 027 for TCPDF class
//               1D Barcodes
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
 * @abstract TCPDF - Example: 1D Barcodes.
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 027');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 027', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

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

// set a barcode on the page footer
//$pdf->setBarcode(date('Y-m-d H:i:s'));

// set font
$pdf->SetFont('helvetica', '', 11);
// define barcode style Working
// $style = array(
//     'stretch' => true,
//     'text' => false,
//     'font' => 'helvetica',
//     'fontsize' => 8,
//     'stretchtext' => 3
// );

// add a page
//QR COde Style
$style = array(
   
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 2.5, // width of a single module in points
    'module_height' => 2.5 // height of a single module in points
);

//write1DBarcode( $code,  $type,  $x = '',  $y = '',  $w = '',  $h = '',  $xres = '',  $style = array(),  $align = '' )


// Orginal $pdf->AddPage('L', array(80,25));,  $pdf->write1DBarcode('iCF20221012123526', 'C93', '30', '5', '30', 15, '', $style, 'M')

// Working Example
// $pdf->AddPage('L', array(80,25));
// $pdf->SetFont('helvetica', '', 5);
// $pdf->write1DBarcode('iCF2-2810202212221801', 'C128', '70', '5', '30', 15, '', $style, 'M');
// $pdf->write1DBarcode('iCF2022', 'C128', '30', '5', '30', 15, '', $style, 'M');




// Tesxting With New Option 
$pdf->SetFont('helvetica', '', 6);

for($i=0;$i<=5;$i++)
{
    $pdf->AddPage('L', array(80,28));
    $pdf->write2DBarcode('iCF2-281020221222180'.$i, 'QRCODE,L', 10, 3.8,2,2,  $style, 'N');
    $pdf->write2DBarcode('iCF2-281020221222180'.($i+1), 'QRCODE,L', 50, 3.8,2,2,  $style, 'N');
    
    $pdf->Text(5.5,0.3, 'iCF2-281020221222180'.$i);
    $pdf->Text(46.5,0.3, 'iCF2-281020221222180'.($i+1));
}
//   $this->SetXY(0, 5);
//         $this->Cell(0, 0, 'TCPDF and FPDI');

// QRCODE,M : QR-CODE Medium error correction
// $pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,M', 70, 5, 30, 15, $style, 'N');
// $pdf->Text(20, 85, 'QRCODE M');



// $style['cellfitalign'] = 'C';
// $pk= 10;
// foreach ($pages as $pk => $p) {
//     // add a page
//     $pdf->AddPage();
//     foreach ($p as $lk => $l) {
//         foreach ($l as $ck => $c) {
//             //Get current write position.
//             $x = $pdf->GetX();
//             $y = $pdf->GetY();
//             // The width is set to the the same as the cell containing the name.  
//             // The Y position is also adjusted slightly.
//             $pdf->write1DBarcode('iCF200150225025', 'C128B', '', $y-8.5, 105, 18, 0.4, $style, 'M');
//             //Reset X,Y so wrapping cell wraps around the barcode's cell.
//             $pdf->SetXY($x,$y);
//             $pdf->Cell(105, 51, 'Glass', 1, 0, 'C', FALSE, '', 0, FALSE, 'C', 'B');
//         }
//         $pdf->Ln();
//     }
// }


// Below Look Nice But Not printing

// $pdf->AddPage('P', array(80,297));
// // print a message
// $ypos = 5;
// for($i=0;$i<=10;$i++){

//  $pdf->write1DBarcode('iCF2022101212352'.$i, 'C93', '5', $ypos, '30', 15, '', $style, 'M');
//  $pdf->write1DBarcode('iCF2022101212352'.$i, 'C93', '45', $ypos, '30', 15, '', $style, 'M');
//  $ypos = $ypos + 20;
//   $pdf->write1DBarcode('iCF2022101212352'.$i, 'C93', '5', $ypos, '30', 15, '', $style, 'M');
//  $pdf->write1DBarcode('iCF2022101212352'.$i, 'C93', '45', $ypos, '30', 15, '', $style, 'M');
//  $ypos = $ypos + 20;
//  $pdf->Ln();
// }


//Close and output PDF document
$pdf->Output('example_027.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
