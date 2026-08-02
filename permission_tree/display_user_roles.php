

<?php



// Create connection
$conn = new mysqli("localhost","sianlab_thc_user","s@nds1@b","sianlab_db_thc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your SQL query
$sql = "SELECT * FROM `user_roles_v1` 
LEFT JOIN roles ON
user_roles_v1.role_id = roles.id 
where user_roles_v1.user_id = ".$_POST['userID'].";";



// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
// Loop through the results and format the data
$strRoles = "";
while ($row = $result->fetch_assoc()) {

    $strRoles .= '<div added_data_user_role="'.$row["role_id"].'"  style="background-color: #4A91D5; border-radius: 5px; color: white; font-size: 12px; padding: 5px; padding-left: 10px; margin-bottom: 5px;margin-left:5px; display: inline-block;" >'.$row["name"].'&nbsp;&nbsp;<a class="user_role_button"  style="color: white; border-radius: 5px; padding: 4px; cursor: pointer;"><i class="bi bi-x-square"></i></a></div>';
   
}


}

// Convert the array to JSON format
//$jsonOutput = json_encode($jsonData, JSON_PRETTY_PRINT);
// Close the database connection
$conn->close();
// Output the JSON data
header('Content-Type: application/html');
echo $strRoles;



?>
