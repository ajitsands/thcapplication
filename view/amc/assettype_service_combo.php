<?PHP

include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$cus_id=$_POST['v_cust_id'];
 $result_assettype = mysqli_query($varDBConnection,"select DISTINCT asset_type_id,asset_type_name from  tbl_assets where customer_id='".$cus_id."'");
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_assettype" data-placeholder="Select Asset Type" data-fouc>
	    <option>Select Asset Type</option>
	    
	   <?PHP 	while($row_assettype=mysqli_fetch_assoc($result_assettype)) { ?>
          <option value="<?PHP echo $row_assettype['asset_type_id']; ?>"><?PHP echo $row_assettype['asset_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">ASSET TYPE&nbsp;<span style="color:red;">*</span> </font></span>
