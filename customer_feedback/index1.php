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

// Retrieve questions and options from the database
$questions = $pdo->query("SELECT * FROM feedback_questions")->fetchAll(PDO::FETCH_ASSOC);
$options = $pdo->query("SELECT * FROM feedback_options")->fetchAll(PDO::FETCH_ASSOC);

// Display the feedback form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
</head>
<body>
    <form action="submit_feedback1.php" method="post">
        <?php foreach ($questions as $question): ?>
            <p><?= $question['question_text']; ?></p>
            <?php if ($question['type'] == 'radio'): ?>
                <?php foreach ($options as $option): ?>
                    <?php if ($option['question_id'] == $question['id']): ?>
                        <label>
                            <input type="radio" name="question_<?= $question['id']; ?>" value="<?= $option['id']; ?>">
                            <?= $option['option_text']; ?>
                        </label><br>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php elseif ($question['type'] == 'checkbox'): ?>
                <?php foreach ($options as $option): ?>
                    <?php if ($option['question_id'] == $question['id']): ?>
                        <label>
                            <input type="checkbox" name="question_<?= $question['id']; ?>[]" value="<?= $option['id']; ?>">
                            <?= $option['option_text']; ?>
                        </label><br>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php elseif ($question['type'] == 'text'): ?>
                <label>
					<?= $option['option_text']; ?><br>
                    <input type="text" name="question_<?= $question['id']; ?>">
                </label><br>
            <?php endif; ?>
            <hr>
        <?php endforeach; ?>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
