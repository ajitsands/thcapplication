<?php
ob_start();
//============================================================+
// Description : QR Code Printing for AMC
//============================================================+

include(__DIR__ . "/../../model/db_connection/connection.php");
$db_connection =  new DBConnection();
$conn_obj = $db_connection->ConnectToMYSQL();

$amc_id = isset($_GET['amc_id']) ? intval($_GET['amc_id']) : 0;
$sql = "SELECT amc_ref_no FROM tbl_amc_master where amc_id=" . $amc_id;

$result = $conn_obj->query($sql);
$amc_ref_nos = array();
if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
     $amc_ref_nos[] = $row["amc_ref_no"];
  }
} else if (isset($_GET['amc_ref_no']) && !empty($_GET['amc_ref_no'])) {
  $amc_ref_nos[] = $_GET['amc_ref_no'];
} else {
  echo "0 results";
  die;
}
$conn_obj->close();

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SaNDS Lab');
$pdf->SetTitle('THC-FM');
$pdf->SetSubject('QR Code Printing');
$pdf->SetKeywords('QR Code Printing THC-FM');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE,0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// set font
$pdf->SetFont('helvetica', '', 6);

// QR Code Style
$style = array(
    'fgcolor' => array(0,0,0),
    'bgcolor' => false,
    'module_width' => 2.2,
    'module_height' => 2.2
);

// set JPEG quality
$pdf->setJPEGQuality(300);

foreach ($amc_ref_nos as $code) {
    $pdf->AddPage('L', array(50,25));
  
    $x = 21;
    $y = 7;
    $width = 25;  
    $height = 0;
    
    $img_file = K_PATH_IMAGES.'logo_print.png';
    $pdf->Image($img_file, $x, $y, $width);
    
    $pdf->write2DBarcode($code, 'QRCODE,L', 4.5, 3.5, 20, 20, $style, 'N');
    
    $pdf->Text(6, 20, $code);
}

if (ob_get_length()) {
    ob_end_clean();
}

// Close and output PDF document
$pdf->Output('AssetQR.pdf', 'I');
?>
