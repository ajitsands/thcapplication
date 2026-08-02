 <?PHP //include "../model/db_connection/connection.php" ;
//$DBConn = new DBConnection();
//$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_customer = mysqli_query($varDBConnection,"Select customer_id,customer_name,customer_code from  tbl_customers where customer_status='Active'");
	
			
	
?>


<div class="col-lg-4 col-md-6 col-sm-12" style="padding-right:1px;">	
     <select data-placeholder="Select Customer" id="select_customer_for_amc" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Customer</option>
        <?PHP 	while($row_customer=mysqli_fetch_assoc($result_customer)) { ?>
          <option value="<?PHP echo $row_customer['customer_id']; ?>"><?PHP echo $row_customer['customer_code'].'-'.$row_customer['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Select Customer&nbsp;<span style="color:red;">*</span></font></span>
</div>