<?PHP include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_prdt_cat_master = mysqli_query($varDBConnection,"Select product_category_id,product_category_name from tbl_product_category where product_category_status='Active'");
?>


<div class="col-lg-4 col-md-6 col-sm-12" id="">	
     <select data-placeholder="Select Category Type" id="select_product_category_for_master" class="form-control form-control-select2" data-fouc tabindex=1>
         <option value="select">SELECT CATEGORY TYPE</option>
        <?PHP 	while($row_prdt_cat_master=mysqli_fetch_assoc($result_prdt_cat_master)) { ?>
          <option value="<?PHP echo $row_prdt_cat_master['product_category_id']; ?>"><?PHP echo $row_prdt_cat_master['product_category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">PRODUCT CATEGORY TYPE</font></span>
</div>