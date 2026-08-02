<?PHP 
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConnn = new DBConnection();
$varDBConnectionn = $DBConnn->ConnectToMYSQL();

$v_category_type_id= $_POST['v_category_type_id'];
 	$result_asset_type_for_service = mysqli_query($varDBConnectionn,"select asset_type_id,asset_type_name from tbl_asset_type where asset_type_status='Active' and category_id='".$v_category_type_id."'");
 	
?>

<span class="form-text text-muted font-weight-bold"><font color="black">ASSET TYPE&nbsp;<span style="color:red;">*</span></font></span>

     <select data-placeholder="Select Asset Type" id="select_asset_type_for_service" class="form-control form-control-select2" data-fouc>
         <option value="select">SELECT ASSET TYPE</option>
        <?PHP 	while($row_asset_type_for_service=mysqli_fetch_assoc($result_asset_type_for_service)) { ?>
          <option value="<?PHP echo $row_asset_type_for_service['asset_type_id']; ?>"><?PHP echo $row_asset_type_for_service['asset_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
