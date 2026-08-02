<?php

  include(__DIR__ . '/../model/db_connection/connection.php');
  $connection = new DBConnection();
  $conn = $connection->ConnectToMYSQL();

  $sqlQuery = "SELECT question_id, response_text FROM tbl_feedback_response_text WHERE form_number='".$_GET['fromNumber']."'";

  $results = mysqli_query($conn, $sqlQuery);
  
?>
<div class="card mt-3">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            Customers Feedback Analysis
        </h5>
    </div>
    <div class="card-body">
        
<?php  
 
  $data = array();
  while($rows=mysqli_fetch_assoc($results))
  {
      $arrayDataText = $rows['response_text'];
      $arrayDataQus = $rows['question_id'];
     
      $data[] = $arrayDataText;
            
      $newQuery = "SELECT question_id, question_name FROM tbl_customer_feedback WHERE question_id = $arrayDataQus";
      $newResults = mysqli_query($conn, $newQuery);
      while ($newRows = mysqli_fetch_assoc($newResults)) { ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
				<span class="form-text font-weight-bold sentiment-analysis"><font color="black"><?php echo $newRows['question_name'];  ?></font></span>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6">
				<span class="form-text font-weight-bold sentiment-analysis" id=""><font color="black">Loading Result, Please wait...</font></span>
			</div>
        </div>
        
<?php  }

  }
 
?>
    </div>
</div>
<div id="google_sentimentals"></div>
