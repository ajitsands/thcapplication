<?php
session_start();
//load.php

$is_local = (stripos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false || stripos($_SERVER['HTTP_HOST'] ?? '', '127.0.0.1') !== false);
$db_user = $is_local ? 'root' : 'thcfm_application_user';
$db_pass = 'S@nds1@b';
$db_name = $is_local ? 'db_thc' : 'thcfm_application_db';
try {
    $connect = new PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    try {
        $connect = new PDO("mysql:host=127.0.0.1;dbname=$db_name", $db_user, $db_pass);
    } catch (PDOException $e2) {
        $connect = null;
    }
}


$data = array();

  $query = "select * from tbl_amc_visits where amc_visit_status='Active'";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
   $tickets = '#0B9CF4';
    $AMC = '#A5B20B';
foreach($result as $row)
{
   
 $data[] = array(
  'id'   => $row["job_id"],
  'title'   => $row["amc_ref_no"],
  'start'   => $row['date_of_visits'].'T'.$row['time_of_visit'],
  'color'   =>  $tickets ,
  
  
 );
}

echo json_encode($data);

?>
