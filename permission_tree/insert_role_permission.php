<?php
// Your JSON data
$jsonData = $_POST['permission_data'];

// Decode JSON data into PHP array
$dataArray = json_decode($jsonData, true);

// Create connection
$conn = new mysqli("localhost", "sianlab_thc_user", "s@nds1@b", "sianlab_db_thc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind SQL DELETE statement
//$stmtDelete = $conn->prepare("DELETE FROM role_permissions_v1 WHERE role_id = ? and module_name!='Yes'"); // Before 23-03-2024
$stmtDelete = $conn->prepare("DELETE FROM role_permissions_v1 WHERE role_id = ?");
$stmtDelete->bind_param("s", $_POST['mainRoleID']);
$stmtDelete->execute();
$stmtDelete->close();

// Prepare and bind SQL INSERT statement
$stmtInsert = $conn->prepare("INSERT INTO role_permissions_v1 (role_id, permission_id, module_id, sub_module_name,module_name) VALUES (?, ?, ?, ?, ?)");

// Bind parameters and execute INSERT statement for each row in the array
foreach ($dataArray as $row) {
    $stmtInsert->bind_param("sssss", $row['rollID'], $row['subModuleID'], $row['moduleId'], $row['subModuleName'],$row['parentTitle']);
    if (!$stmtInsert->execute()) {
        echo "Error: " . $stmtInsert->error;
        //echo $row['rollID'].'----'. $row['moduleId'].'----'.  $row['subModuleID'].'----'.  $row['subModuleName'];
    }
    //echo "Insert : ";
}

// Close statement and database connection
$stmtInsert->close();
$conn->close();

echo "Permission assigned to the selected group";

?>
