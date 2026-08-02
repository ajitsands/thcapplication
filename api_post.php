<?php

include "model/db_connection/connection.php" ;
$DBConn_path = new DBConnection();
// $path = $DBConn_path->filepath();
$api_url="http://demo.chruch.stmarysbahrain.com/dues/controller/member_dues.php?";
$api_message="action=get_member_details&notype=R&roll_number=2482&api_key=aae0bb94b2ac46efa66e37cce4f91023";
 date_default_timezone_set("Asia/Kolkata");
            $sCurrDate = date("Y-m"); //Current Date

        	$sDirPath = "/home/sianlab/public_html/thc/log/".$sCurrDate."/"; //Specified Pathname
        
        	if (!file_exists ($sDirPath))
        
           	{
        
        	    	mkdir($sDirPath,0777,true);  
        
        	}
$ch = curl_init();
//console.log('Getting Post Message in Curl Page  : '.$_POST['api_message']);
file_put_contents("/home/sianlab/public_html/thc/log/".$sCurrDate."/test_api_curl_star_out_" . date("d-m-Y") . ".txt", "\n" . $date . " : " . $api_url.$api_message, FILE_APPEND | LOCK_EX);


// curl_setopt($ch, CURLOPT_URL,$api_url);

// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS,$api_message);

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_URL,$api_url.$api_message);
                
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                

$server_output = curl_exec($ch);

curl_close ($ch);



file_put_contents("/home/sianlab/public_html/thc/log/".$sCurrDate."/test_api_curl_star_in_" . date("d-m-Y") . ".txt", "\n" . $date . " : " . trim($server_output), FILE_APPEND | LOCK_EX);

echo trim($server_output);


?>