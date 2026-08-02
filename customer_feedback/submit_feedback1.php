<?php
// Assuming you have a database connection established
// For example, you can use PDO or MySQLi

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

// Assuming you have a database connection established
// Include the database connection file or set up the connection here

// Process submitted feedback and store it in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        foreach ($_POST as $key => $value) {
            // Check if the input field corresponds to a question
            if (strpos($key, 'question_') === 0) {
                $questionId = intval(substr($key, strlen('question_')));
                $userId = 1; // Replace with your user authentication logic

                // Handle different question types
                if ($value !== '') {
                    // Check if the question is of type 'text'
                    $questionType = $pdo->query("SELECT type FROM feedback_questions WHERE id = $questionId")->fetchColumn();

                    if ($questionType == 'text') {
                        // For text questions, store in feedback_responses table
                        $pdo->prepare("INSERT INTO feedback_text_responses (question_id, response_text, user_id) VALUES (?, ?, ?)")
                            ->execute([$questionId, $value, $userId]);
                    } elseif (is_array($value)) {
                        // For checkboxes, $value is an array of selected options
                        foreach ($value as $optionId) {
                            $pdo->prepare("INSERT INTO feedback_responses (question_id, option_id, user_id) VALUES (?, ?, ?)")
                                ->execute([$questionId, $optionId, $userId]);
                        }
                    } else {
                        // For radio buttons, $value is a single option
                        $pdo->prepare("INSERT INTO feedback_responses (question_id, option_id, user_id) VALUES (?, ?, ?)")
                            ->execute([$questionId, $value, $userId]);
                    }
                }
            }
        }

        echo "Feedback submitted successfully!";
    } catch (PDOException $e) {
        // Output error message and details
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit();
}
?>




