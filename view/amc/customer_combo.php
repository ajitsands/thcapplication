 <?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_customer = mysqli_query($varDBConnection,"Select customer_id,customer_name,customer_code from  tbl_customers where customer_status='Active'");
	
			
	
?>


<div class="col-lg-5 col-md-5 col-sm-11" style="padding-right:1px;" >
    	<span class="form-text text-muted font-weight-bold"><font color="black">Select Customer&nbsp;<span style="color:red;">*</span></font></span>	
     <select data-placeholder="Select Customer" id="select_customer_for_amc" class="form-control form-control-select2" data-fouc tabindex=1>
         <option value="select">Select Customer</option>
        <?PHP 	while($row_customer=mysqli_fetch_assoc($result_customer)) { ?>
          <option value="<?PHP echo $row_customer['customer_id']; ?>"><?PHP echo $row_customer['customer_code'].'-'.$row_customer['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     
</div>