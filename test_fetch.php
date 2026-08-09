<?php
$_POST['action'] = 'fetch_leave_calendar';
require 'controller/employees/employees_controller.php';
$obj = new apartmentController();
$obj->RequestAccept($_POST);
?>
