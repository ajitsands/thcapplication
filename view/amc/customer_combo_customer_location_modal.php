<?PHP 
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id = isset($_POST['v_cust_id']) ? $_POST['v_cust_id'] : (isset($_GET['v_cust_id']) ? $_GET['v_cust_id'] : '');
if(!empty($cus_id) && is_numeric($cus_id) && intval($cus_id) > 0)
{
  	$result_customer_location = mysqli_query($varDBConnection,"Select  customer_id,customer_name,customer_code from tbl_customers where customer_id=".intval($cus_id));
}
else
{
	$result_customer_location = mysqli_query($varDBConnection,"Select  customer_id,customer_name,customer_code from tbl_customers");
}
//echo "Select  customer_id,customer_name,customer_code from tbl_customers where customer_id=".$cus_id;
 

?>


     <select data-placeholder="Select Customer Name" id="select_customer_for_customer_location" class="form-control form-control-select2" data-fouc>
         
        <?PHP 	while($row_customer_location=mysqli_fetch_assoc($result_customer_location)) { ?>
          <option value="<?PHP echo $row_customer_location['customer_id']; ?>"><?PHP echo $row_customer_location['customer_code'].'--'.$row_customer_location['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">CUSTOMER NAME &nbsp;<span style="color:red;">*</span></font></span>    
