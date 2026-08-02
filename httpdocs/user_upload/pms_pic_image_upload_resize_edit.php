<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        
        
$maxDimW = 200;
$maxDimH = 150;
 $targetWidth = 200;
$targetHeight = 150;
list($width, $height, $type, $attr) = getimagesize( $_FILES['file']['tmp_name'] );
if ( $width > $maxDimW || $height > $maxDimH ) {
    $target_filename = $_FILES['file']['tmp_name'];
    $fn = $_FILES['file']['tmp_name'];
    $size = getimagesize( $fn );
    $ratio = $size[0]/$size[1]; // width/height
     if ($ratio > 1) {
                    $ratioFactor = $size[0] / $targetWidth;
                    $targetHeight = $size[1] / $ratioFactor;
                    $dstY = (200 - $targetHeight) / 2;
             } else {
                    $ratioFactor = $size[1] / $targetHeight;
                    $targetWidth = $size[0] / $ratioFactor;
                    $dstX = (150 - $targetWidth) / 2;
             }
    
    // if( $ratio > 1) {
    //     $width = $maxDimW;
    //     $height = $maxDimH/$ratio;
    // } else {
    //     $width = $maxDimW*$ratio;
    //     $height = $maxDimH;
    // }
    $src = imagecreatefromstring(file_get_contents($fn));
    $dst = imagecreatetruecolor( $targetWidth, $targetHeight );
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $targetWidth, $targetHeight, $size[0], $size[1] );

    imagejpeg($dst, $target_filename); // adjust format as needed


}


 move_uploaded_file($_FILES['file']['tmp_name'], '../images/pms_uploads/' .$_GET["random_no"]);        
        
    }
?>



