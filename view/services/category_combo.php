<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select category_id,category_name from  tbl_category where category_status='Active'");
	
			
	
?>


<div class="col-lg-6 col-md-6 col-sm-12" id="div_employee_select">	
<span class="form-text text-muted font-weight-bold"><font color="black">Category Type&nbsp;<span style="color:red;">*</span></font></span>
     <select data-placeholder="Select Category Type" id="select_category_type_for_service" class="form-control form-control-select2" data-fouc tabindex=1>
         <option value="select">Select Category Type</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['category_id']; ?>"><?PHP echo $row['category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
</div>