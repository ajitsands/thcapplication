<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id = isset($_POST['v_cust_id']) ? $_POST['v_cust_id'] : (isset($_GET['v_cust_id']) ? $_GET['v_cust_id'] : '');
//echo $cus_id.'id';
if(!empty($cus_id) && is_numeric($cus_id) && intval($cus_id) > 0)
{
    //echo "Select customer_id,customer_name,customer_code from tbl_customers where customer_id=".$cus_id;
    $result_customer_location = mysqli_query($varDBConnection,"Select customer_id,customer_name,customer_code from tbl_customers where customer_id=".intval($cus_id));
}
else
{
    $result_customer_location = mysqli_query($varDBConnection,"Select customer_id,customer_name,customer_code from tbl_customers where customer_status='Active'");
}
 	
?>


<span class="form-text text-muted font-weight-bold"><font color="black">Customer Name &nbsp;<span style="color:red;">*</span></font></span>  
     <select data-placeholder="Select Customer Name" id="select_customer_for_customer_location" class="form-control form-control-select2" data-fouc tabindex=1>
         <option value="select">Select Customer Name</option>
        <?PHP 	while($row_customer_location=mysqli_fetch_assoc($result_customer_location)) { ?>
          <option value="<?PHP echo $row_customer_location['customer_id']; ?>"><?PHP echo $row_customer_location['customer_code'].'--'.$row_customer_location['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	  
