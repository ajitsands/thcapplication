<?php
// Your JSON data
$jsonData = $_POST['user_role_data'];

// Decode JSON data into PHP array
$dataArray = json_decode($jsonData, true);

// Create connection
$conn = new mysqli("localhost", "sianlab_thc_user", "s@nds1@b", "sianlab_db_thc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind SQL DELETE statement
$stmtDelete = $conn->prepare("DELETE FROM user_roles_v1 WHERE user_id = ?");
foreach ($dataArray as $row) {
    $stmtDelete->bind_param("s", $row['userID']);
    if (!$stmtDelete->execute()) {
        echo "Error: " . $stmtDelete->error;
    }
}
$stmtDelete->close();

// Prepare and bind SQL INSERT statement
$stmtInsert = $conn->prepare("INSERT INTO user_roles_v1 (user_id, role_id) VALUES (?, ?)");
if($row['roleID']!=0)
{
    // Bind parameters and execute INSERT statement for each row in the array
    foreach ($dataArray as $row) {
        $stmtInsert->bind_param("ss", $row['userID'], $row['roleID']);
        if (!$stmtInsert->execute()) {
            echo "Error: " . $stmtInsert->error;
            //echo $row['rollID'].'----'. $row['moduleId'].'----'.  $row['subModuleID'].'----'.  $row['subModuleName'];
        }
        //echo "Insert : ";
    }
}

// Close statement and database connection
$stmtInsert->close();
$conn->close();

echo "Data inserted successfully.";

?>
