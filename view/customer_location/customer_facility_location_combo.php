<?PHP  
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();


$result_location_for_customer_location = mysqli_query($varDBConnection,"select location_id,location_name,location_code from  tbl_location where location_status='Active'");
 	


 	
?>

<span class="form-text text-muted font-weight-bold"><font color="black">Location &nbsp;<span style="color:red;">*</span></font></span>    

     <select data-placeholder="Select location" id="select_location_for_customer_location" class="form-control form-control-select2" data-fouc tabindex=2>
         <option value="select">Select Location</option>
        <?PHP 	while($row_location_for_customer_location=mysqli_fetch_assoc($result_location_for_customer_location)) { ?>
          <option value="<?PHP echo $row_location_for_customer_location['location_id']; ?>"><?PHP echo $row_location_for_customer_location['location_code'].'--'.$row_location_for_customer_location['location_name'];?></option>
        
        <?PHP } ?>
      </select>
     	
