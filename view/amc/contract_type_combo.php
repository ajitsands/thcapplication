<?PHP //include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_contract_type = mysqli_query($varDBConnection,"Select contract_type_id,contract_type_name from  tbl_contract_types where contract_type_status='Active'");
	
			
	
?>


<div class="col-lg-5 col-md-5 col-sm-11" style="padding-right:1px;">
    	<span class="form-text text-muted font-weight-bold"><font color="black">Contract Type&nbsp;<span style="color:red;">*</span></font></span>	
     <select data-placeholder="Select Contract Type" id="select_contract_type_for_amc" class="form-control form-control-select2" data-fouc tabindex=2>
         <option value="select">Contract Type</option>
        <?PHP 	while($row_contract_type=mysqli_fetch_assoc($result_contract_type)) { ?>
          <option value="<?PHP echo $row_contract_type['contract_type_id']; ?>"><?PHP echo $row_contract_type['contract_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     
</div>