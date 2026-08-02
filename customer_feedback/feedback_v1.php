<?PHP


include "../model/db_connection/connection.php";
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cutomerName = $_POST['cutomerName'];
$customerEmail = $_POST['customerEmail'];
$customerPhone = $_POST['customerPhone'];

$amc_ref_no = $_POST['amc_ref_no'];
$contract_type = $_POST['contract_type'];
$customer_code = $_POST['customer_code'];
$main_customer_name = $_POST['main_customer_name'];
$category = $_POST['category'];

date_default_timezone_set('Asia/Bahrain');
$current_date = date("Y-m-d h:i:s");

if ($_POST['action'] == 'insert_feedback') {
    // Decode JSON strings into associative arrays
    $radioData = json_decode($_POST['radioValues'], true);
    $checkboxData = json_decode($_POST['checkboxValues'], true);
    $textData = json_decode($_POST['textValues'], true);
    $mergedData = array_merge($radioData, $checkboxData);    
    //$data = json_decode($_POST['textValues']);
    radioString($mergedData,$amc_ref_no,$contract_type,$customer_code,$main_customer_name,$current_date,$cutomerName,$customerEmail,$customerPhone,$category);
    //echo "Text value : ".$_POST['textValues'];
    textString($textData,$amc_ref_no,$contract_type,$customer_code,$main_customer_name,$current_date,$cutomerName,$customerEmail,$customerPhone,$category);
    
}

function radioString($data,$amc_ref_no,$contract_type,$customer_code,$main_customer_name,$current_date,$cutomerName,$customerEmail,$customerPhone,$category)
{
    // Check if decoding was successful
        if ($data !== null) {
            // Iterate over each item in the array
            foreach ($data as $item) {
                // Check if the "value" is not null
                if ($item['value'] !== null) {
                    // Access the "value" and "question_id" properties
                    $value = $item['value'];
                    $questionId = $item['question_id'];
        
                    // Sanitize input values
                    $sanitizedValues = [
                        'amc_ref_no' => $amc_ref_no,
                        'contract_type' => $contract_type,
                        'customer_code' => $customer_code,
                        'main_customer_name' => $main_customer_name,
                        'customer_name' => $cutomerName,
                        'customer_email' => $customerEmail,
                        'customer_phone' => $customerPhone,
                        'current_date' => $current_date,
                        'question_id' => $questionId,
                        'option_id' => $value,
                        'category_id' => $category,
                        
                    ];
        
                    // Build a string for each row
                    $insertValues[] = '(' . implode(', ', array_map(function($value) {
                        // Quote and escape each value
                        return "'" . addslashes($value) . "'";
                    }, $sanitizedValues)) . ')';
                }
            }
            if (!empty($insertValues)) {
                // Concatenate the values and build the final INSERT statement
                $insertQuery = "INSERT INTO feedback_responses (amc_ref_no, contract_type, customer_code, main_customer_name,customer_name,customer_email,customer_phone, default_date, question_id, option_id,category_id) VALUES " . implode(', ', $insertValues);
                 //echo $insertQuery;
                 $DBConn1 = new DBConnection();
                 $varDBConnection1 = $DBConn1->ConnectToMYSQL();
                if ($varDBConnection1->query($insertQuery) === TRUE) {
                    echo "Success";
                } else {
                    echo "Error: " . $insertQuery . "<br>" . $varDBConnection1->error;
                }
                
                // Close the database connection
                // $varDBConnection->close();  
                // Now, you can use $insertQuery to insert into the database
               
            } else {
                echo "No valid values to insert.\n";
            }
                
                
                
        } else {
            // Handle JSON decoding error
            echo "Error decoding JSON\n";
        }

}

function textString($data,$amc_ref_no,$contract_type,$customer_code,$main_customer_name,$current_date,$cutomerName,$customerEmail,$customerPhone,$category)
{
    if ($data !== null) {
        foreach ($data as $item) {
                if ($item['value'] !== null) {
                    // Access the "value" and "question_id" properties
                    $value = $item['value'];
                    $questionId = $item['question_id'];
        
                    // Sanitize input values
                    $sanitizedValues = [
                        'amc_ref_no' => $amc_ref_no,
                        'question_id' => $questionId,
                        'response_text' => $value,
                        'category_name' => $contract_type,
                        'main_customer_code' => $customer_code,
                        'main_customer_name' => $main_customer_name,
                        'customer_name' => $cutomerName,
                        'customer_phone' => $customerEmail,
                        'customer_email' => $customerPhone,
                        'default_date' => $current_date,
                        'category_id' => $category,
                    ];
        
                    // Build a string for each row
                    $insertValues[] = '(' . implode(', ', array_map(function($value) {
                        // Quote and escape each value
                        return "'" . addslashes($value) . "'";
                    }, $sanitizedValues)) . ')';
                }
        }
        if (!empty($insertValues)) {
                // Concatenate the values and build the final INSERT statement
               //echo implode(', ', $insertValues);
                $insertQuery = "INSERT INTO feedback_text_responses(amc_no,question_id,response_text,category_name,main_customer_code,main_customer_name,customer_name,customer_phone,customer_email,default_date,category_id) VALUES " . implode(', ', $insertValues);
                 //echo $insertQuery;
                 $DBConn1 = new DBConnection();
                 $varDBConnection1 = $DBConn1->ConnectToMYSQL();
                if ($varDBConnection1->query($insertQuery) === TRUE) {
                    echo "Success";
                } else {
                    echo "Error: " . $insertQuery . "<br>" . $varDBConnection1->error;
                }
                
                // Close the database connection
                // $varDBConnection->close();  
                // Now, you can use $insertQuery to insert into the database
               
            } else {
                echo "Failed";
            }
        
        
        
        
    }
}
?>