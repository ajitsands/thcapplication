<?php
$amc_ref_no = $_GET['amc_ref_no'];
$amc_id = $_GET['amc_id'];
$contract_type = $_GET['contract_type'];
$customer_code = $_GET['customer_code'];
$customer_name = $_GET['customer_name'];
$param = $amc_ref_no;
//$param = 'amc_ref_no='.$amc_ref_no.'&amc_id='.$amc_id.'&contract_type='.$contract_type.'&customer_code='.$customer_code.'&customer_name='.$customer_name;
$encryptedData = base64_encode($param);
// Dynamically build QR feedback URL based on server domain/protocol
$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$protocol = $is_https ? 'https://' : 'http://';
$server_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'portal.thcfm.com');
$subfolder = (stripos($_SERVER['REQUEST_URI'], '/thc/') !== false) ? '/thc' : '';
$encryptedURL = $protocol . $server_host . $subfolder . '/customer_feedback/?param=' . urlencode($encryptedData);

//============================================================+
// File name   : example_051.php 
// Begin       : 2009-04-16 
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
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
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES.'thc-customer-feedback-background.jpg';
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SaNDS Lab');
$pdf->SetTitle('THC Customer Feedback');
$pdf->SetSubject('Customer Feedback');
$pdf->SetKeywords('THC Customer Feedback');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);



// remove default footer
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
$pdf->SetFont('times', '', 48);

// add a page
$pdf->AddPage();
//QR COde Style
$style = array(
   
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 3.2, // width of a single module in points
    'module_height' => 3.2 // height of a single module in points
);
// Print a text
// $html = '<span style="background-color:yellow;color:blue;">&nbsp;PAGE 1&nbsp;</span>
// <p stroke="0.2" fill="true" strokecolor="yellow" color="blue" style="font-family:helvetica;font-weight:bold;font-size:26pt;">You can set a full page background.</p>';
// $pdf->writeHTML($html, true, false, true, false, '');

// first embed mask image (w, h, x and y will be ignored, the image will be scaled to the target image's size)

$pdf->write2DBarcode($encryptedURL, 'QRCODE,L', 51.5, 140.5,105,105,  $style, 'N');
$pdf->Image('images/thc-qr-logo.png', 95, 187, 20, '', '', '', '', false, 300);

//Close and output PDF document
$pdf->Output('example_051.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+