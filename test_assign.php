<?php
$_POST = array(
    "action" => "assign_technician",
    "visitidarray" => array(3613),
    "amc_tkt_idarray" => array(25),
    "amc_ref_noarray" => array("AMC0167"),
    "customer_idarray" => array(81),
    "customer_codearray" => array("C0081"),
    "customer_namearray" => array("Aramex"),
    "location_idarray" => array(54),
    "location_codearray" => array("BU"),
    "location_namearray" => array("Busaiteen"),
    "building_idarray" => array(197),
    "building_codearray" => array("F0197"),
    "building_namearray" => array("Aramex"),
    "visit_date_array" => array("16-06-2024"),
    "startslot_array" => array(8),
    "additional_slotsarray" => array(1),
    "visit_start_timearray" => array("00:00:00"),
    "empidarray" => array(12),
    "empcodearray" => array("EMP001"),
    "empnamearray" => array("John Doe"),
    "leadr_emp_id" => "12",
    "totalslot_array" => array(9),
    "emp_count" => 1,
    "ticket_count" => 1,
    "empcontactnoarray" => array("12345678")
);
require("controller/amc_schedule/amc_assign_controller.php");
$ctrl = new amcscheduleController();
$ctrl->RequestAccept("assign_technician");
?>
