<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select asset_id,asset_ref_no from   tbl_assets where asset_status='Active' and asset_category_id=".$_POST['category_id']." and asset_type_id=".$_POST['type_id']." and customer_id=".$_POST['customer_id']." and location_id=".$_POST['location_id']." and building_id=".$_POST['building_id']."");
 

	?>


	<span class="form-text text-muted font-weight-bold"><font color="black">Assets&nbsp;<span style="color:red;">*</span> </font></span>
   
     <select class="form-control form-control-select2 classasset_add_entries" id="select_asset_add_entries" name="select_asset_add_entries" data-placeholder="Select Type" data-fouc>
	    <option value="0">Select Asset</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
	   
        <option value="<?PHP echo $row['asset_id']; ?>" ><?PHP echo $row['asset_ref_no']; ?></option>
        <?PHP } ?>
      </select>
     
