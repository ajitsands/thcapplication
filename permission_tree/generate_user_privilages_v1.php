

<?php



// Create connection
$conn = new mysqli("localhost","sianlab_thc_user","s@nds1@b","sianlab_db_thc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your SQL query

$sql = "SELECT 
    tbl_app_modules.ids, 
    tbl_app_modules.module_name, 
    module_permissions.ids AS subModuleID, 
    module_permissions.module_permission_name,
    COALESCE(role_permissions_v1.role_id, 0) AS rolePermissionsID
FROM 
    tbl_app_modules
LEFT JOIN 
    module_permissions ON tbl_app_modules.ids = module_permissions.module_id
LEFT JOIN 
    (
        SELECT module_id, role_id,module_name
        FROM role_permissions_v1
        WHERE role_id = ".$_GET['roleID']."
    ) AS role_permissions_v1 ON tbl_app_modules.module_name = role_permissions_v1.module_name
GROUP BY 
    tbl_app_modules.ids, 
    tbl_app_modules.module_name, 
    module_permissions.ids, 
    rolePermissionsID, 
    module_permissions.module_permission_name";




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
                'children' => []
            ];
            // Get the newly added parent node index
            $parentIndex = count($jsonData) - 1;
        } else {
            // Get the parent node index
            $parentIndex = $existingParentKey;
        }
        
        // Add the child node to the existing or newly added parent node
        if($row['rolePermissionsID']!=0)
        {
            $jsonData[$parentIndex]['children'][] = [
                'title' => $row['module_permission_name'],
                'subModuleID' => $row['subModuleID'],
                'selected' => true // You can set the selected value as needed
            ];
        }
        else
        {
            $jsonData[$parentIndex]['children'][] = [
                'title' => $row['module_permission_name'],
                'subModuleID' => $row['subModuleID'],
                'selected' => false // You can set the selected value as needed
            ];
        }
        
        
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
