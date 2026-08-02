<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select asset_type_id,asset_type_name from   tbl_asset_type where asset_type_status='Active' and category_id=".$_POST['category_id']);

	?>


	<span class="form-text text-muted font-weight-bold"><font color="black">Type&nbsp;<span style="color:red;">*</span> </font></span>

   
     <select class="form-control form-control-select2 classtype" id="select_asset_type" name="select_asset_type" data-placeholder="Select Type" data-fouc>
	    <option value="select">Select Type</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
	    <?php if($_POST['sel_type_ids']==$row['asset_type_id']) {?>
          <option value="<?PHP echo $row['asset_type_id']; ?>" selected><?PHP echo $row['asset_type_name']; ?></option>
        <?php  } else {?>
        <option value="<?PHP echo $row['asset_type_id']; ?>" ><?PHP echo $row['asset_type_name']; ?></option>
        <?PHP }} ?>
      </select>
     