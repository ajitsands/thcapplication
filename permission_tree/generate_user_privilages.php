

<?php



// Create connection
include_once(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

// Check connection
if (!$conn || $conn->connect_error) {
    die("Connection failed: " . ($conn ? $conn->connect_error : mysqli_connect_error()));
}

// Your SQL query
$sql = "SELECT 
    a.ids,
    a.module_name,
    a.subModuleID,
    a.module_permission_name,
    CASE 
        WHEN EXISTS (
            SELECT 1 
            FROM role_permissions_v1 
            WHERE permission_id = a.subModuleID AND module_id = a.ids
            and role_id =".$_GET['roleID']."
        ) THEN
            (SELECT role_id 
             FROM role_permissions_v1 
             WHERE permission_id = a.subModuleID AND module_id = a.ids and role_id =".$_GET['roleID'].")
        ELSE 
            0 
    END AS role_id
FROM 
    view_modules_and_sub_mobules a";
    
    
    
    



// Execute the query
$result = $conn->query($sql);

// Initialize an array to store the JSON data
$jsonData = [];

// Check if there are results
if ($result->num_rows > 0) {
// Loop through the results and format the data
while ($row = $result->fetch_assoc()) {

    // Check if the parent node already exists in the JSON data
    $existingParentKey = array_search($row['ids'], array_column($jsonData, 'newids'));

    // If the parent node doesn't exist, create a new entry for it
    if ($existingParentKey === false) {
        $jsonData[] = [
            'title' => $row['module_name'],
            'newids' => $row['ids'],
            'folder' => true,
            'selectedCount' => 0,
            'nonSelectedCount' => 0,
            'children' => []
        ];
        // Get the newly added parent node index
        $parentIndex = count($jsonData) - 1;
    } else {
        // Get the parent node index
        $parentIndex = $existingParentKey;
    }
    
    // Determine if the current child is selected or not
    $selected = $row['role_id'] != 0;

    // Add the child node to the existing or newly added parent node
    $jsonData[$parentIndex]['children'][] = [
        'title' => $row['module_permission_name'],
        'subModuleID' => $row['subModuleID'],
        'selected' => $selected // You can set the selected value as needed
    ];

    // Update selected or non-selected count for the parent node
    if ($selected) {
        $jsonData[$parentIndex]['selectedCount']++;
    } else {
        $jsonData[$parentIndex]['nonSelectedCount']++;
    }
}

// Update the title of the parent nodes with the counts
foreach ($jsonData as &$item) {
    $totalCount = $item['selectedCount'] + $item['nonSelectedCount'];
    $item['title'] .= " - {$item['selectedCount']}/{$item['nonSelectedCount']}/{$totalCount}";
}

}

// Convert the array to JSON format
$jsonOutput = json_encode($jsonData, JSON_PRETTY_PRINT);
// Close the database connection
$conn->close();
// Output the JSON data
header('Content-Type: application/json');
echo $jsonOutput;



?>
