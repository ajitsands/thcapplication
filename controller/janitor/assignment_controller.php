<?php
include('../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'get_dropdown_data') {
        $customers = [];
        $res = mysqli_query($conn, "SELECT customer_id, customer_name, customer_code FROM tbl_customers WHERE customer_status = 'Active'");
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $customers[] = $row;
            }
        }

        $janitors = [];
        $res2 = mysqli_query($conn, "SELECT employee_id, employee_name, employee_code FROM tbl_employees WHERE employee_type_name LIKE '%Janitor%' OR employee_type_id IN (SELECT user_type_id FROM tbl_user_types WHERE user_type_name LIKE '%Janitor%')");
        if($res2) {
            while ($row = mysqli_fetch_assoc($res2)) {
                $janitors[] = $row;
            }
        }
        
        $checklists = [];
        $res4 = mysqli_query($conn, "SELECT id, checklist_name FROM tbl_janitor_checklists WHERE status = 'Active'");
        if($res4) {
            while ($row = mysqli_fetch_assoc($res4)) {
                $checklists[] = $row;
            }
        }

        echo json_encode([
            "customers" => $customers,
            "janitors" => $janitors,
            "checklists" => $checklists
        ]);
    }
    else if ($action == 'get_locations') {
        $customer_id = (int)$_POST['customer_id'];
        $locations = [];
        $res = mysqli_query($conn, "SELECT DISTINCT location_id, location_name FROM tbl_customer_location WHERE customer_id = $customer_id");
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $locations[] = $row;
            }
        }
        echo json_encode(["locations" => $locations]);
    }
    else if ($action == 'get_buildings') {
        $customer_id = (int)$_POST['customer_id'];
        $location_id = (int)$_POST['location_id'];
        $buildings = [];
        $res = mysqli_query($conn, "SELECT DISTINCT building_id, building_name FROM tbl_customer_location WHERE customer_id = $customer_id AND location_id = $location_id");
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $buildings[] = $row;
            }
        }
        echo json_encode(["buildings" => $buildings]);
    }
    else if ($action == 'get_amcs') {
        $customer_id = (int)$_POST['customer_id'];
        $amcs = [];
        $res = mysqli_query($conn, "SELECT amc_ref_no, amc_start_date, amc_end_date FROM tbl_amc_master WHERE customer_id = $customer_id AND amc_status != 'Cancelled'");
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $amcs[] = $row;
            }
        }
        echo json_encode(["amcs" => $amcs]);
    }
    else if ($action == 'get_amc_details') {
        $amc_ref_no = mysqli_real_escape_string($conn, $_POST['amc_ref_no']);
        $res = mysqli_query($conn, "SELECT amc_ref_no, amc_status, contract_type_name, amc_start_date, amc_end_date FROM tbl_amc_master WHERE amc_ref_no = '$amc_ref_no'");
        $data = mysqli_fetch_assoc($res);
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'get_assets') {
        $customer_id = (int)$_POST['customer_id'];
        $location_id = (int)$_POST['location_id'];
        $building_id = (int)$_POST['building_id'];
        
        $assets = [];
        $q = "SELECT asset_id, asset_ref_no FROM tbl_assets WHERE is_janitor_asset = 'YES' AND customer_id = $customer_id AND location_id = $location_id AND building_id = $building_id";
        $res = mysqli_query($conn, $q);
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $assets[] = $row;
            }
        }
        echo json_encode(["assets" => $assets]);
    }
    else if ($action == 'get_asset_details') {
        $asset_id = (int)$_POST['asset_id'];
        $res = mysqli_query($conn, "SELECT asset_ref_no, asset_status, asset_category_name, asset_type_name, asset_description FROM tbl_assets WHERE asset_id = $asset_id");
        $data = mysqli_fetch_assoc($res);
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'get_checklist_details') {
        $checklist_id = (int)$_POST['checklist_id'];
        $sql = "SELECT c.checklist_name, c.status, 
                (SELECT COUNT(id) FROM tbl_janitor_checklist_categories WHERE checklist_id = c.id) as category_count,
                (SELECT COUNT(i.id) FROM tbl_janitor_checklist_items i JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id WHERE cat.checklist_id = c.id) as point_count
                FROM tbl_janitor_checklists c 
                WHERE c.id = $checklist_id";
        $res = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($res);
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'save_assignment') {
        $assignment_id = (int)$_POST['assignment_id'];
        $customer_id = (int)$_POST['customer_id'];
        $location_id = (int)$_POST['location_id'];
        $building_id = (int)$_POST['building_id'];
        
        // Handle array of employee IDs
        $employee_ids_arr = isset($_POST['employee_id']) ? $_POST['employee_id'] : [];
        $employee_ids_str = mysqli_real_escape_string($conn, implode(',', $employee_ids_arr));
        
        $asset_id = (int)$_POST['asset_id'];
        $amc_ref_no = mysqli_real_escape_string($conn, $_POST['amc_ref_no']);
        $checklist_id = (int)$_POST['checklist_id'];
        $frequency = mysqli_real_escape_string($conn, $_POST['frequency']);
        $slots = mysqli_real_escape_string($conn, $_POST['slots']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

        if ($assignment_id == 0) {
            $sql = "INSERT INTO tbl_janitor_assignments (customer_id, location_id, building_id, checklist_id, employee_id, asset_id, amc_ref_no, frequency, slots, start_date, end_date) 
                    VALUES ($customer_id, $location_id, $building_id, $checklist_id, '$employee_ids_str', $asset_id, '$amc_ref_no', '$frequency', '$slots', '$start_date', '$end_date')";
        } else {
            $sql = "UPDATE tbl_janitor_assignments SET 
                    customer_id=$customer_id, location_id=$location_id, building_id=$building_id,
                    checklist_id=$checklist_id, employee_id='$employee_ids_str', asset_id=$asset_id, amc_ref_no='$amc_ref_no',
                    frequency='$frequency', slots='$slots', start_date='$start_date', end_date='$end_date'
                    WHERE id=$assignment_id";
        }

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Assignment saved successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    }
    else if ($action == 'list_assignments') {
        $data = [];
        $sql = "SELECT a.*, 
                (SELECT GROUP_CONCAT(employee_name SEPARATOR ', ') FROM tbl_employees WHERE FIND_IN_SET(employee_id, a.employee_id)) as employee_name, 
                c.checklist_name, 
                ast.asset_ref_no 
                FROM tbl_janitor_assignments a
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
                ORDER BY a.id DESC";
        $res = mysqli_query($conn, $sql);
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
        }
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'get_assignment') {
        $id = (int)$_POST['assignment_id'];
        $res = mysqli_query($conn, "SELECT * FROM tbl_janitor_assignments WHERE id = $id");
        $data = mysqli_fetch_assoc($res);
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'change_status') {
        $id = (int)$_POST['assignment_id'];
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        mysqli_query($conn, "UPDATE tbl_janitor_assignments SET status = '$status' WHERE id = $id");
        echo json_encode(["status" => "success"]);
    }
}
?>
