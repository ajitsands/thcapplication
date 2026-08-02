<?php
$host = 'localhost';
$dbname = 'sianlab_db_thc';
$user = 'sianlab_thc_user';
$password = 's@nds1@b';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Enable persistent connections
    $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // You may want to handle the error more gracefully in a production environment
    die();
}
?>
<?php
// Assuming you have a database connection established
// Include the database connection file

// Retrieve questions, options, and counts
$questions = $pdo->query("SELECT * FROM tbl_customer_feedback")->fetchAll(PDO::FETCH_ASSOC);

// Create an associative array to store the counts for each question, option, and text response
$counts = [];

// Populate the counts array
foreach ($questions as $question) {
    $options = [];

    if ($question['question_type'] !== 'Text') {
        $options = $pdo->query("SELECT * FROM tbl_customer_feedback WHERE question_id = {$question['question_id']}")->fetchAll(PDO::FETCH_ASSOC);
    }

    foreach ($options as $option) {
        $optionCount = 0;

        // Handle different question types
        if ($question['question_type'] == 'Text') {
            // For text questions, count the number of text responses
            $optionCount = $pdo->query("SELECT COUNT(*) FROM tbl_customer_feedback_details WHERE question_id = {$question['question_id']}")->fetchColumn();
        } elseif ($question['question_type'] == 'Multiple Selection' || $question['question_type'] == 'Single Selection') {
            // For checkbox and radio questions, count the number of selected options
            $optionCount = $pdo->query("SELECT COUNT(*) FROM tbl_customer_feedback_details WHERE question_id = {$question['question_id']}")->fetchColumn();
        }

        $counts[$question['id']][] = [
            'question_text' => $question['question_text'],
            'option_text' => $option['option_text'],
            'count' => $optionCount,
        ];
    }

    // Include counts for text responses only for 'text' type questions
    if ($question['type'] == 'text') {
        $textResponseCount = $pdo->query("SELECT COUNT(*) FROM feedback_text_responses WHERE question_id = {$question['id']}")->fetchColumn();
        $counts[$question['id']][] = [
            'question_text' => $question['question_text'],
            'option_text' => 'Text Response',
            'count' => $textResponseCount,
        ];
        
        
        $questionId = $question['question_id'];
        $query = "SELECT response_text FROM tbl_feedback_response_text  WHERE question_id = :questionId";
        echo "query is ".$query;
        //Prepare and execute the query
        $statement = $pdo->prepare($query);
        $statement->bindParam(':questionId', $questionId, PDO::PARAM_INT);
        $statement->execute();
        
        // Fetch all rows into an array
        $textResponses = $statement->fetchAll(PDO::FETCH_COLUMN);
        //echo print_r($textResponses);
    }
}

// Display the report in tables
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
    <style>
		 table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Feedback Report</h2>
	
	 <table>
    <?php foreach ($counts as $questionId => $questionData): ?>
			<tr >
                <th colspan="2" > <?= $questionData[0]['question_text']; ?></th>
                
            </tr>
       
       
            <tr>
                <th width="50%">Option</th>
				
                <th>Count</th>
            </tr>
            <?php foreach ($questionData as $count): ?>
                <tr>
                    <td><?= $count['option_text']; ?></td>
                    <td><span><?= $count['count']; ?></span><?php if($count['option_text']=='Text Response'){?>&nbsp;&nbsp;<span id="google_sentimentals">Loading sentiments please wait...!</span><?php } ?></td>
                </tr>
            <?php endforeach; ?>
        
    <?php endforeach; ?>
	</table>
</body>

</html>
