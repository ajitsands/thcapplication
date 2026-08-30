<?php

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

$query = "select amc_visit_id,amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_code,customer_name,date_of_visits,date_format(`date_of_visits`,'%d ,%M %Y') as date_of_visits1,time_of_visit,amc_visit_status,amc_schedule_color,visit_mode,amc_ticket,additional_slots,visit_start_time from tbl_visits group by amc_tkt_ref_no,date_of_visits,visit_start_time ";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 
   
   $data[] = array(
  'id'   => $row["amc_visit_id"],
  'title'   => $row["amc_tkt_ref_no"],
  'start'   => $row['date_of_visits'].'T'.$row['visit_start_time'],
  'end'   => $row["date_of_visits"],
  'backgroundColor'   => $row["amc_schedule_color"],
  'borderColor'   => $row["amc_schedule_color"],
  'visit_mode' => $row["visit_mode"],
  'amc_status' => $row["amc_visit_status"],
  'amc_tkt_id' => $row["amc_tkt_id"],
  'customer_name' => $row["customer_name"],
  'customer_code' => $row["customer_code"],
  'amc_ticket' => $row["amc_ticket"],
  'additional_slots' => $row["additional_slots"],
  'visit_start_time' => $row["visit_start_time"],
   'start_slot' => $row["time_of_visit"],
   'date_of_visits1' => $row["date_of_visits1"],
    'date_of_visits_val' => $row["date_of_visits"],
   
   
 );

}
echo json_encode($data);

?>
