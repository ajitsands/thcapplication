<?php
include_once(__DIR__ . '/../../model/db_connection/connection.php');

$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    if ($action === 'get_spare_parts') {
        $filter_category = isset($_GET['filter_category']) ? $conn->real_escape_string($_GET['filter_category']) : '';
        $filter_status = isset($_GET['filter_status']) ? $conn->real_escape_string($_GET['filter_status']) : '';
        
        $whereClause = "WHERE 1=1";
        if ($filter_category !== '') {
            $whereClause .= " AND category = '$filter_category'";
        }
        if ($filter_status !== '') {
            $whereClause .= " AND status = '$filter_status'";
        }
        
        $sql = "SELECT * FROM tbl_spare_parts_master $whereClause ORDER BY category ASC, item_name ASC";
        $result = $conn->query($sql);
        
        $data = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        echo json_encode(array("data" => $data));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action === 'add_spare_part' || $action === 'update_spare_part') {
        $category = isset($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '';
        $item_code = isset($_POST['item_code']) ? $conn->real_escape_string($_POST['item_code']) : '';
        $item_name = isset($_POST['item_name']) ? $conn->real_escape_string($_POST['item_name']) : '';
        $type_name = isset($_POST['type_name']) ? $conn->real_escape_string($_POST['type_name']) : '';
        $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';
        
        if (empty($category) || empty($item_code) || empty($item_name) || empty($type_name)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
            exit;
        }

        if ($action === 'add_spare_part') {
            $sql = "INSERT INTO tbl_spare_parts_master (category, item_code, item_name, type_name, description) 
                    VALUES ('$category', '$item_code', '$item_name', '$type_name', '$description')";
                    
            if ($conn->query($sql) === TRUE) {
                $new_id = $conn->insert_id;
                echo json_encode(['success' => true, 'message' => 'Material added successfully.', 'new_id' => $new_id, 'item_name' => $item_name]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error adding material: ' . $conn->error]);
            }
        } else if ($action === 'update_spare_part') {
            $part_id = isset($_POST['part_id']) ? intval($_POST['part_id']) : 0;
            if ($part_id > 0) {
                $sql = "UPDATE tbl_spare_parts_master 
                        SET category = '$category', 
                            item_code = '$item_code', 
                            item_name = '$item_name', 
                            type_name = '$type_name', 
                            description = '$description' 
                        WHERE id = $part_id";
                        
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(['success' => true, 'message' => 'Material updated successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating material: ' . $conn->error]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid part ID.']);
            }
        }
        exit;
    }
    
    if ($action === 'delete_spare_part') {
        $part_id = isset($_POST['part_id']) ? intval($_POST['part_id']) : 0;
        
        if ($part_id > 0) {
            $chk = $conn->query("SELECT id FROM tbl_spare_parts_request_items WHERE item_id = $part_id LIMIT 1");
            if ($chk && $chk->num_rows > 0) {
                echo json_encode(['success' => false, 'message' => 'Material is already in use and cannot be deleted. You can deactivate it instead.']);
                exit;
            }
            
            $sql = "DELETE FROM tbl_spare_parts_master WHERE id = $part_id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Material deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting material: ' . $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid part ID.']);
        }
        exit;
    }

    if ($action === 'toggle_status') {
        $part_id = isset($_POST['part_id']) ? intval($_POST['part_id']) : 0;
        $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : 'Active';
        
        if ($part_id > 0) {
            $sql = "UPDATE tbl_spare_parts_master SET status = '$status' WHERE id = $part_id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Material status updated to ' . $status . '.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating status: ' . $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid part ID.']);
        }
        exit;
    }
}
?>
