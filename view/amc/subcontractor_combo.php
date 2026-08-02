 <?PHP include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$result_customer = mysqli_query($varDBConnection,"SELECT * FROM  tbl_subcontractors WHERE subcontactor_status='Active'");
	
			
	
?>



	<span class="form-text text-muted font-weight-bold"><font color="black">Subcontractor&nbsp;<span style="color:red;">*</span></font></span>
	 <select data-placeholder="Select subcontractors" id="select_amc_subcontractors" class="form-control form-control-select2" tabindex=1>
    	<option value="select">Select Subcontractor</option>
        <?PHP 	while($row_customer=mysqli_fetch_assoc($result_customer)) { ?>
          <option value="<?PHP echo $row_customer['subcontractor_ids']; ?>"><?PHP echo $row_customer['subcontractor_name']; ?></option>
        
        <?PHP } ?>
    </select> 
