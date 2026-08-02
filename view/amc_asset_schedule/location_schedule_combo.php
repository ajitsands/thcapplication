<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id=$_POST['v_cust_id'];
if($_POST['con']=='amc_schedule_assets')
{
    $result_location = mysqli_query($varDBConnection,"select DISTINCT location_id,asset_location from  tbl_assets where customer_id='".$cus_id."' ");
}
else
{
    $result_location = mysqli_query($varDBConnection,"select DISTINCT location_id,asset_location from  tbl_assets where customer_id='".$cus_id."' and amc_ref_no='".$_POST['v_amc_ref_no']."'");
}
 
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_location_for_schedule" data-placeholder="Select Location" data-fouc>
	   <option>Select Location</option>
	    
	   <?PHP 	while($row_location=mysqli_fetch_assoc($result_location)) { ?>
          <option value="<?PHP echo $row_location['location_id']; ?>"><?PHP echo $row_location['asset_location']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">LOCATION&nbsp;<span style="color:red;">*</span> </font></span>
