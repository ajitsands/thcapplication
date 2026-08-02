<?php
$host = 'localhost';
$dbname = 'feedback';
$user = 'root';
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

// Create an associative array to store the counts for each question and option
$counts = [];

// Populate the counts array
foreach ($questions as $question) {
    $options = $pdo->query("SELECT * FROM feedback_options WHERE question_id = {$question['id']}")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($options as $option) {
        $optionCount = $pdo->query("SELECT COUNT(*) FROM feedback_responses WHERE question_id = {$question['id']} AND option_id = {$option['id']}")->fetchColumn();
        $counts[$question['id']][] = [
            'question_text' => $question['question_text'],
            'option_text' => $option['option_text'],
            'count' => $optionCount,
        ];
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
			<tr>
                <th colspan="2"> <h4><?= $questionData[0]['question_text']; ?></h4></th>
                
            </tr>
       
       
            <tr>
                <th>Option</th>
				
                <th>Count</th>
            </tr>
            <?php foreach ($questionData as $count): ?>
                <tr>
                    <td><?= $count['option_text']; ?></td>
                    <td><?= $count['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        
    <?php endforeach; ?>
	</table>
</body>
</html>
