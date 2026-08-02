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
// Process submitted feedback and store it in the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection established
    // For example, you can use PDO or MySQLi

    foreach ($_POST as $key => $value) {
        // Check if the input field corresponds to a question
        if (strpos($key, 'question_') === 0) {
            $questionId = intval(substr($key, strlen('question_')));
            $optionId = intval($value);
            $userId = 1; // Replace with your user authentication logic

            // Insert the response into the database
            $pdo->prepare("INSERT INTO feedback_responses (question_id, option_id, user_id) VALUES (?, ?, ?)")
                ->execute([$questionId, $optionId, $userId]);
        }
    }

    echo "Feedback submitted successfully!";
} else {
    header("Location: index.php");
    exit();
}
?>
