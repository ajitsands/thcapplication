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

date_default_timezone_set('Asia/Bahrain');
$current_date = date("Y-m-d h:i:s");

if ($_POST['action'] == 'insert_feedback') {
    // Decode JSON strings into associative arrays
    $radioData = json_decode($_POST['radioValues'], true);
    $checkboxData = json_decode($_POST['checkboxValues'], true);
    $textData = json_decode($_POST['textValues'], true);

    // Check if decoding was successful
    if ($radioData !== null && $checkboxData !== null && $textData !== null) {
        // Retrieve the maximum form_number from the table
        $maxFormNumberQuery = "SELECT MAX(form_number) AS max_form_number FROM tbl_customer_feedback_details";
        $result = $varDBConnection->query($maxFormNumberQuery);

        if ($result !== false) {
            $row = $result->fetch_assoc();
            $maxFormNumber = ($row['max_form_number'] !== null) ? $row['max_form_number'] + 1 : 1;

            // Build the combined insert string
            $combinedStr = '';
            $combinedStrAnalysis = '';
            
            // Process radioData
            if (!empty($radioData)) {
                $combinedStr .= buildInsertString($radioData, $cutomerName, $customerEmail, $customerPhone, $maxFormNumber, $current_date, $amc_ref_no, $contract_type, $customer_code, $main_customer_name);
            }

            // Process checkboxData
            if (!empty($checkboxData)) {
                $combinedStr .= buildInsertString($checkboxData, $cutomerName, $customerEmail, $customerPhone, $maxFormNumber, $current_date, $amc_ref_no, $contract_type, $customer_code, $main_customer_name);
            }

            // Process textData
            if (!empty($textData)) {
                $combinedStr .= buildInsertString($textData, $amc_ref_no, $cutomerName, $customerEmail, $customerPhone, $contract_type, $customer_code, $main_customer_name);
                //$combinedStrAnalysis = buildStringAnalysis($textData, $maxFormNumber, $cutomerName, $customerEmail, $customerPhone, $amc_ref_no, $customer_code, $current_date);
            }

            // Remove the trailing comma
            $combinedStr = rtrim($combinedStr, ',');
            //$combinedStrAnalysis = rtrim($combinedStrAnalysis, ',');

            // Example: Insert combined data into the database
            $combinedSql = "INSERT INTO feedback_text_responses (question_id, response_text, customer_email, customer_phone, form_number,default_date,amc_ref_no,contract_type,main_customer_code,main_customer_name) VALUES $combinedStr ";
            if ($varDBConnection->query($combinedSql) !== TRUE) {
                echo "Error inserting combined data: " . $varDBConnection->error;
            }
            
            // $insertSqlAnalysis = "INSERT INTO tbl_feedback_response_text(question_id, form_number, response_text, customer_name, customer_email, customer_phone, amc_ref_no, main_customer_code, default_date) VALUES $combinedStrAnalysis ";
            
            // if ($varDBConnection->query($insertSqlAnalysis) !== TRUE) {
            //     echo "Error inserting combined data for Sentimental Analysis : " . $varDBConnection->error;
            // }
            
        } else { 
            echo "Error retrieving max form_number: " . $varDBConnection->error;
        }

    } else {
        // Handle JSON decoding error
        echo 'Error decoding JSON';
    }
}

// Close the database connection 
$varDBConnection->close();

function buildInsertString($data, $customerName, $customerEmail, $customerPhone, $formNumber, $current_date, $amc_ref_no, $contract_type, $customer_code, $main_customer_name) {
    // Iterate over the array
    $str = '';
    foreach ($data as $item) {
        $value = $item['value'];
        $question_id = $item['question_id'];
        
        $str .= "($question_id, '$value', '$customerName', '$customerEmail', '$customerPhone', $formNumber, '$current_date', '$amc_ref_no', '$contract_type', '$customer_code', '$main_customer_name'),";
    }
    
    // Add a row with null values if $data is empty
    if (empty($data)) {
        $str .= "(NULL, NULL, '$customerName', '$customerEmail', '$customerPhone', $formNumber, '$current_date', '$amc_ref_no', '$contract_type', '$customer_code', '$main_customer_name'),";
    }

    return $str;
}

function buildStringAnalysis($responses, $formNumber, $customerName, $customerEmail, $customerPhone, $amc_ref_no, $customer_code, $current_date)
{
    $string = '';
    foreach($responses as $response){
        $data = $response['value'];
        $qID = $response['question_id'];
        $string .="($qID, $formNumber, '$data', '$customerName', '$customerEmail', '$customerPhone', '$amc_ref_no', '$customer_code', '$current_date'),";
    }
    return $string;
}

?>