<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=sianlab_db_thc', 'sianlab_thc_user', 's@nds1@b');


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
