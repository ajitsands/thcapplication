<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id = isset($_POST['v_cust_id']) ? $_POST['v_cust_id'] : (isset($_GET['v_cust_id']) ? $_GET['v_cust_id'] : '');
if(!empty($cus_id)) {
    $result_location = mysqli_query($varDBConnection,"select DISTINCT location_id,asset_location from  tbl_assets where customer_id='".mysqli_real_escape_string($varDBConnection, $cus_id)."'");
} else {
    $result_location = mysqli_query($varDBConnection,"select DISTINCT location_id,asset_location from  tbl_assets");
}
	
?>

	<span class="form-text text-muted font-weight-bold"><font color="black">Location&nbsp;<span style="color:red;">*</span> </font></span>

     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_location_assign_asset" data-placeholder="Select Location" data-fouc>
	   <option>Select Location</option>
	    
	   <?PHP 	while($row_location=mysqli_fetch_assoc($result_location)) { ?>
          <option value="<?PHP echo $row_location['location_id']; ?>"><?PHP echo $row_location['asset_location']; ?></option>
        
        <?PHP } ?>
      </select>
     
