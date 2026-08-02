<?PHP 
include "../../model/db_connection/connection.php" ;
$DBConnn = new DBConnection();
$varDBConnectionn_new = $DBConnn->ConnectToMYSQL();

$v_prdt_type_id_master= $_POST['v_prdt_type_id_master'];
	$result_product_item_for_master = mysqli_query($varDBConnectionn_new,"select product_item_id,product_item_name from  tbl_product_items where item_status='Active' and product_type_id='".$v_prdt_type_id_master."'");
 	
?>
     <select data-placeholder="Select Product Item" id="select_product_item_for_master" class="form-control form-control-select2" data-fouc>
         <option value="select">SELECT PRODUCT ITEM</option>
        <?PHP 	while($row_product_item_for_master=mysqli_fetch_assoc($result_product_item_for_master)) { ?>
          <option value="<?PHP echo $row_product_item_for_master['product_item_id']; ?>"><?PHP echo $row_product_item_for_master['product_item_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">SELECT PRODUCT ITEM</font></span>
