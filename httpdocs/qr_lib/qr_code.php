<?php 

// Include the qrlib file 
include 'lib/qrlib.php'; 
$asset_code= $_GET['qr'];
$size = 3;
$firstThreeChars = substr($asset_code, 0, 3);

switch($firstThreeChars)
{
    case 'AMC':
        $dir_filename = "asset_qr/amc_qr/";
    break;
     case 'THC':
        $dir_filename = "asset_qr/customer_asset/";
    break;
}
$filename = $dir_filename . $asset_code . '.png';

if (!file_exists($filename)) {
    QRcode::png($asset_code, $filename, QR_ECLEVEL_L, $size, 2);
}


?> 
