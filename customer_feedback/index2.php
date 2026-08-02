<?PHP
include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cutomerName = $_GET['customerName'];
$customerEmail = $_GET['email'];
$customerPhone = $_GET['phoneNumber'];

    $result_amc_details = mysqli_query($varDBConnection, "SELECT * FROM tbl_customer_feedback WHERE question_status='Active'");

?>
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Customer Feedback</title>
	<link href="https://fonts.googleapis.com" rel="preconnect" />
	<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<style type="text/css">body,td,th {
    font-family:  'Montserrat', sans-serif;
    font-style: normal;
    font-size: 12px;
    color: #000000;
    
}

table, th, td {
    border: 1px solid #4E4E4E;
    border-collapse: collapse;
    padding: 5px;
}

@media print {
  div.divFooter {
    position: fixed;
    bottom: 0;
  }
  
  .divFooter {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #2e2e79;
        color: white;
        padding: 25px;
        box-sizing: border-box;
    }
	</style>
	
	<script src="../view/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
</head>
<body>
                             
<table align="center" style="border: none;" width="800">
	<tbody>
		<tr style="border: none; ">
			<td style="border: none;" width="400">
			    <img src="../view/global_assets/images/logo_print.png"  />
			</td>
			<td style="border: none; color: #daa505;text-align: right;font-weight:700;padding-right:20px;" width="400">
			 
			   
			   
			</td>
		</tr>
	 <!--   <tr style="border: none;padding-top:15px;">-->
		<!--	<td style="border: none;font-size: 25px;font-weight: 700;"><b>CUSTOMER FEEDBACK FORM </b></td>-->
			<!--<td style="text-align: right;border: none;"><b>Date &amp; Time:</b><?PHP echo $currentTime ; ?></td>-->
		<!--</tr>-->
		<!--<tr style="border: none;">-->
		<!--	<td style="border: none;"><?PHP //echo $amc_ref_no ; ?></td>-->
		<!--	<td style="border: none;"></td>-->
		<!--	<td style="text-align: right;border: none; font-size: 25px;font-weight: 700;"><b>AMC</b></td>-->
		<!--</tr>-->
	</tbody>
</table>

<table align="center" style="border: none;" width="800">
	<tbody>
		 <?php
            $questionNumber = 1;
            while ($row_amc_details = mysqli_fetch_assoc($result_amc_details)) {
                $question_name = $row_amc_details['question_name'];
                $question_type = $row_amc_details['question_type'];
                $question_id = $row_amc_details['question_id'];
        
                // Display based on question type
                switch ($question_type) {
                    case 'Single Selection':
                        displaySingleSelection($question_id,$questionNumber, $question_name, $row_amc_details);
                        break;
                    case 'Multiple Selection':
                        displayMultipleSelection($question_id,$questionNumber, $question_name, $row_amc_details);
                        break;
                    case 'Text':
                        displayTextQuestion($question_id,$questionNumber, $question_name);
                        break;
                    default:
                        // Handle other question types if needed
                        break;
                }
        
                $questionNumber++;
            }
            ?>
    
    
    
	</tbody>
</table>

<p></p>  
<p></p>

<table align="center" style="border: none;" width="800">
	<tbody>
	    <tr style="border: none;">
	        <td style="text-align: right; border: none; font-size: 25px; font-weight: 700;">
    <button class="btn bg-teal-400 legitRipple" style="text-decoration: none; padding: 10px 20px; font-size: 18px; font-weight: bold; color: #fff; background-color: #2e2e79; border: none; border-radius: 5px; cursor: pointer;" id="submitBtn">
        Submit Feedback
    </button>
</td>
			<td style="border: none;"><?PHP //echo $amc_ref_no ; ?></td>
			
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
			<td style="border: none;"></td>
		</tr>
    </tbody>
</table>

<p></p>

<p></p>

<!--<div class="divFooter">-->
<!--	<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: none; padding: 25px;" >-->
<!--	    <tr style="border: none; background-color: #2e2e79; padding: 25px;">-->
<!--			<td style="border: none;padding-left: 20px;color:white;" width="500">-->
<!--			    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>-->
<!--			     CR. <strong>88982-1</strong> | Level 14, Enterance 143/144,  Bldg 155, Road 1703, Block 317<br>-->
<!--			    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain-->
<!--			</td>-->
<!--			<td style="border: none;text-align: right;padding-right:20px;padding: 25px;" width="300">-->
			 
<!--			    <img src="../view/global_assets/images/a.png" />-->
			   
<!--			</td>-->
<!--		</tr>-->
<!--	</table>-->
<!--</div>-->
<p></p>

<p></p>

<script>
    $(document).ready(function () {
        // Click event for the submit button
       // Click event for the submit button
        $('#submitBtn').click(function () {
            
           var cutomerName = '<?PHP echo $cutomerName ;?>';
           var customerEmail = '<?PHP echo $customerEmail ;?>';
           var customerPhone = '<?PHP echo $customerPhone ;?>';
           
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
            v_radioValues = JSON.stringify(radioValues);
            v_checkboxValues = JSON.stringify(checkboxValues);
            v_textValues = JSON.stringify(textValues);
            // Display or process the values as needed
           // alert('Radio Value: ' + JSON.stringify(radioValues));
           $.post("feedback.php",{action:"insert_feedback",radioValues:v_radioValues,checkboxValues:v_checkboxValues,textValues:v_textValues,cutomerName:cutomerName,customerEmail:customerEmail,customerPhone:customerPhone},function(result){
               
               alert("Success");
           })
            // alert('Checkbox Values: ' + JSON.stringify(checkboxValues));
            // alert('Text Value: ' + JSON.stringify(textValues));
            
            
        });
    });
</script>

</body>
</html>
<?php
function displaySingleSelection($questionNumber, $question_id, $question_name, $row_amc_details)
{
    $options = array($row_amc_details['q1'], $row_amc_details['q2'], $row_amc_details['q3'], $row_amc_details['q4'], $row_amc_details['q5'], $row_amc_details['q6']);
    ?>
    <tr>
        <td colspan="7" style="border: none;">
            <?php echo $questionNumber . '. ' . $question_name; ?>
        </td>
    </tr>
    <tr>
        <?php
        foreach ($options as $index => $option) {
            ?>
            <td style="border: none;">
                <input type="radio"
                       name="<?php echo 'question_' . $question_id . '_' . $questionNumber; ?>"
                       value="<?php echo $option; ?>"
                       data-question-id="<?php echo $question_id; ?>"> <?php echo $option; ?>
            </td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <!-- Add a blank row for spacing -->
        <td colspan="7" style="border: none; height: 10px;"></td>
    </tr>
    <?php
}

function displayMultipleSelection($questionNumber, $question_id, $question_name, $row_amc_details)
{
    $options = array($row_amc_details['q1'], $row_amc_details['q2'], $row_amc_details['q3'], $row_amc_details['q4'], $row_amc_details['q5'], $row_amc_details['q6']);
    ?>
    <tr>
        <td colspan="7" style="border: none;">
            <?php echo $questionNumber . '. ' . $question_name; ?>
        </td>
    </tr>
    <tr>
        <?php
        foreach ($options as $index => $option) {
            ?>
            <td style="border: none;">
                <input type="checkbox"
                       name="<?php echo 'question_' . $question_id . '_' . $questionNumber . '[]'; ?>"
                       value="<?php echo $option; ?>"
                       data-question-id="<?php echo $question_id; ?>"> <?php echo $option; ?>
            </td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <!-- Add a blank row for spacing -->
        <td colspan="7" style="border: none; height: 10px;"></td>
    </tr>
    <?php
}

function displayTextQuestion($questionNumber, $question_id, $question_name)
{
    ?>
    <tr>
        <td colspan="7" style="border: none;">
            <?php echo $questionNumber . '. ' . $question_name; ?>
            <textarea name="<?php echo 'q' . $question_id . '_' . $questionNumber . '_comment'; ?>" rows="5"
                      placeholder="Enter your comments here..." style="width: 80%;"
                      data-question-id="<?php echo $question_id; ?>"></textarea>
        </td>
    </tr>
    <tr>
        <!-- Add a blank row for spacing -->
        <td colspan="7" style="border: none; height: 10px;"></td>
    </tr>
    <?php
}
?>