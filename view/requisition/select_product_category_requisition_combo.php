<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_prdt_cat_master = mysqli_query($varDBConnection,"Select distinct product_category_id,product_category_name from tbl_product_category ");
?>


	
     <select data-placeholder="Select Category Type" id="select_product_category_for_master" class="form-control form-control-select2" data-fouc tabindex=5>
         <option value="select">Select Category Type</option>
        <?PHP 	while($row_prdt_cat_master=mysqli_fetch_assoc($result_prdt_cat_master)) { ?>
          <option value="<?PHP echo $row_prdt_cat_master['product_category_id']; ?>"><?PHP echo $row_prdt_cat_master['product_category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Product Category Type</font><span style="color:red;">*</span> &nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_category_req"><i class="icon-plus22"></i></button></span>
