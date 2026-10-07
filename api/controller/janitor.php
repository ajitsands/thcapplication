<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once(__DIR__ . '/../../model/db_connection/connection.php');
include_once(__DIR__ . '/../../view/template/includes/en_de_header.inc');

$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$OBJ = new URLEncription();
$api_key_input = isset($_REQUEST['APIKEY']) ? $_REQUEST['APIKEY'] : '';
$api_key = $OBJ->KEYDecode(trim($api_key_input));

if(trim($api_key) != 'thcauthentication') {
    echo json_encode(['status' => 'error', 'message' => 'api_key_error']);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// Basic details and actions for janitor will be added below

if ($action === 'getJanitorDetails') {
    // Example endpoint for basic details
    /*
    $janitor_id = isset($_REQUEST['janitor_id']) ? (int)$_REQUEST['janitor_id'] : 0;
    
    if ($janitor_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'janitor_id is required']);
        exit;
    }
    
    $sql = "SELECT * FROM tbl_employees WHERE employee_id = $janitor_id AND designation = 'Janitor'";
    // ... query execution and response
    */
    
    echo json_encode(['status' => 'success', 'data' => []]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
?>
