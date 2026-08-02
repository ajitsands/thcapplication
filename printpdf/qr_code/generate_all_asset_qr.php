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
 ob_start(); // Start output buffering

include("../../model/db_connection/connection.php");
$db_connection =  new DBConnection();
$conn_obj = $db_connection->ConnectToMYSQL();

$assetId = isset($_GET['assetids']) ? $_GET['assetids'] : null;

if ($assetId !== null) {
    // Convert the string to an array
    $data = explode(',', $assetId);

    // Assuming $data is an array of numeric values
    $str = implode(',', $data);
} else {
    echo "error";
    die; // Terminate script execution after displaying the error
}

$sql = "SELECT asset_ref_no FROM tbl_assets WHERE asset_id IN ($str)";

$result = $conn_obj->query($sql);
$asset_ref_no = array(); // Initialize as an empty array

if ($result === false) {
    echo "Database error: " . $conn_obj->error;
    die;
}

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $asset_ref_no[] = $row["asset_ref_no"];
    }
} else {
    echo "0 results";
    die; // Terminate script execution after displaying the error
}

$conn_obj->close();
ob_end_clean(); //





// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SaNDS Lab');
$pdf->SetTitle('THC-FM');
$pdf->SetSubject('QR Code Printing');
$pdf->SetKeywords('QR Code Printing THC_FM');

// set default header data

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE,0);
//$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// Set image file
$imageFile = 'img.png';
$img_file = K_PATH_IMAGES.$imageFile;
// Set x, y, width, and height parameters for the image
$x = 10;
$y = 10;
$width = 40;  // Width of the image in millimeters
$height = 0;   // Height is automatically calculated to maintain the aspect ratio

// Add image to the page
$pdf->Image($img_file, $x, $y, $width);

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
$pdf->setJPEGQuality(300);

// Tesxting With New Option 
$pdf->SetFont('helvetica', '', 6);

$k = count($asset_ref_no); // Use count() instead of $result->num_rows
$ctr = 0; // Initialize $ctr to 0

for ($i = 1; $i <= $k; $i++) {
    $pdf->AddPage('L', array(50, 25));
    
    $x = 21;
    $y = 7;
    $width = 25; 
    $height = 0;
    
    $img_file = K_PATH_IMAGES.'logo_print.png';
    $pdf->Image($img_file, $x, $y, $width);
    
    $pdf->write2DBarcode($asset_ref_no[$ctr], 'QRCODE,L', 4.5, 3.5,20,20,  $style, 'N');

    $pdf->Text(12.5,20, $asset_ref_no[$ctr]);
    

    $ctr++; // Increment $ctr after using its value
}

//Close and output PDF document
$pdf->Output('AssetQR.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
