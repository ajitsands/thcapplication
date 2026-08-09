<?php
include('model/db_connection/connection.php');
$conn = new DBConnection();
$db = $conn->ConnectToMYSQL();

// Rename column leave_date to leave_start_date
$sql_alter = "ALTER TABLE `tbl_employee_short_leave` CHANGE `leave_date` `leave_start_date` DATE NOT NULL;";
mysqli_query($db, $sql_alter);

// Add leave_end_date column
$sql_add = "ALTER TABLE `tbl_employee_short_leave` ADD `leave_end_date` DATE NOT NULL AFTER `leave_start_date`;";
mysqli_query($db, $sql_add);

// Set leave_end_date = leave_start_date for existing records
$sql_update = "UPDATE `tbl_employee_short_leave` SET `leave_end_date` = `leave_start_date`;";
mysqli_query($db, $sql_update);

$sql_drop_proc = "DROP PROCEDURE IF EXISTS `proc_add_employee_short_leave`";
mysqli_query($db, $sql_drop_proc);

$sql_create_proc = "
CREATE PROCEDURE `proc_add_employee_short_leave`(
    IN `v_employee_id` INT,
    IN `v_employee_code` VARCHAR(100), 
    IN `v_employee_name` VARCHAR(100), 
    IN `v_leave_type` VARCHAR(100), 
    IN `v_leave_start_date` DATE,
    IN `v_leave_end_date` DATE, 
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
        `leave_start_date`, 
        `leave_end_date`,
        `leave_duration`, 
        `leave_reason`
    ) VALUES (
        v_employee_id,
        v_employee_code,
        v_employee_name,
        v_leave_type,
        v_leave_start_date,
        v_leave_end_date,
        v_leave_duration,
        v_leave_reason
    );
    
    SET msg = 'Success';
END
";

if (mysqli_query($db, $sql_create_proc)) {
    echo "Procedure updated successfully.\n";
} else {
    echo "Error creating procedure: " . mysqli_error($db) . "\n";
}
?>
