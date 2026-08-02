<?php

// $connect = new PDO('mysql:host=localhost;dbname=sianlab_db_thc', 'sianlab_thc_user', 's@nds1@b');

// $data = array();



// $statement = $connect->prepare($query);
// $statement->execute();
// $result = $statement->fetchAll();


//echo "welcome";


// Database credentials
// $host = 'localhost';
// $dbname = 'sianlab_db_thc';
// $username = 'sianlab_thc_user';
// $password = 's@nds1@b';

// // PDO connection
// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     // Set PDO to throw exceptions for errors
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }
include(__DIR__ . '/../../model/db_connection/connection.php');
$connection = new DBConnection();
$conn = $connection->ConnectToMYSQL();
$data = array();
$query = "SELECT amc_visit_id, amc_tkt_id, amc_tkt_ref_no, amc_ticket, customer_code, customer_name, 
          date_of_visits, DATE_FORMAT(`date_of_visits`, '%d ,%M %Y') AS date_of_visits1, time_of_visit, 
          amc_visit_status, 
          CASE 
              WHEN amc_visit_status='Scheduled' THEN '#39C0ED' 
              WHEN amc_visit_status='Assigned' THEN '#3F51B5'  
              WHEN amc_visit_status='Completed' THEN '#795548' 
              WHEN amc_visit_status='Closed' THEN '#4CAF50' 
              WHEN amc_visit_status='Cancelled' THEN '#B23CFD' 
              WHEN amc_visit_status='Extended' THEN '#FFC107' 
              ELSE '#39C0ED' 
          END AS amc_schedule_color, 
          visit_mode, amc_ticket, additional_slots, visit_start_time 
          FROM tbl_visits 
          GROUP BY amc_tkt_ref_no, date_of_visits, visit_start_time";
$result = mysqli_query($conn, $query); 

foreach ($result as $row) {
    $data[] = array(
        'id' => $row["amc_visit_id"],
        'title' => $row["amc_tkt_ref_no"],
        'start' => $row['date_of_visits'] . 'T' . $row['visit_start_time'],
        'end' => $row["date_of_visits"],
        'backgroundColor' => $row["amc_schedule_color"],
        'borderColor' => $row["amc_schedule_color"],
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
