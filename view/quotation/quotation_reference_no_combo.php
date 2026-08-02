<?PHP include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select quotation_id,quotation_ref_no from tbl_quotation_master_riv group by quotation_ref_no");
		
?>


<div class="col-lg-4 col-md-6 col-sm-6" id="div_quotation_number_select">	
     <select data-placeholder="Select Quotation Number" id="select_quotation_rivision_no" class="form-control form-control-select2" data-fouc tabindex=1>
         <option value="SELECT QUOTATION NUMBER">SELECT QUOTATION NUMBER</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['quotation_id']; ?>"><?PHP echo $row['quotation_ref_no']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">QUOTATION NUMBER&nbsp;<span style="color:red;">*</span></font></span>
</div>