<?php
// Assuming you have a MySQLi connection, replace the placeholders below with your actual database connection details
$servername = "localhost";
$username = "sianlab_thc_user";
$password = "s@nds1@b";
$dbname = "sianlab_db_thc";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct values for amc_ref_no column
$queryAmcRefNo = "SELECT DISTINCT amc_ref_no FROM feedback_responses";
$resultAmcRefNo = $conn->query($queryAmcRefNo);

// Fetch distinct values for contract_type column
$queryContractType = "SELECT DISTINCT contract_type FROM feedback_responses";
$resultContractType = $conn->query($queryContractType);

// Close the database connection
$conn->close();
?>



<div class="col-md-12" >
		<div class="card" >
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Feedback Search
						    </h5>
						
					</div>
					
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
										<div class="col-lg-16 col-md-6 col-sm-12" >
										    <label for="amc_ref_no">AMC Ref No:</label>
										    <select class="form-control form-control-select2" id="amc_ref_no">
										      <?php
                                                while ($row = $resultAmcRefNo->fetch_assoc()) {
                                                    echo "<option value='" . $row['amc_ref_no'] . "'>" . $row['amc_ref_no'] . "</option>";
                                                }
                                                ?>
									        </select>
										    
										    
										    
										    
										    
										     
                                            
                                           
    									</div>
    								    <div class="col-lg-16 col-md-6 col-sm-12" >
										     
                                           <label for="contract_type">Contract Type:</label>
                                            <select class="form-control form-control-select2" id="contract_type">
                                                <?php
                                                while ($row = $resultContractType->fetch_assoc()) {
                                                    echo "<option value='" . $row['contract_type'] . "'>" . $row['contract_type'] . "</option>";
                                                }
                                                ?>
                                            </select>
    									</div>
								
								</div>
								
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-6">
									</div>
									
    									<div class="col-lg-6 col-md-6 col-sm-6">
    										<button type="button" id="btn_feedback_search" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Search</button>
    											</div>
						              
								   
								
								</div>
					</div>
				</div>
				
				    
			    </div>	
					
					
	</div>

</div>

