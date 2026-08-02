<?php    

    $newDirectoryName = '../httpdocs/qr_lib/asset_qr/amc_qr';
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.$newDirectoryName.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = '';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    if($_POST['text']=='')
    {
        echo "No code found";
        die;
    }
    
        
        // user data
        $filename = $PNG_TEMP_DIR.$_POST['text'].'.png';
        QRcode::png($_POST['text'], $filename, 'Q', 2, 2);    
        
  
    //display generated file
    echo $PNG_WEB_DIR.basename($filename) ;  
    
    
        
    // benchmark
    //QRtools::timeBenchmark();    

    