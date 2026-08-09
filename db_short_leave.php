<?php
include('model/db_connection/connection.php');
$conn = new DBConnection();
$db = $conn->ConnectToMYSQL();

$sql_create_table = "
CREATE TABLE IF NOT EXISTS `tbl_employee_short_leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `employee_code` varchar(100) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `leave_type` varchar(100) NOT NULL,
  `leave_date` date NOT NULL,
  `leave_duration` enum('Full Day','Half Day') NOT NULL,
  `leave_reason` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

if (mysqli_query($db, $sql_create_table)) {
    echo "Table tbl_employee_short_leave created successfully.\n";
} else {
    echo "Error creating table: " . mysqli_error($db) . "\n";
}

$sql_drop_proc = "DROP PROCEDURE IF EXISTS `proc_add_employee_short_leave`";
mysqli_query($db, $sql_drop_proc);

$sql_create_proc = "
CREATE PROCEDURE `proc_add_employee_short_leave`(
    IN `v_employee_id` INT,
    IN `v_employee_code` VARCHAR(100), 
    IN `v_employee_name` VARCHAR(100), 
    IN `v_leave_type` VARCHAR(100), 
    IN `v_leave_date` DATE, 
    IN `v_leave_duration` VARCHAR(50),
    IN `v_leave_reason` TEXT,
    OUT `msg` VARCHAR(255)
)
BEGIN
    INSERT INTO `tbl_employee_short_leave`(
        `employee_id`, 
        `employee_code`, 
        `employee_name`, 
        `leave_type`, 
        `leave_date`, 
        `leave_duration`, 
        `leave_reason`
    ) VALUES (
        v_employee_id,
        v_employee_code,
        v_employee_name,
        v_leave_type,
        v_leave_date,
        v_leave_duration,
        v_leave_reason
    );
    
    SET msg = 'Success';
END
";

if (mysqli_query($db, $sql_create_proc)) {
    echo "Procedure proc_add_employee_short_leave created successfully.\n";
} else {
    echo "Error creating procedure: " . mysqli_error($db) . "\n";
}
?>
