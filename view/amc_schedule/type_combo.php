<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select asset_type_id,asset_type_name from  tbl_asset_type where asset_type_status='Active' and category_id=".$_POST['category_id']);
	
?>


    <label class="font-weight-semibold text-muted mb-1">Type <span class="text-danger">*</span></label>
    <select class="form-control select-search" id="select_type" name="select_type" data-placeholder="Select Type" data-fouc>
	    <option value="0">Select Type</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['asset_type_id']; ?>"><?PHP echo $row['asset_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     