<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id=$_POST['v_cust_id'];
if($_POST['con']=='amc_schedule_assets')
{
   $result_building = mysqli_query($varDBConnection,"select DISTINCT building_id,asset_building from tbl_assets where customer_id='".$cus_id."' ");
}
else
{
    $result_building = mysqli_query($varDBConnection,"select DISTINCT building_id,asset_building from tbl_assets where customer_id='".$cus_id."' and amc_ref_no='".$_POST['v_amc_ref_no']."'");
}
 
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_building_for_schedule" data-placeholder="Select Building" data-fouc>
	    <option>Select Building</option>
	    
	   <?PHP 	while($row_building=mysqli_fetch_assoc($result_building)) { ?>
          <option value="<?PHP echo $row_building['building_id']; ?>"><?PHP echo $row_building['asset_building']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">BUILDING&nbsp;<span style="color:red;">*</span> </font></span>
