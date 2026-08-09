<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select user_type_id,user_type_name from tbl_user_types where user_type_status='Active'");
	
			
	
?>


<div class="col-lg-4 col-md-4 col-sm-12" id="div_employee_select">
    	<span class="form-text text-muted font-weight-bold"><font color="black">Employee Type&nbsp;<span style="color:red;">*</span></font></span>	
     <select data-placeholder="Select Employee Type" id="select_employee_type" class="form-control form-control-select2" data-fouc tabindex=16>
         <option value="select">Select</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['user_type_id']; ?>"><?PHP echo $row['user_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     
</div>