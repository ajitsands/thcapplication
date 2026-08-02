<?php
session_start();
//load.php

$connect = new PDO('mysql:host=localhost;dbname=sianlab_db_thc', 'sianlab_thc_user', 's@nds1@b');


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
