<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select DISTINCT customer_id,customer_name from  tbl_quotation_master");
		
?>


<div class="col-lg-4 col-md-6 col-sm-12" id="div_customer_select">	
     <select data-placeholder="Select Customer" id="select_customer" class="form-control form-control-select2" data-fouc tabindex=3>
         <option value="SELECT CUSTOMER">SELECT CUSTOMER</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['customer_id']; ?>"><?PHP echo $row['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">CUSTOMER NAME&nbsp;<span style="color:red;">*</span></font></span>
</div>