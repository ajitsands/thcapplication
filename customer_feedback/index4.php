<?php
include "../model/db_connection/connection.php";
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cutomerName = $_GET['customerName'];
$customerEmail = $_GET['email'];
$customerPhone = $_GET['phoneNumber'];

$amc_ref_no = $_GET['amc_ref_no'];
$contract_type = $_GET['contract_type'];
$customer_code = $_GET['customer_code'];
$main_customer_name = $_GET['customer_name'];

$result_amc_details = mysqli_query($varDBConnection, "SELECT * FROM tbl_customer_feedback WHERE question_status='Active'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Customer Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        .btn-primary {
            background-color: #2e2e79;
            color: white;
            font-size: 40px;
            width: 100%;
        }

        .btn-check:focus + .btn-primary {
            background-color: #2e2e79;
            color: white;
        }

        .btn-check:checked + .btn-primary {
            background-color: green;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            font-size: 30px;
            font-weight: 700;
        }

        .question-options {
            padding-top: 20px;
        }

        .question-options .btn-check {
            margin-bottom: 20px;
        }

        .comment-textarea {
            padding-top: 20px;
        }

        #submitBtn {  
            font-size: 40px;
            font-weight: bold;
            color: #fff;
            background-color: #2e2e79;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        /*.custom-submit-btn {*/
        /*    text-decoration: none;*/
        /*    padding: 15px 30px;*/
        /*    font-size: 60px;*/
        /*    font-weight: bold;*/
        /*    color: #fff;*/
        /*    background-color: #2e2e79;*/
        /*    border: none;*/
        /*    border-radius: 5px;*/
        /*    cursor: pointer;*/
        /*}*/
    </style>
</head>
<body style="font-size: 25px;">
<div class="container-lg">
    <div class="row" style="padding: 10px;">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <img src="https://sianlab.com/thc/view/global_assets/images/logo_print.png" height="200" alt="...">
        </div>
        <div class="col-12 d-flex align-items-center justify-content-center">
            <span style="font-size: 50px; font-weight: 700;">Customer Feedback</span>
        </div>
    </div>

    <?php
    $questionNumber = 1;
    while ($row_amc_details = mysqli_fetch_assoc($result_amc_details)) {
        $question_name = $row_amc_details['question_name'];
        $question_type = $row_amc_details['question_type'];
        $question_id = $row_amc_details['question_id'];

        switch ($question_type) {
            case 'Single Selection':
                displaySingleSelection($questionNumber, $question_id, $question_name, $row_amc_details);
                break;
            case 'Multiple Selection':
                displayMultipleSelection($questionNumber, $question_id, $question_name, $row_amc_details);
                break;
            case 'Text':
                displayTextQuestion($questionNumber, $question_id, $question_name);
                break;
            default:
                // Handle other question types if needed
                break;
        }

        $questionNumber++;
    }

    function displaySingleSelection($questionNumber, $question_id, $question_name, $row_amc_details)
    {
        $options = array($row_amc_details['q1'], $row_amc_details['q2'], $row_amc_details['q3'], $row_amc_details['q4'], $row_amc_details['q5'], $row_amc_details['q6']);
        ?>
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="card-body">
                <div class="question">
                    <h1 class="card-header"><?php echo $questionNumber . '. ' . $question_name; ?></h1>
                    <div class="question-options card-footer">
                        <div class="row">
                            <?php
                            foreach ($options as $index => $option) {
                                ?>
                                <div class="col-2">
                                    <input type="radio"
                                           class="btn-check"
                                           name="<?php echo 'question_' . $question_id . '_' . $questionNumber; ?>"
                                           id="<?php echo 'q' . $question_id . '_' . $questionNumber . '_option' . $index; ?>"
                                           data-question-id="<?php echo $question_id; ?>" 
                                           value="<?php echo $option; ?>"
                                           autocomplete="off">
                                    <label class="btn btn-primary"
                                           for="<?php echo 'q' . $question_id . '_' . $questionNumber . '_option' . $index; ?>"
                                           style="font-size: 60px;"><i class="bi bi-<?php echo $index + 1; ?>-circle"></i></label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    function displayMultipleSelection($questionNumber, $question_id, $question_name, $row_amc_details)
    {
        $options = array($row_amc_details['q1'], $row_amc_details['q2'], $row_amc_details['q3'], $row_amc_details['q4'], $row_amc_details['q5'], $row_amc_details['q6']);
        ?>
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="card-body">
                <div class="question">
                    <h1 class="card-header"><?php echo $questionNumber . '. ' . $question_name; ?></h1>
                    <div class="question-options card-footer">
                        <div class="row">
                            <?php
                            foreach ($options as $index => $option) {
                                ?>
                                <div class="col-12" style="padding-top:20px;">
                                    <input type="checkbox"
                                           class="btn-check"
                                           id="<?php echo 'q' . $question_id . '_option' . $index; ?>"
                                           data-question-id="<?php echo $question_id; ?>" 
                                           value="<?php echo $option; ?>"
                                           autocomplete="off">
                                    <label class="btn btn-primary"
                                           for="<?php echo 'q' . $question_id . '_option' . $index; ?>"
                                           style="font-size: 40px;width:100%;"><i class="bi bi-check"></i> <?php echo $option; ?></label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    function displayTextQuestion($questionNumber, $question_id, $question_name)
    {
        ?>
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="card-body">
                <div class="question">
                    <h1 class="card-header"><?php echo $questionNumber . '. ' . $question_name; ?></h1>
                    <div class="comment-textarea card-footer">
                        <div class="row">
                            <div class="col-12">
                                <label for="<?php echo 'q' . $question_id . '_' . $questionNumber . '_comment'; ?>"
                                       class="form-label">Write your comment below</label>
                                <textarea class="form-control"
                                          id="<?php echo 'q' . $question_id . '_' . $questionNumber . '_comment'; ?>"
                                          data-question-id="<?php echo $question_id; ?>"
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

   <div class="col-12 d-flex align-items-center justify-content-center">
        <button class="btn btn-lg" id="submitBtn" style="padding: 15px 30px;">
            Submit Feedback
        </button>
    </div>
    <br>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 
    <script>
        $(document).ready(function () {
            // Click event for the submit button
      
         $('#submitBtn').click(function () {
            
           var cutomerName = '<?PHP echo $cutomerName ;?>';
           var customerEmail = '<?PHP echo $customerEmail ;?>';
           var customerPhone = '<?PHP echo $customerPhone ;?>';
           
           var amc_ref_no = '<?PHP echo $amc_ref_no ; ?>';
           var contract_type = '<?PHP echo $contract_type ; ?>';
           var customer_code = '<?PHP echo $customer_code ; ?>';
           var main_customer_name = '<?PHP echo $main_customer_name ; ?>';
           
            var radioValues = $('input[type=radio]:checked').map(function () {
                return {
                    value: $(this).val(),
                    question_id: $(this).data('question-id')
                };
            }).get();
        
            var checkboxValues = $('input[type=checkbox]:checked').map(function () {
                return {
                    value: $(this).val(),
                    question_id: $(this).data('question-id')
                };
            }).get();
        
            var textValues = $('textarea').map(function () {
                return {
                    value: $(this).val(),
                    question_id: $(this).data('question-id')
                };
            }).get();
        
            // Check for non-selected radio buttons
            $('input[type=radio]').each(function () {
                var question_id = $(this).data('question-id');
                if (!radioValues.some(item => item.question_id === question_id)) {
                    radioValues.push({
                        value: null,
                        question_id: question_id
                    });
                }
            });
        
            // Check for non-selected checkboxes
            $('input[type=checkbox]').each(function () {
                var question_id = $(this).data('question-id');
                if (!checkboxValues.some(item => item.question_id === question_id)) {
                    checkboxValues.push({
                        value: null,
                        question_id: question_id
                    });
                }
            });
        
            v_radioValues = JSON.stringify(radioValues);
            v_checkboxValues = JSON.stringify(checkboxValues);
            v_textValues = JSON.stringify(textValues);
            //alert(v_radioValues+'<br>'+v_checkboxValues+'<br>'+v_textValues) 
            // Display or process the values as needed
           $.post("feedback.php",{action:"insert_feedback",radioValues:v_radioValues,checkboxValues:v_checkboxValues,textValues:v_textValues,cutomerName:cutomerName,customerEmail:customerEmail,customerPhone:customerPhone,amc_ref_no:amc_ref_no,contract_type:contract_type,customer_code:customer_code,main_customer_name:main_customer_name},function(result){
               
               //window.location.href = "feedback_thank.php";
           })
           
        });
        });
    </script>
</body>
</html>
