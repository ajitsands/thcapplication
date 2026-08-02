<?PHP  
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();


$result_customer = mysqli_query($varDBConnection,"select customer_id,customer_name,customer_code from  tbl_customers where customer_status='Active'");
 	


 	
?>

<span class="form-text text-muted font-weight-bold"><font color="black">Customer &nbsp;<span style="color:red;">*</span></font></span>    

     <select data-placeholder="Select customer" id="select_asset_customer" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Customer</option>
         <option value="All">All</option>
        <?PHP 	while($row_customer=mysqli_fetch_assoc($result_customer)) { ?>
          <option value="<?PHP echo $row_customer['customer_id']; ?>"><?PHP echo $row_customer['customer_code']."--".$row_customer['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
