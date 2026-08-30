<?php
require_once __DIR__ . '/../model/db_connection/connection.php';
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve questions
$sql = "SELECT * FROM feedback_questions WHERE status='Active'";
$result = mysqli_query($conn, $sql);

$counts = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($question = mysqli_fetch_assoc($result)) {
        $questionId = $question['id'];
        $options = [];

        if ($question['type'] !== 'text') {
            $options_query = mysqli_query($conn, "SELECT * FROM feedback_options WHERE question_id = $questionId");
            while ($option = mysqli_fetch_assoc($options_query)) {
                $options[] = $option;
            }
        }

        foreach ($options as $option) {
            $optionCount = 0;

            if ($question['type'] == 'text') {
                $text_count_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM feedback_text_responses WHERE question_id = $questionId");
                $text_count = mysqli_fetch_assoc($text_count_query);
                $optionCount = $text_count['count'];
            } elseif ($question['type'] == 'checkbox' || $question['type'] == 'radio') {
                $option_id = $option['id'];
                $option_count_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM feedback_responses WHERE question_id = $questionId AND option_id = $option_id");
                $option_count = mysqli_fetch_assoc($option_count_query);
                $optionCount = $option_count['count'];
            }

            $counts[$questionId][] = [
                'question_text' => $question['question_text'],
                'option_text' => $option['option_text'],
                'count' => $optionCount,
            ];
        }

        if ($question['type'] == 'text') {
            $textResponseCountQuery = mysqli_query($conn, "SELECT COUNT(*) as count FROM feedback_text_responses WHERE question_id = $questionId");
            $textResponseCount = mysqli_fetch_assoc($textResponseCountQuery);
            $counts[$questionId][] = [
                'question_text' => $question['question_text'],
                'option_text' => 'Text Response',
                'count' => $textResponseCount['count'],
            ];

            $textResponsesQuery = mysqli_query($conn, "SELECT response_text FROM feedback_text_responses WHERE question_id = $questionId");
            $textResponses = [];
            while ($row = mysqli_fetch_assoc($textResponsesQuery)) {
                $textResponses[] = $row['response_text'];
            }
            // Now $textResponses contains the text responses for this question
        }
    }
  
}


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
        .card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>
    
 <?php if ($result && mysqli_num_rows($result) > 0 && !empty($counts))  { ?>    
    
    <h2>Feedback Report</h2>
    <?php 
    date_default_timezone_set('Asia/Bahrain');
    $toddate = date('Y-m-d');
    ?>
    <p>
        <a href="../view/customer_feedback_graph.php?param=<?php echo urlencode('head=feedback&open=2&title=feedback');?>&start_date=<?php echo $toddate;?>&end_date=<?php echo $toddate;?>&cust_id=All&cust_name=All&cat_val=All&cat_text=All" target="_blank" type="button" id="btn_search_tickets" class="btn bg-info legitRipple ladda-button" tabindex="4" data-style="expand-right" style="float: right;">Feedback Graph</a>
    </p>
    <p></p>

    <table>
        <?php foreach ($counts as $questionId => $questionData): ?>
            <tr>
                <th colspan="2"><?= $questionData[0]['question_text']; ?></th>
            </tr>
            <tr>
                <th width="50%">Option</th>
                <th>Count</th>
            </tr>
            <?php foreach ($questionData as $count): ?>
                <tr>
                    <td><?= $count['option_text']; ?></td>
                    <td>
                        <span><?= $count['count']; ?></span>
                        <?php if($count['option_text']=='Text Response'): ?>
                            &nbsp;&nbsp;<span id="google_sentimentals">Loading sentiments please wait...!</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
<?php } else { ?>    
    <div class="card">
        <div class="text-danger">No data available</div>
    </div>
<?php }  ?>    
</body>
</html>
<?php mysqli_close($conn); ?>