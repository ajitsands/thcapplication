<?PHP include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select customer_id,customer_name from tbl_customers where customer_status='Active'");
		
?>


	
     <select data-placeholder="Select Customer" id="select_customer" class="form-control form-control-select2" data-fouc tabindex=1>
         <option value="Select Customer">Select Customer</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['customer_id']; ?>"><?PHP echo $row['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"></span>
