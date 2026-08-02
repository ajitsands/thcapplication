<?php
// Include TCPDF library
require_once('tcpdf_include.php');

// Create instance of TCPDF
$pdf = new TCPDF('L', 'mm', array(50, 25), true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Creator');
$pdf->SetAuthor('Your Author');
$pdf->SetTitle('Your Title');
$pdf->SetSubject('Your Subject');
$pdf->SetKeywords('Your Keywords');

// Set margins
$pdf->SetMargins(5, 5, 5);

// Add a page
$pdf->AddPage();

$style = array(
   
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 50.2, // width of a single module in points
    'module_height' => 50.2 // height of a single module in points
);



// Generate QR code
$qrData = 'Your QR Code Data';
$style = 'QRCODE,H';

$pdf->write2DBarcode($qrData, $style, 6, 6, 180, 180, $style, 'N');

// Output the PDF
$pdf->Output('label.pdf', 'I');
?>
