<?php 

include('db_variables.php');
class UserPermisssion
{
            
			function __construct($roll_id_from_user_table)
			{
				if ($roll_id_from_user_table != null) {
				    
					//$arr =  json_encode($this->getUserPermissions($roll_id_from_user_table)); // V1 Function Call 
				    $arr =  json_encode($this->getUserPermissionsByUserID($roll_id_from_user_table)); //V2 Function Call
					echo "<script>var permissions = $arr;</script>";
				}
			}
            function DatabaseConnection()
            {
                global $servername, $username, $password, $database;
                mysqli_report(MYSQLI_REPORT_OFF);
                $conn = @new mysqli($servername, $username, $password, $database);
                if ($conn->connect_error) {
                    $conn = @new mysqli("127.0.0.1", $username, $password, $database);
                }
                if ($conn->connect_error) {
                    die("Database Connection failed: " . $conn->connect_error);
                }
                return $conn;
            }
            
            function getUserPermissionsByUserID($userId) { // This function for V2 Application
                $connection = $this->DatabaseConnection();
                $userId = intval($userId);
                $sql = "select sub_module_name as name from role_permissions_v1 rp 
                INNER JOIN user_roles_v1 ur ON rp.role_id = ur.role_id where ur.user_id = $userId";

                $permissions = [];
                $result = $connection->query($sql);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        if (!empty($row['name'])) {
                            $permissions[] = $row['name'];
                        }
                    }
                    $result->free();
                }
                $connection->close();
                return $permissions;
            }// Close of Function
            
            
            function getUserPermissions($roleId) { // This function Works only in V1 Application 
                $connection = $this->DatabaseConnection();
                $roleId = intval($roleId);
                $sql = "SELECT p.name
                        FROM permissions p
                        INNER JOIN role_permissions rp ON p.id = rp.permission_id
                        WHERE rp.role_id = $roleId";

                $permissions = [];
                $result = $connection->query($sql);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        if (!empty($row['name'])) {
                            $permissions[] = $row['name'];
                        }
                    }
                    $result->free();
                }
                $connection->close();
                return $permissions;
            }// Close of Function
			
			function ActionRequest($action)
			{
				switch($action)
				{
					case 'AddNewPermission':
						$this->addNewEventToJS($_POST['dbValue']);
					break;
					case 'listData':
						$this->getAllControlNameAndClass($_POST['moduleId']);
					break;
					case 'listData_developer_view':  
						$this->getAllControlNameAndClassOnly();
					break;
					case 'listOfRolls':
						$this->getListOfRolls();
					break;
					case 'listOfPermissionBasedOnRolls':
						$this->getListOfRollsBasedonRolls($_POST['rollId']);
						//$this->getListOfRollsBasedonRolls($_POST['moduleId']);
					break;
					case 'listOfPermissionBasedOnRolls_1':
					    $this->getListOfRollsBasedonRolls($_POST['moduleId']);
					break;    
					case 'save_privilages':
					    $this->SavePrivilages($_POST['privilage_data'],$_POST['rollId'],$_POST['module_id']);
					break;
					case 'listOfUsers':
					    $this->getListOfUsers();
					break;
					case 'update_user_privilages':
					    $this->updateUserPrivilage($_POST['privilage_id'],$_POST['userId']);
					break;
					case 'updateUserPrivilageByUserID':
					    $this->updateUserPrivilageByUserID($_POST['privilage_id'],$_POST['userId']);
					break;
					
					case 'addRolesOrGroups':
					    $this->addRolesOrGroups($_POST['add_RolesOrGroups']);
					break;
					case 'deletePermissionss':
					    $this->deletePermissionss($_POST['rowIDValue'],$_POST['moduleName']);
					break;
					case 'listOfSelectedUserRolls':
					    $this->listOfSelectedUserRolls($_POST['userId']);
					break;
					
					case 'listOfAllModules':
					     $this->getListOfModules();
					break; 
					case 'listOfAvlModules':
					     $this->listOfAvlModules();
					break; 
					case 'checkModuleOn':
					     $this->checkModuleOn();
					break; 
						case 'checkModuleOff':
					     $this->checkModuleOff();
					break; 
					
			
				}
			}
			
			



		
			function checkModuleOn()
			{
			    $connection = $this->DatabaseConnection();
			    $roleID = intval($_POST['v_roleID'] ?? 0);
			    $classviewID = intval($_POST['v_module_classview_id'] ?? 0);
			    $moduleID = intval($_POST['v_module_id'] ?? 0);
				$sql = "insert into role_permissions(role_id,permission_id,module_id,parent_status) values($roleID,$classviewID,$moduleID,'Yes')";
			    $connection->query($sql);
                $connection->close();
			}
			function checkModuleOff()
			{
			    $connection = $this->DatabaseConnection();
			    $roleID = intval($_POST['v_roleID'] ?? 0);
			    $classviewID = intval($_POST['v_module_classview_id'] ?? 0);
			    $moduleID = intval($_POST['v_module_id'] ?? 0);
				$sql = "delete from role_permissions where role_id=$roleID and permission_id=$classviewID and module_id=$moduleID";
			    $connection->query($sql);
                $connection->close();
			}
			
			
			function getAllControlNameAndClass($moduleId)
			{
			    $connection = $this->DatabaseConnection();
			    $safeModuleId = $connection->real_escape_string($moduleId);
				$sql = "select * from permissions where module_id='".$safeModuleId."'";
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			
			function getAllControlNameAndClassOnly()
			{
			    $connection = $this->DatabaseConnection();
				$sql = "select * from permissions";
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			
			function getListOfModules()
			{
			    $connection = $this->DatabaseConnection();
				$sql = "SELECT * FROM tbl_app_modules WHERE status='Active'";
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			function listOfAvlModules()
			{
			    $connection = $this->DatabaseConnection();
			    $roleId = intval($_POST['selectedRoleID'] ?? 0);
				$sql = "SELECT DISTINCT module_name,ids from tbl_app_modules Join role_permissions on role_permissions.`module_id` = tbl_app_modules.ids where role_permissions.role_id=".$roleId;
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			
			function listOfSelectedUserRolls($UserID)
			{
			    $connection = $this->DatabaseConnection();
			    $userId = intval($UserID);
				$sql = "SELECT r.name FROM users u JOIN user_roles ur ON u.id = ur.user_id JOIN roles r ON ur.role_id = r.id WHERE u.id =".$userId;
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			
			
			
			function getListOfRolls()
			{
			    $connection = $this->DatabaseConnection();
				$sql = "select * from  roles";
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			function getListOfRollsBasedonRolls($rollID)
			{
			    $connection = $this->DatabaseConnection();
			    $rollID = intval($rollID);
				$sql = "select DISTINCT permissions.id, permissions.name,role_permissions.module_id from role_permissions join permissions
on role_permissions.permission_id = permissions.id
where  role_permissions.role_id = $rollID and parent_status='No'";

                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			
			function getListOfUsers()
			{
			    $connection = $this->DatabaseConnection();
				$sql = "SELECT users.id, users.username, roles.name as role_name, tbl_employees.employee_name FROM users LEFT JOIN roles ON roles.id = users.role_id LEFT JOIN tbl_employees ON tbl_employees.employee_code = users.username";
                $result = $connection->query($sql);
                $data = [];
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data['data'][] = $row;
                    }
                    $result->free();
                }
                echo json_encode($data);
                $connection->close();
			}
			function updateUserPrivilageByUserID($privilageID,$userID) // For V1 Application
			{
			        //echo var_dump($privilageID).'---'.$userID;
			    // User ID
			        $roleIds = $privilageID;
                    $userId = $userID;
                    
                    // Initialize the SQL query string
                    $sqlQuery = "INSERT INTO user_roles (role_id,user_id ) VALUES ";
                    
                    // Iterate over the role IDs array
                    foreach ($roleIds as $roleId) {
                        // Append each pair of user ID and role ID to the query string
                        $sqlQuery .= "($roleId, $userId),";
                    }
                    
                    // Remove the trailing comma
                    $sqlQuery = rtrim($sqlQuery, ',');
                    
                    // Now $sqlQuery contains the generated SQL query string
                   
                    
			        $connection = $this->DatabaseConnection();
				// Prepare SQL statement to fetch permissions based on role ID
				$sql = "delete from user_roles where user_id=".$userId;

				// Prepare and execute the query
				if ($connection->query($sql) === TRUE) {
                  echo "Role revoked successfully & ";
                } else {
                  echo "Error: " . $sql . "<br>" . $connection->error;
                }
                
                
				// Prepare and execute the query
				if ($connection->query($sqlQuery) === TRUE) {
                  echo "Role Added successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . $connection->error;
                }
                
                $connection->close();
			}
			function updateUserPrivilage($privilageID,$userID) // For V1 Application
			{
			     $connection = $this->DatabaseConnection();
				// Prepare SQL statement to fetch permissions based on role ID
				$sql = "update users set role_id=".$privilageID." where id=".$userID;

				// Prepare and execute the query
				if ($connection->query($sql) === TRUE) {
                  echo "Role Changed successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . $connection->error;
                }
                $connection->close();
			}
			
			function addRolesOrGroups($rollName) 
			{
			    $connection = $this->DatabaseConnection();
			
				$safeRollName = $connection->real_escape_string($rollName);
				$sqlCheck = "SELECT user_type_name FROM tbl_user_types WHERE user_type_name LIKE '%" . $safeRollName . "%'";
                $result = $connection->query($sqlCheck);
                $numRows = ($result) ? $result->num_rows : 0;
                if($numRows==0)
                {
                    $sqlCheckInsert = "insert into tbl_user_types(`user_type_name`) VALUES('".$rollName."')";
                    $connection->query($sqlCheckInsert);
                    $sql = "insert into roles(name) values('".$rollName."')";
    				if ($connection->query($sql) === TRUE) {
                      echo "New record created successfully";
                    } else {
                      echo "Error: " . $sql . "<br>" . $connection->error;
                    }
                }
                else
                {
                    echo "User Type - Name Already Exist !";
                }
                
				
                
                $connection->close();
			}
			function deletePermissionss($ids,$moduleName) 
			{
			    $connection = $this->DatabaseConnection();
				// Prepare SQL statement to fetch permissions based on role ID
				$sql = "delete from permissions where id=".$ids;

				// Prepare and execute the query
				if ($connection->query($sql) === TRUE) {
				$this->deleteALineFromTheFile($moduleName);
				$sqlDel = "DELETE FROM module_permissions WHERE module_permission_name='".$moduleName."'";
				$connection->query($sqlDel);
                  echo "Permission removed successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . $connection->error;
                }
                
                $connection->close();
                
                
			}
			
			function deleteALineFromTheFile($modulename)
			{
                    
                    // File path
                    $filename = '../js/permission.js';
                    
                    // Text to search for
                    $textToRemove = $modulename;
                    
                    // Read the file line by line into an array
                    $lines = file($filename);
                    
                    // Initialize an array to store lines without the text
                    $linesWithoutText = [];
                    
                    // Iterate through each line
                    foreach ($lines as $line) {
                        // Check if the line contains the text to remove
                        if (strpos($line, $textToRemove) === false) {
                            // If the text is not found, add the line to the array
                            $linesWithoutText[] = $line;
                        }
                    }
                    
                    // Write the modified lines back to the file
                    file_put_contents($filename, implode('', $linesWithoutText));
                    
                    echo "Lines containing '$textToRemove' removed from the file.";
			}
			
			function addNewEventToJS($dbValue)
			{
			    $connection = $this->DatabaseConnection();
				// Prepare SQL statement to fetch permissions based on role ID
				$sql = "insert into permissions(name,class_name) values('".$dbValue."','class".$dbValue."')";
                $sqlModuleApp = "INSERT INTO module_permissions(module_permission_name,module_id) VALUES('".$dbValue."','".$_POST['selectModuleId']."')";
				// Prepare and execute the query
				if ($connection->query($sql) === TRUE)
				{
				   $connection->query($sqlModuleApp); 
                   echo "New record created successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . $connection->error;
                }
                
                $connection->close();
			    
					// Specify the path to your file
					$filename = '../js/permission.js';

					// Read the file into an array of lines
					$fileContent = file($filename);

					// Loop through each line to find and replace the line containing "// add_new_var"
					foreach ($fileContent as $key => $line) {
						if (strpos($line, '// add_new_var') !== false) {
							// Replace the line with new content
							$newLineToAdd = "\n\t"; // New line content with a newline character
							$fileContent[$key] = $newLineToAdd.'var event'.$dbValue.' = document.querySelectorAll(".class'.$dbValue.'");'; // Replace "new line to add" with your new content
							$fileContent[$key] .= $newLineToAdd."// add_new_var\n"; 
							break; // Stop searching after the line is replaced
						}
					}

					// Write the updated content back to the file
					file_put_contents($filename, implode('', $fileContent));
					
					
					// Loop through each line to find and replace the line containing "// adding_new_permission"
					foreach ($fileContent as $key => $line) {
						if (strpos($line, '// adding_new_permission') !== false) {
							// Replace the line with new content
							$newLineToAdd = "\n\t"; // New line content with a newline character
							$fileContent[$key] = $newLineToAdd.'event'.$dbValue.'.forEach(function(obj) {if (!hasPermission("'.$dbValue.'")) {obj.style.display = "none";}});'; // Replace "new line to add" with your new content
							$fileContent[$key] .= $newLineToAdd."// adding_new_permission\n"; 
							break; // Stop searching after the line is replaced
						}
					}

					// Write the updated content back to the file
					file_put_contents($filename, implode('', $fileContent));
					

					// Optionally, you can return a response to the client
					echo "Main Permission Parameter Added";


			}
			
			function SavePrivilages($permissionIds,$roleId,$moduleID)
			{
			       // Fixed value for the first part of each pair
                    $fixedValue = $roleId;
                    
                    // Check if both arrays have the same length
                    if (count($permissionIds) !== count($moduleID)) {
                        // Arrays don't have the same length, handle the error here
                        echo "Arrays don't have the same length.";
                    } else {
                        // Initialize an empty string to store the values part of the query
                        $values = "";
                    
                        // Iterate through the arrays and construct the values string
                        for ($i = 0; $i < count($permissionIds); $i++) {
                            // Concatenate each pair with the role ID into the values string
                            $values .= "($fixedValue, {$permissionIds[$i]}, {$moduleID[$i]}),";
                        }
                    
                        // Remove the trailing comma from the values string
                        $values = rtrim($values, ",");
                    
                        // Construct the insert query
                        $insertQuery = "INSERT INTO role_permissions (role_id, permission_id, module_id) VALUES $values;";
                        //echo $insertQuery; // For testing purposes
                        // Execute the insert query here
                    }

    
                    $deleteQuery = "delete from role_permissions where role_id=".$roleId." and parent_status='No'";
                    
                    $connection = $this->DatabaseConnection();
    				
    				// Prepare and execute the query
    				if ($connection->query($deleteQuery) === TRUE) {
                          if($connection->query($insertQuery) === TRUE) {
                              echo "Privilage Added";
                          }
                          else {
                              echo "Error: " . "<br>" . $connection->error;
                          }
                          
                    } else {
                      echo "Error: " . "<br>" . $connection->error;
                    }
                
                    $connection->close();
                    
                    // Output the insert query
                    //echo $insertQuery;
			    
			}
}// Close of Class
//isset($_SESSION['USERROLLID']) ? $_SESSION['USERROLLID'] : 'null'
//$obj = new UserPermisssion($_SESSION['USERROLLID'] ?? null); // PHP 7 and Above
$userRollId = isset($_SESSION['USERROLLID']) ? $_SESSION['USERROLLID'] : null;
$obj = new UserPermisssion($userRollId);

//$obj->ActionRequest($_POST['action'] ?? null);
$postAction = isset($_POST['action']) ? $_POST['action'] : null;
$obj->ActionRequest($postAction);
?>