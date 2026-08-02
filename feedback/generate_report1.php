<?php
$host = 'localhost';
$dbname = 'sandsl23_feedback';
$user = 'sandsl23_feedback_user';
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
$questions = $pdo->query("SELECT * FROM feedback_questions")->fetchAll(PDO::FETCH_ASSOC);

// Create an associative array to store the counts for each question, option, and text response
$counts = [];

// Populate the counts array
foreach ($questions as $question) {
    $options = [];

    if ($question['type'] !== 'text') {
        $options = $pdo->query("SELECT * FROM feedback_options WHERE question_id = {$question['id']}")->fetchAll(PDO::FETCH_ASSOC);
    }

    foreach ($options as $option) {
        $optionCount = 0;

        // Handle different question types
        if ($question['type'] == 'text') {
            // For text questions, count the number of text responses
            $optionCount = $pdo->query("SELECT COUNT(*) FROM feedback_text_responses WHERE question_id = {$question['id']}")->fetchColumn();
        } elseif ($question['type'] == 'checkbox' || $question['type'] == 'radio') {
            // For checkbox and radio questions, count the number of selected options
            $optionCount = $pdo->query("SELECT COUNT(*) FROM feedback_responses WHERE question_id = {$question['id']} AND option_id = {$option['id']}")->fetchColumn();
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
        
        
        $questionId = $question['id'];
        $query = "SELECT response_text FROM feedback_text_responses WHERE question_id = :questionId";
        
        // Prepare and execute the query
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $.post('sentiment_analysis_google.php',{arrayval : <?php echo json_encode($textResponses); ?> }, function(res){
           $('#google_sentimentals').html(res);
        });
    });
    
</script>
</html>
