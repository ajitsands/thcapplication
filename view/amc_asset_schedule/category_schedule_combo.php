<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$cus_id=$_POST['v_cust_id'];
  
   if($_POST['con']=='amc_schedule_assets')
{
    $result = mysqli_query($varDBConnection,"select distinct asset_category_id,asset_category_name from tbl_assets where customer_id='".$cus_id."' ");
}
else
{
     $result = mysqli_query($varDBConnection,"select distinct asset_category_id,asset_category_name from tbl_assets where customer_id='".$cus_id."' and amc_ref_no='".$_POST['v_amc_ref_no']."'");
}
 
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_category_for_schedule" data-placeholder="Select Category" data-fouc>
	    <option value="select">Select Category</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['asset_category_id']; ?>"><?PHP echo $row['asset_category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Category&nbsp;<span style="color:red;">*</span> </font></span>
