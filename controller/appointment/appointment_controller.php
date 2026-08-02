<?php
require('../../model/common/common_functions_copy.php');

class AppointmentController {
    var $varModelObj, $varDBConnection;
    public $actionevents;

    function __construct() {
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
    }

    function SQLArray() {
        $array = [];
        $array[1] = "INSERT INTO tbl_appointment (employee_id, employee_name, description, date) VALUES (?, ?, ?, ?)";
        $array[2] = "SELECT employee_id, employee_name FROM tbl_employees ORDER BY employee_name ASC";
        return $array;
    }

    function RequestAccept($FunctionEvents) {
        $var = $this->SQLArray();
        switch ($FunctionEvents) {
            case 'fetch_employees':
                $result = $this->varDBConnection->query($var[2]);
                $employees = [];
                while ($row = $result->fetch_assoc()) {
                    $employees[] = $row;
                }
                echo json_encode(['success' => true, 'data' => $employees]);
                break;

            case 'schedule_appointment':
                $employee_id = $_POST['employee_id'];
                $employee_name = $_POST['employee_name'];
                $description = $_POST['description'];
                $date = $_POST['date'];

                $stmt = $this->varDBConnection->prepare($var[1]);
                $stmt->bind_param('isss', $employee_id, $employee_name, $description, $date);
                if ($stmt->execute()) {
                    echo "Success";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
                break;

            default:
                echo 'No Action Found...!';
                break;
        }
    }
}

$obj = new AppointmentController();
$obj->RequestAccept($obj->actionevents);
?>