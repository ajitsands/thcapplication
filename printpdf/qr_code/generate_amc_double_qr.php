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
 include("../../model/db_connection/connection.php");
 $db_connection =  new DBConnection();
 $conn_obj = $db_connection->ConnectToMYSQL();
//  if($_GET['ctr']==0)
//  {
      $sql = "SELECT amc_ref_no FROM tbl_amc_master where amc_id=".$_GET['amc_id'];
//  }
//  else
//  {
//       $sql = "SELECT asset_ref_no FROM tbl_assets where asset_id=".$_GET['asset_id'];
//  }

$result = $conn_obj->query($sql);
$amc_ref_no[] = array();
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
     $amc_ref_no[] = $row["amc_ref_no"];
  }
} else {
  echo "0 results";
  die;
}
$conn_obj->close();

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SaNDS Lab');
$pdf->SetTitle('THC-FM');
$pdf->SetSubject('QR Code Printing');
$pdf->SetKeywords('QR Code Printing THC-FM');

// set default header data

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

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


// set font
$pdf->SetFont('helvetica', '', 11);

//QR COde Style
$style = array(
   
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 2.2, // width of a single module in points
    'module_height' => 2.2 // height of a single module in points
);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set JPEG quality
$pdf->setJPEGQuality(75);

// Tesxting With New Option 
$pdf->SetFont('helvetica', '', 6);
$k = $result->num_rows;
$k = round($k);
$ctr=1;
for($i=1;$i<=$k;$i++)
{
    $pdf->AddPage('L', array(80,28));
  
    $pdf->write2DBarcode($amc_ref_no[$ctr], 'QRCODE,L', 10, 3.2,2,2,  $style, 'N');
    $pdf->write2DBarcode($amc_ref_no[$ctr], 'QRCODE,L',  50, 3.2,2,2,  $style, 'N');
    //$pdf->write2DBarcode($part_number[$ctr+1], 'QRCODE,L', 50, 3.8,2,2,  $style, 'N');
    
    $pdf->Text(12.5,0.3, $amc_ref_no[$ctr]);
    $pdf->Text(52.5,0.3, $amc_ref_no[$ctr]);
   // $pdf->Text(46.5,0.3, $part_number[$ctr+1]);
   // $ctr = $ctr +2;
      $ctr = $ctr +1;
    // $pdf->Image('images/icarefone-logo.jpg', 32, 10, 20, 60, '', '', 'T', false, 150, '', false, false, 0, false, false, false);
    // $pdf->Image('images/icarefone-logo.jpg', 72, 10, 40, 80, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
}

//Close and output PDF document
$pdf->Output('AssetQR.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
