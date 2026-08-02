<?PHP 
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id=$_POST['v_cust_id'];
$result_building_for_customer_location = mysqli_query($varDBConnection,"select building_id, building_name,building_code from   tbl_building where building_status='Active'");
// if($cus_id!='')
// {
//     $result_building_for_customer_location = mysqli_query($varDBConnection,"select  building_id,building_name,building_code from   tbl_customer_location where customer_id=".$cus_id);
 
// }
// else
// {
//     $result_building_for_customer_location = mysqli_query($varDBConnection,"select building_id, building_name,building_code from   tbl_customer_location");
 
// }
//echo "select building_name from   tbl_customer_location where customer_id=".$cus_id;
 	//echo "select building_name from  tbl_customer_location where customer_id=".$cus_id;
?>


	<span class="form-text text-muted font-weight-bold"><font color="black">Select Building &nbsp;<span style="color:red;">*</span></font></span>    

     <select data-placeholder="Select Building" id="select_building_for_customer_location" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Building</option>
        <?PHP 	while($row_building_for_customer_location=mysqli_fetch_assoc($result_building_for_customer_location)) { ?>
          <option value="<?PHP echo $row_building_for_customer_location['building_id']; ?>"><?PHP echo   $row_building_for_customer_location['building_code'].'--'.$row_building_for_customer_location['building_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	