<?PHP 
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();


$cus_id=$_POST['v_cust_id'];
if($cus_id!='')
{
    $result_location_for_customer_location = mysqli_query($varDBConnection,"select location_id,location_name,location_code from   tbl_customer_location where customer_id=".$cus_id);
 
}
else
{
    $result_location_for_customer_location = mysqli_query($varDBConnection,"select location_id,location_name,location_code from   tbl_customer_location ");
 
}
 	//echo "select location_id,location_name from   tbl_customer_location where customer_id=".$cus_id;
?>


	
     <select data-placeholder="Select location" id="select_location_for_customer_location_assets" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Location</option>
        <?PHP 	while($row_location_for_customer_location=mysqli_fetch_assoc($result_location_for_customer_location)) { ?>
          <option value="<?PHP echo $row_location_for_customer_location['location_id']; ?>"><?PHP echo $row_location_for_customer_location['location_code'].'--'.$row_location_for_customer_location['location_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Location &nbsp;<span style="color:red;">*</span></font></span>    
