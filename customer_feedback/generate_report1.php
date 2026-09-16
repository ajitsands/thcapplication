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

<?php if ($result && mysqli_num_rows($result) > 0 && !empty($counts)) { ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Feedback Report</h5>
                <div class="header-elements">
                    <?php 
                    date_default_timezone_set('Asia/Bahrain');
                    $toddate = date('Y-m-d');
                    ?>
                    <a href="../view/customer_feedback_graph.php?param=<?php echo urlencode('head=feedback&open=2&title=feedback');?>&start_date=<?php echo $toddate;?>&end_date=<?php echo $toddate;?>&cust_id=All&cust_name=All&cat_val=All&cat_text=All" target="_blank" id="btn_search_tickets" class="btn btn-primary">
                        <i class="icon-stats-dots mr-2"></i> Feedback Graph
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <?php foreach ($counts as $questionId => $questionData): ?>
                        <tr class="bg-light">
                            <th colspan="2" class="font-weight-bold font-size-lg"><?= htmlspecialchars($questionData[0]['question_text']); ?></th>
                        </tr>
                        <tr>
                            <th width="50%" class="font-weight-semibold">Option</th>
                            <th class="font-weight-semibold">Count</th>
                        </tr>
                        <?php foreach ($questionData as $count): ?>
                            <tr>
                                <td><?= htmlspecialchars($count['option_text']); ?></td>
                                <td>
                                    <span class="badge badge-success font-size-sm"><?= $count['count']; ?></span>
                                    <?php if($count['option_text'] == 'Text Response'): ?>
                                        <span class="ml-3 text-muted font-italic" id="google_sentimentals">Loading sentiments please wait...!</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>    
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-danger text-center font-weight-bold">
                No data available
            </div>
        </div>
    </div>
</div>
<?php } ?>    

<?php mysqli_close($conn); ?>