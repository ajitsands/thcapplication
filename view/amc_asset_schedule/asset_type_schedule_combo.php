<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id=$_POST['v_cust_id'];
if($_POST['con']=='amc_schedule_assets')
{
   $result_asset_type = mysqli_query($varDBConnection,"select distinct asset_type_id,asset_type_name from tbl_assets where customer_id='".$cus_id."' ");
}
else
{
    $result_asset_type = mysqli_query($varDBConnection,"select distinct asset_type_id,asset_type_name from tbl_assets where customer_id='".$cus_id."' and amc_ref_no='".$_POST['v_amc_ref_no']."'");
}
 
 	
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_asset_type_for_schedule" data-placeholder="Select Type" data-fouc>
	    <option value="select">Select Type</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result_asset_type)) { ?>
          <option value="<?PHP echo $row['asset_type_id']; ?>"><?PHP echo $row['asset_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Type&nbsp;<span style="color:red;">*</span> </font></span>
