<?php
// Include the TCPDF setup file
require_once('tcpdf_include.php');

// Create a new TCPDF instance with landscape orientation and custom page size
$pdf = new TCPDF('L', 'mm', array(50, 25));

// Add a page
$pdf->AddPage();

// Set image file
$imageFile = 'img.png';
$img_file = K_PATH_IMAGES.$imageFile;

// Set x, y, width, and height parameters for the image
$x = 10;
$y = 10;
$width = 30;  // Width of the image in millimeters
$height = 0;   // Height is automatically calculated to maintain the aspect ratio

// Add image to the page
$pdf->Image($img_file, $x, $y, $width);

// Output the PDF to the browser or save it to a file
$pdf->Output('example.pdf', 'I');
