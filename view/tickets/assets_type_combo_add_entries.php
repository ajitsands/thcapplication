<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select asset_type_id,asset_type_name from   tbl_asset_type where asset_type_status='Active' and category_id=".$_POST['category_id']);

	?>


<span class="form-text text-muted font-weight-bold"><font color="black">Type&nbsp;<span style="color:red;">*</span> </font></span>

   
     <select class="form-control form-control-select2 classtype_add_entries" id="select_asset_type_add_entries" name="select_asset_type_add_entries" data-placeholder="Select Type" data-fouc>
	    <option value="select">Select Type</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
	    
        <option value="<?PHP echo $row['asset_type_id']; ?>" ><?PHP echo $row['asset_type_name']; ?></option>
        <?PHP } ?>
      </select>
     	